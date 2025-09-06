<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load mailer configuration
    $config = require_once __DIR__ . '/../../../../config/mailer.php';
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $config['port'];

        // Recipients
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress('peso.sikap.dev2025@gmail.com', 'PESO Development Team'); 

        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $feedbackType = $_POST['feedback_type'] ?? '';
        $message = $_POST['message'] ?? '';
        $rating = $_POST['rating'] ?? '';

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Sikap Feedback: {$feedbackType}";
        
        // Create HTML message
        $htmlMessage = "
            <h2>Feedback Submission from Sikap User</h2>
            <p><strong>From:</strong> {$name} ({$email})</p>
            <p><strong>Feedback Type:</strong> {$feedbackType}</p>
            <p><strong>Rating:</strong> {$rating}/5</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        
        $mail->Body = $htmlMessage;
        $mail->AltBody = strip_tags($htmlMessage);

        $mail->send();
        $success = "Thank you for your feedback! We appreciate your input.";
    } catch (Exception $e) {
        $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Share Your Feedback</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Help us improve Sikap by sharing your experience and suggestions
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <form method="POST" class="space-y-6">
                <?php if (isset($success)): ?>
                    <div class="p-4 rounded-lg bg-green-50">
                        <p class="text-green-800"><?php echo $success; ?></p>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="p-4 rounded-lg bg-red-50">
                        <p class="text-red-800"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <!-- Name and Email -->
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" id="name" name="name" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Your Email</label>
                        <input type="email" id="email" name="email" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Feedback Type -->
                <div>
                    <label for="feedback_type" class="block mb-2 text-sm font-medium text-gray-700">Feedback Type</label>
                    <select id="feedback_type" name="feedback_type" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select feedback type</option>
                        <option value="General Feedback">General Feedback</option>
                        <option value="Bug Report">Bug Report</option>
                        <option value="Feature Request">Feature Request</option>
                        <option value="User Experience">User Experience</option>
                        <option value="Performance Issue">Performance Issue</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Rate Your Experience</label>
                    <div class="flex gap-4">
                        <div class="flex items-center">
                            <input type="radio" id="rating1" name="rating" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="rating1" class="ml-2 text-gray-700">1</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="rating2" name="rating" value="2" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="rating2" class="ml-2 text-gray-700">2</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="rating3" name="rating" value="3" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="rating3" class="ml-2 text-gray-700">3</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="rating4" name="rating" value="4" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="rating4" class="ml-2 text-gray-700">4</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="rating5" name="rating" value="5" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="rating5" class="ml-2 text-gray-700">5</label>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Your Feedback</label>
                    <textarea id="message" name="message" rows="5" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Please share your experience, suggestions, or report any issues..."></textarea>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Feedback
                    </button>
                </div>
            </form>

            <!-- Privacy Notice -->
            <div class="p-4 mt-8 text-sm text-gray-600 border-t">
                <p>Your feedback helps us improve Sikap. We may use your feedback for service improvement, but we'll never share your personal information with third parties.</p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
