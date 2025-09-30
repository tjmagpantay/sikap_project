<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/Employer.php';

use App\Models\Mailer;

class UserController
{
    private $userModel;
    private $jobseekerModel;
    private $employerModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
        $this->employerModel = new Employer();
    }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role_id']; // Use role_id
                $_SESSION['role_name'] = $user['role_name'] ?? 'unknown'; // Use role_name from JOIN
                $_SESSION['email'] = $user['email'];

                // Check for redirect after login
                $redirectUrl = $_SESSION['redirect_after_login'] ?? null;
                unset($_SESSION['redirect_after_login']); // Clear the redirect URL

                if ($redirectUrl) {
                    header('Location: ' . $redirectUrl);
                    exit;
                }

                // Otherwise, redirect based on role ID
                if ($user['role_id'] == User::ROLE_ADMIN) {
                    header('Location: ?page=admin-dashboard');
                } elseif ($user['role_id'] == User::ROLE_EMPLOYER) {
                    // Check if profile is complete
                    if ($this->userModel->hasCompleteProfile($user['user_id'], User::ROLE_EMPLOYER)) {
                        header('Location: ?page=employer-dashboard');
                    } else {
                        header('Location: ?page=complete-employer-profile');
                    }
                } elseif ($user['role_id'] == User::ROLE_JOBSEEKER) {
                    // Check if profile is complete
                    if ($this->userModel->hasCompleteProfile($user['user_id'], User::ROLE_JOBSEEKER)) {
                        header('Location: ?page=jobseeker-dashboard');
                    } else {
                        header('Location: ?page=complete-jobseeker-profile');
                    }
                } else {
                    header('Location: ?page=landing');
                }
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
        include __DIR__ . '/../views/pages/login.php';
    }

    public function signup()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (empty($email) || empty($password) || empty($role)) {
                $error = 'Please fill in all fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Create user with selected role
                $role_id = ($role === 'employer') ? User::ROLE_EMPLOYER : User::ROLE_JOBSEEKER;
                $status = ($role === 'employer') ? 'pending' : 'active'; // Employers need approval

                $user_id = $this->userModel->create($email, $hashed, $role_id, $status);

                if ($user_id) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = $role_id;
                    $_SESSION['role_name'] = $role;
                    $_SESSION['email'] = $email;

                    // Redirect to complete profile
                    if ($role === 'employer') {
                        header('Location: ?page=complete-employer-profile');
                    } else {
                        header('Location: ?page=complete-jobseeker-profile');
                    }
                    exit;
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }
        include __DIR__ . '/../views/pages/signup.php';
    }

    public function forgotPassword()
    {
        include __DIR__ . '/../views/pages/forgot-password.php';
    }

    public function forgotPasswordRequest()
    {
        $email = $_POST['email'] ?? '';

        if (!$email) {
            $_SESSION['error'] = 'Email is required';
            header('Location: ?page=forgot-password');
            exit;
        }

        $user = $this->userModel->findUserByEmail($email);

        if (!$user) {
            $_SESSION['error'] = 'Email not found';
            header('Location: ?page=forgot-password');
            exit;
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_user_id'] = $user['user_id'];
        $_SESSION['reset_user_type'] = $user['user_type'];
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires'] = time() + 300; // 5 minutes
        $_SESSION['otp_cooldown'] = time() + 300;

        // Send email
        if (Mailer::sendOTP($email, $otp)) {
            $_SESSION['success'] = 'OTP has been sent to your email';
            header('Location: ?page=verify-forgotpassword');
        } else {
            $_SESSION['error'] = 'Failed to send OTP';
            header('Location: ?page=forgot-password');
        }
        exit;
    }

    public function verifyForgotPasswordOtp()
    {
        if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expires'])) {
            $_SESSION['error'] = 'No OTP session found. Please start the password reset process again.';
            header('Location: ?page=forgot-password');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputOtp = isset($_POST['otp']) ? trim((string)$_POST['otp']) : '';
            $storedOtp = isset($_SESSION['otp']) ? (string)$_SESSION['otp'] : '';
            $expires = $_SESSION['otp_expires'] ?? 0;

            if ($inputOtp === '') {
                $_SESSION['error'] = 'OTP is required.';
                header('Location: ?page=verify-forgotpassword');
                exit;
            }

            if ($inputOtp !== $storedOtp) {
                $_SESSION['error'] = 'Invalid OTP.';
                header('Location: ?page=verify-forgotpassword');
                exit;
            }

            if (time() > $expires) {
                $_SESSION['error'] = 'OTP has expired.';
                header('Location: ?page=verify-forgotpassword');
                exit;
            }

            // OTP is correct, unset OTP so it can't be reused
            unset($_SESSION['otp'], $_SESSION['otp_expires'], $_SESSION['otp_cooldown']);
            $_SESSION['otp_verified'] = true;
            $_SESSION['success'] = 'OTP verified, you may now reset your password.';
            header('Location: ?page=reset-password');
            exit;
        }

        include __DIR__ . '/../views/pages/verify-forgotpassword.php';
    }

    public function resendOtp()
    {
        $cooldown = $_SESSION['otp_cooldown'] ?? 0;

        if (time() < $cooldown) {
            $_SESSION['error'] = 'Please wait before requesting another OTP';
            header('Location: ?page=verify-forgotpassword');
            exit;
        }

        $email = $_SESSION['reset_email'] ?? '';
        if (!$email) {
            $_SESSION['error'] = 'Please start the password reset process again';
            header('Location: ?page=forgot-password');
            exit;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires'] = time() + 300;
        $_SESSION['otp_cooldown'] = time() + 300;

        if (Mailer::sendOTP($email, $otp)) {
            $_SESSION['success'] = 'New OTP has been sent to your email';
        } else {
            $_SESSION['error'] = 'Failed to send new OTP';
        }

        header('Location: ?page=verify-forgotpassword');
        exit;
    }

    public function resetPassword()
    {
        if (empty($_SESSION['otp_verified'])) {
            $_SESSION['error'] = 'Please verify your OTP first.';
            header('Location: ?page=forgot-password');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Password must be at least 8 characters long';
                header('Location: ?page=reset-password');
                exit;
            }

            if ($password !== $confirm) {
                $_SESSION['error'] = 'Passwords do not match';
                header('Location: ?page=reset-password');
                exit;
            }

            $userId = $_SESSION['reset_user_id'] ?? null;
            $userType = $_SESSION['reset_user_type'] ?? '';

            if (!$userId) {
                $_SESSION['error'] = 'Invalid reset attempt';
                header('Location: ?page=forgot-password');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($this->userModel->updatePassword($userId, $hashedPassword)) {
                // Clear all reset-related session variables
                unset(
                    $_SESSION['reset_email'],
                    $_SESSION['reset_user_id'],
                    $_SESSION['reset_user_type'],
                    $_SESSION['otp'],
                    $_SESSION['otp_expires'],
                    $_SESSION['otp_cooldown'],
                    $_SESSION['otp_verified']
                );

                // Redirect to the correct login page based on user type
                if ($userType === 'employer' || $userType == User::ROLE_EMPLOYER) {
                    $_SESSION['success'] = 'Password has been reset successfully';
                    header('Location: ?page=login-employer');
                } else {
                    $_SESSION['success'] = 'Password has been reset successfully';
                    header('Location: ?page=login-jobseeker');
                }
            } else {
                $_SESSION['error'] = 'Failed to reset password';
                header('Location: ?page=reset-password');
            }
            exit;
        }

        include __DIR__ . '/../views/pages/reset-password.php';
    }

    public function handleGoogleLogin()
    {
        require_once __DIR__ . '/../../config/google_oauth.php';
        $config = require __DIR__ . '/../../config/google_oauth.php';
        $clientId = $config['client_id'];
        $clientSecret = $config['client_secret'];
        $redirectUri = $config['redirect_uri'];

        $userType = $_GET['type'] ?? $_POST['type'] ?? 'jobseeker';
        // 1. If no code, redirect to Google OAuth
        if (empty($_GET['code'])) {
            $state = bin2hex(random_bytes(8));
            $_SESSION['oauth2state'] = $state;
            $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?'
                . http_build_query([
                    'client_id' => $clientId,
                    'redirect_uri' => $redirectUri,
                    'response_type' => 'code',
                    'scope' => 'openid email profile',
                    'state' => $state . '|' . $userType,
                    'access_type' => 'online',
                    'prompt' => 'select_account',
                ]);
            header('Location: ' . $authUrl);
            exit;
        }

        // 2. Handle callback from Google
        $code = $_GET['code'];
        $state = $_GET['state'] ?? '';
        if (!$code || !$state) {
            $_SESSION['error'] = 'Google login failed: Missing code or state.';
            header('Location: ?page=login-' . $userType);
            exit;
        }
        // Parse state for CSRF and userType
        list($sessionState, $userTypeFromState) = explode('|', $state . '|');
        if (empty($_SESSION['oauth2state']) || $sessionState !== $_SESSION['oauth2state']) {
            $_SESSION['error'] = 'Invalid OAuth state.';
            header('Location: ?page=login-' . $userType);
            exit;
        }
        unset($_SESSION['oauth2state']);
        $userType = $userTypeFromState ?: $userType;

        // Exchange code for tokens
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $postFields = [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]; 
        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tokenData = json_decode($response, true);
        if (empty($tokenData['id_token'])) {
            $_SESSION['error'] = 'Failed to get Google token.';
            header('Location: ?page=login-' . $userType);
            exit;
        }
        $idToken = $tokenData['id_token'];
        // Decode ID token
        $payload = $this->verifyGoogleToken($idToken, $clientId);
        if (!$payload) {
            $_SESSION['error'] = 'Google login failed: Invalid token.';
            header('Location: ?page=login-' . $userType);
            exit;
        }
        $email = $payload['email'] ?? '';
        $googleId = $payload['sub'] ?? '';
        $name = $payload['name'] ?? ($payload['given_name'] ?? '');
        if (!$email || !$googleId) {
            $_SESSION['error'] = 'Google login failed: Missing email or ID.';
            header('Location: ?page=login-' . $userType);
            exit;
        }
        // First check if email already exists
        $existingUser = $this->userModel->findByEmail($email);
        
        if ($existingUser) {
            // User exists, verify they're using the correct role's login page
            $userRoleId = $existingUser['role_id'];
            $requestedRoleId = ($userType === 'employer') ? User::ROLE_EMPLOYER : User::ROLE_JOBSEEKER;
            
            if ($userRoleId !== $requestedRoleId) {
                $roleText = ($userRoleId == User::ROLE_EMPLOYER) ? 'Employer' : 'Jobseeker';
                $_SESSION['error'] = "This email is already registered as {$roleText}. Please use a different Google account.";
                header('Location: ?page=login-' . $userType);
                exit;
            }
            
            $userId = $existingUser['user_id'];
            $roleId = $existingUser['role_id'];
        } else {
            // Create new user with correct role
            $roleId = ($userType === 'employer') ? User::ROLE_EMPLOYER : User::ROLE_JOBSEEKER;
            $status = ($userType === 'employer') ? 'pending' : 'active';
            $userId = $this->userModel->createWithGoogle($email, $googleId, $name, $roleId, $status);
            
            if (!$userId) {
                $_SESSION['error'] = 'This email is already registered. Please use a different Google account.';
                header('Location: ?page=login-' . $userType);
                exit;
            }
            
            // Create profile
            if ($userType === 'employer') {
                $this->employerModel->createMinimal($userId, $name, $email, $googleId);
            } else {
                $this->jobseekerModel->createMinimal($userId, $name, $email, $googleId);
            }
        }
        // Set session and redirect
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $roleId;
        $_SESSION['role_name'] = $userType;
        $_SESSION['email'] = $email;
        $_SESSION['success'] = 'Logged in with Google!';
        if ($roleId == User::ROLE_EMPLOYER) {
            header('Location: ?page=employer-dashboard');
        } else {
            header('Location: ?page=jobseeker-dashboard');
        }
        exit;
    }

    private function verifyGoogleToken($credential, $clientId)
    {
        // Use Google API to verify JWT
        $parts = explode('.', $credential);
        if (count($parts) !== 3) return false;
        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        if (!$payload) return false;
        if (($payload['aud'] ?? '') !== $clientId) return false;
        if (($payload['exp'] ?? 0) < time()) return false;
        return $payload;
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?page=landing');
        exit;
    }
    
}
