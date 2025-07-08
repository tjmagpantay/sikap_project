<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';

use Google\Service\Oauth2 as Google_Service_Oauth2;

class GoogleAuthController {
    private $userModel;
    private $jobseekerModel; 
    private $config;

    public function __construct() {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
        $this->config = require __DIR__ . '/../../config/google_oauth.php';
    }

    public function initiateLogin() {
        $type = $_GET['type'] ?? 'jobseeker';
        $client = new Google_Client();
        $client->setClientId($this->config['client_id']);
        $client->setClientSecret($this->config['client_secret']);
        $client->setRedirectUri($this->config['redirect_uri']);
        $client->addScope('email');
        $client->addScope('profile');
        // Add type to state for callback
        $state = bin2hex(random_bytes(8)) . '|' . $type;
        $_SESSION['oauth2state'] = $state;
        $client->setState($state);
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function handleCallback() {
        try {
            $client = new \Google_Client();
            $client->setClientId($this->config['client_id']);
            $client->setClientSecret($this->config['client_secret']);
            $client->setRedirectUri($this->config['redirect_uri']);

            if (isset($_GET['code'])) {
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($token);

                $google_oauth = new Google_Service_Oauth2($client);
                $google_account_info = $google_oauth->userinfo->get();

                $email = $google_account_info->email;
                $googleId = $google_account_info->id;
                $name = trim(($google_account_info->givenName ?? '') . ' ' . ($google_account_info->familyName ?? ''));
                // Extract user type from state
                $state = $_GET['state'] ?? '';
                $type = 'jobseeker';
                if ($state) {
                    $parts = explode('|', $state);
                    if (count($parts) === 2) {
                        $type = $parts[1];
                    }
                }
                $userType = $type;
                $roleId = ($userType === 'employer') ? \User::ROLE_EMPLOYER : \User::ROLE_JOBSEEKER;
                $status = ($userType === 'employer') ? 'pending' : 'active';
                // Check if user exists by google_id or email
                $user = $this->userModel->findByGoogleId($googleId);
                if (!$user) {
                    $user = $this->userModel->findByEmail($email);
                }
                if (!$user) {
                    // Create new user with all required fields
                    try {
                        $user_id = $this->userModel->createWithGoogle($email, $googleId, $name, $roleId, $status);
                    } catch (\Throwable $ex) {
                        $user_id = false;
                    }
                    if ($user_id) {
                        // Create minimal jobseeker or employer profile
                        if ($userType === 'employer') {
                            require_once __DIR__ . '/../models/Employer.php';
                            $employerModel = new \Employer();
                            $employerModel->createMinimal($user_id, $name, $email);
                        } else {
                            $this->jobseekerModel->createMinimal($user_id, $name, $email);
                        }
                        $user = $this->userModel->findByEmail($email);
                    }
                } else {
                    // User exists, check if they have the requested role
                    $user_id = $user['user_id'];
                    $hasRole = ($user['role_id'] == $roleId);
                    $db = $this->userModel->getDb();
                    if (!$hasRole) {
                        // Add role to user_roles
                        $stmt = $db->prepare("SELECT 1 FROM user_roles WHERE user_id = ? AND role_id = ?");
                        $stmt->execute([$user_id, $roleId]);
                        if (!$stmt->fetch()) {
                            $stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
                            $stmt->execute([$user_id, $roleId]);
                        }
                        // Create minimal profile if not exists
                        if ($userType === 'employer') {
                            require_once __DIR__ . '/../models/Employer.php';
                            $employerModel = new \Employer();
                            $empProfile = $employerModel->findByUserId($user_id);
                            if (!$empProfile) {
                                $employerModel->createMinimal($user_id, $name, $email);
                            }
                        } else {
                            $jsProfile = $this->jobseekerModel->findByUserId($user_id);
                            if (!$jsProfile) {
                                $this->jobseekerModel->createMinimal($user_id, $name, $email);
                            }
                        }
                        // Re-fetch user with new role
                        $user = $this->userModel->findByEmail($email);
                    }
                    // Always set session to the role/profile the user actually has
                    require_once __DIR__ . '/../models/Employer.php';
                    $employerModel = new \Employer();
                    $empProfile = $employerModel->findByUserId($user_id);
                    $jsProfile = $this->jobseekerModel->findByUserId($user_id);
                    if ($empProfile) {
                        $user['role_id'] = \User::ROLE_EMPLOYER;
                        $user['role_name'] = 'employer';
                    } elseif ($jsProfile) {
                        $user['role_id'] = \User::ROLE_JOBSEEKER;
                        $user['role_name'] = 'jobseeker';
                    }
                }

                if ($user) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['email'] = $user['email'];

                    // Redirect to dashboard or profile completion
                    if ($user['role_id'] == \User::ROLE_EMPLOYER) {
                        header('Location: ?page=employer-dashboard');
                        exit;
                    } elseif ($user['role_id'] == \User::ROLE_JOBSEEKER) {
                        if ($this->userModel->hasCompleteProfile($user['user_id'], \User::ROLE_JOBSEEKER)) {
                            header('Location: ?page=jobseeker-dashboard');
                        } else {
                            header('Location: ?page=complete-jobseeker-profile');
                        }
                        exit;
                    } else {
                        header('Location: ?page=landing');
                        exit;
                    }
                }
            }
            // If something goes wrong, redirect to login page with error
            if ($userType === 'employer') {
                header('Location: ?page=login-employer&error=' . urlencode('Google authentication failed'));
            } else {
                header('Location: ?page=login-jobseeker&error=' . urlencode('Google authentication failed'));
            }
            exit;
        } catch (Exception $e) {
            $userType = 'jobseeker';
            $state = $_GET['state'] ?? '';
            if ($state) {
                $parts = explode('|', $state);
                if (count($parts) === 2) {
                    $userType = $parts[1];
                }
            }
            if ($userType === 'employer') {
                header('Location: ?page=login-employer&error=' . urlencode('An error occurred during Google authentication'));
            } else {
                header('Location: ?page=login-jobseeker&error=' . urlencode('An error occurred during Google authentication'));
            }
            exit;
        }
    }
}
