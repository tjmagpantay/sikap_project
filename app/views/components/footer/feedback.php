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

<!-- Feedback Section -->
<section id="feedback" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Support Center</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Share Your Feedback
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                Help us improve Sikap by sharing your experience, suggestions, and insights. Your feedback drives our continuous improvement efforts.
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8">
                <!-- Introduction -->
                <div class="mb-8">
                    <h2 class="mb-4 text-lg font-bold text-primary sm:text-xl">Your Voice Matters</h2>
                    <p class="text-sm text-gray-700">
                        We value your opinion and use your feedback to enhance the Sikap platform. Whether you're reporting a bug, suggesting a new feature, or sharing your overall experience, every piece of feedback helps us serve you better.
                    </p>
                </div>

                <!-- Feedback Form -->
                <form method="POST" class="space-y-6">
                    <?php if (isset($success)): ?>
                        <div class="p-4 text-green-700 rounded-lg bg-green-50">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="font-medium"><?php echo $success; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="p-4 text-red-700 rounded-lg bg-red-50">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-medium"><?php echo $error; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Personal Information -->
                    <div class="mb-6">
                        <h3 class="mb-4 font-semibold text-primary text-md">Personal Information</h3>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Your Name *</label>
                                <input type="text" id="name" name="name" required
                                    class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Your Email *</label>
                                <input type="email" id="email" name="email" required
                                    class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Details -->
                    <div class="mb-6">
                        <h3 class="mb-4 font-semibold text-primary text-md">Feedback Details</h3>

                        <!-- Feedback Type -->
                        <div class="mb-6">
                            <label for="feedback_type" class="block mb-2 text-sm font-medium text-gray-700">Feedback Category *</label>
                            <select id="feedback_type" name="feedback_type" required
                                class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                                <option value="">Select feedback category</option>
                                <option value="General Feedback">General Feedback</option>
                                <option value="Bug Report">Bug Report</option>
                                <option value="Feature Request">Feature Request</option>
                                <option value="User Experience">User Experience</option>
                                <option value="Performance Issue">Performance Issue</option>
                                <option value="Security Concern">Security Concern</option>
                                <option value="Accessibility">Accessibility</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Rating System -->
                        <div class="mb-6">
                            <label class="block mb-3 text-sm font-medium text-gray-700">Rate Your Overall Experience *</label>
                            <div class="flex flex-wrap gap-4">
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <input type="radio" id="rating1" name="rating" value="1" required class="w-4 h-4 border-gray-300 text-primary focus:ring-primary">
                                    <label for="rating1" class="ml-2 text-sm text-gray-700">1 - Very Poor</label>
                                </div>
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <input type="radio" id="rating2" name="rating" value="2" class="w-4 h-4 border-gray-300 text-primary focus:ring-primary">
                                    <label for="rating2" class="ml-2 text-sm text-gray-700">2 - Poor</label>
                                </div>
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <input type="radio" id="rating3" name="rating" value="3" class="w-4 h-4 border-gray-300 text-primary focus:ring-primary">
                                    <label for="rating3" class="ml-2 text-sm text-gray-700">3 - Average</label>
                                </div>
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <input type="radio" id="rating4" name="rating" value="4" class="w-4 h-4 border-gray-300 text-primary focus:ring-primary">
                                    <label for="rating4" class="ml-2 text-sm text-gray-700">4 - Good</label>
                                </div>
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <input type="radio" id="rating5" name="rating" value="5" class="w-4 h-4 border-gray-300 text-primary focus:ring-primary">
                                    <label for="rating5" class="ml-2 text-sm text-gray-700">5 - Excellent</label>
                                </div>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-6">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Your Detailed Feedback *</label>
                            <textarea id="message" name="message" rows="6" required
                                class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm resize-none focus:ring-primary focus:border-primary"
                                placeholder="Please share your experience, suggestions, bug reports, or any other feedback. The more specific you are, the better we can address your concerns or implement your suggestions."></textarea>
                            <p class="mt-2 text-xs text-gray-500">Minimum 10 characters. Be specific about issues, steps to reproduce bugs, or detailed feature requests.</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-6 py-3 text-sm font-medium text-white transition-colors rounded-lg shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Submit Feedback
                        </button>
                    </div>
                </form>

                <!-- Feedback Guidelines -->
                <div class="p-6 mt-8 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 font-semibold text-gray-800 text-md">Feedback Guidelines</h3>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 font-semibold text-green-800">What to Include</h4>
                            <ul class="ml-6 space-y-2 text-sm text-green-700 list-disc">
                                <li>Specific details about issues or suggestions</li>
                                <li>Steps to reproduce bugs or problems</li>
                                <li>Screenshots or examples when helpful</li>
                                <li>Your user type and context of use</li>
                                <li>Constructive suggestions for improvement</li>
                            </ul>
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 font-semibold text-blue-800">Response Time</h4>
                            <ul class="ml-6 space-y-2 text-sm text-blue-700 list-disc">
                                <li>General feedback: 5-7 business days</li>
                                <li>Bug reports: 2-3 business days</li>
                                <li>Critical issues: Within 24 hours</li>
                                <li>Feature requests: Reviewed monthly</li>
                                <li>Follow-up if additional info needed</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Privacy and Data Usage -->
                <div class="p-4 mt-6 text-sm text-gray-600 border border-gray-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="mb-1 font-medium text-gray-800">Privacy Notice</p>
                            <p>Your feedback is valuable to us and helps improve Sikap for all users. We may use your feedback for service enhancement and development purposes, but we will never share your personal information with third parties without your consent. All feedback is treated confidentially and used solely for platform improvement.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Impact Section -->
            <div class="p-6 mt-8 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                <h2 class="mb-4 text-lg font-bold text-primary sm:text-xl">How Your Feedback Makes a Difference</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="p-4">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-blue-600 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-md">Innovation</h3>
                        <p class="text-sm text-gray-600">Your feature requests drive our development roadmap and platform enhancements</p>
                    </div>

                    <div class="p-4">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-green-600 bg-green-100 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-md">Quality Improvement</h3>
                        <p class="text-sm text-gray-600">Bug reports help us maintain a stable, reliable platform for all users</p>
                    </div>

                    <div class="p-4">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-yellow-400 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-md">User Experience</h3>
                        <p class="text-sm text-gray-600">Your insights help us create a more intuitive and user-friendly platform</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>