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
        $mail->addAddress('peso.sikap.dev2025@gmail.com', 'PESO Support'); // Support email address

        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
        $userType = $_POST['user_type'] ?? '';

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Support Request: $subject";

        // Create HTML message
        $htmlMessage = "
            <h2>Support Request from Sikap User</h2>
            <p><strong>From:</strong> $name ($email)</p>
            <p><strong>User Type:</strong> $userType</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";

        $mail->Body = $htmlMessage;
        $mail->AltBody = strip_tags($htmlMessage);

        $mail->send();
        $success = "Your message has been sent successfully. We'll get back to you soon.";
    } catch (Exception $e) {
        $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!-- Contact Support Section -->
<section id="contact-support" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Support Center</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Contact Support
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                Need assistance? Our support team is here to help you with any questions or issues you may have
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Contact Form -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8">
                <div class="mb-6">
                    <h2 class="mb-4 text-lg font-bold text-primary sm:text-xl">Send us a Message</h2>
                    <p class="text-sm text-gray-700">
                        Fill out the form below and our support team will get back to you as soon as possible. Please provide as much detail as possible to help us assist you better.
                    </p>
                </div>

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

                    <div class="grid gap-6 sm:grid-cols-2">
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

                    <div>
                        <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700">I am a *</label>
                        <select id="user_type" name="user_type" required
                            class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                            <option value="">Select user type</option>
                            <option value="Job Seeker">Job Seeker</option>
                            <option value="Employer">Employer</option>
                            <option value="PESO Staff">PESO Staff</option>
                            <option value="Partner Organization">Partner Organization</option>
                            <option value="Guest">Guest/Visitor</option>
                        </select>
                    </div>

                    <div>
                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subject *</label>
                        <input type="text" id="subject" name="subject" required placeholder="Brief description of your inquiry"
                            class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Message *</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Please provide detailed information about your inquiry or issue..."
                            class="block w-full px-4 py-3 transition-colors border border-gray-300 rounded-lg shadow-sm resize-none focus:ring-primary focus:border-primary"></textarea>
                        <p class="mt-2 text-xs text-gray-500">Please include any relevant details such as error messages, account information, or specific features you need help with.</p>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-6 py-3 text-sm font-medium text-white transition-colors rounded-lg shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information and Map -->
            <div class="space-y-6">
                <!-- Office Information -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h2 class="mb-4 text-lg font-bold text-primary sm:text-xl">PESO Rosario Office</h2>

                    <div class="space-y-4">
                        <div class="flex items-start p-3 border border-gray-200 rounded-lg">
                            <svg class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-800">Office Address</p>
                                <p class="text-sm text-blue-700">Public Employment Service Office (PESO)<br>Municipal Hall, Rosario, Batangas, Philippines</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 border border-gray-200 rounded-lg">
                            <svg class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-green-800">Phone Support</p>
                                <p class="text-sm text-green-700">(043) 555-0115<br>Monday-Friday, 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 border border-gray-200 rounded-lg">
                            <svg class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-purple-800">Email Support</p>
                                <p class="text-sm text-purple-700">support@peso-rosario.gov.ph<br>24-48 hour response time</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 border border-gray-200 rounded-lg">
                            <svg class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-yellow-800">Office Hours</p>
                                <p class="text-sm text-yellow-700">Monday to Friday: 8:00 AM - 5:00 PM<br>Saturday & Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b">
                        <h2 class="font-semibold text-gray-900 text-md">Our Location</h2>
                        <p class="text-sm text-gray-600">Visit us for in-person assistance</p>
                    </div>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1369.6288128961426!2d121.20611068042547!3d13.845323687122285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd142fe515b14d%3A0x620b03b019e1f3ba!2sPublic%20Employment%20Service%20Office%20(PESO)%20-%20Rosario!5e0!3m2!1sen!2sph!4v1757165465316!5m2!1sen!2sph"
                            width="100%"
                            height="350"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-80 sm:h-96"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Response Information -->
        <div class="p-6 mt-8 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-primary sm:text-xl">What to Expect</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <div class="p-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-blue-600 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-md">Quick Response</h3>
                    <p class="text-sm text-gray-600">We respond to all inquiries within 24-48 hours during business days</p>
                </div>

                <div class="p-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-green-600 bg-green-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-md">Expert Assistance</h3>
                    <p class="text-sm text-gray-600">Our trained support staff will provide personalized solutions</p>
                </div>

                <div class="p-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 text-yellow-400 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-md">Follow-up Support</h3>
                    <p class="text-sm text-gray-600">We ensure your issue is fully resolved with follow-up communication</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>