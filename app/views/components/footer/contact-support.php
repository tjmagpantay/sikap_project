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

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Contact Support</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Need help? Send us a message and we'll get back to you as soon as possible.
            </p>
        </div>

        <!-- Main Content Grid - Form and Map Inline -->
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Contact Form -->
            <div class="p-6 bg-white rounded-lg shadow md:p-8">
                <h2 class="mb-6 text-xl font-semibold text-gray-900">Send us a Message</h2>
                
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

                    <div class="grid gap-6 sm:grid-cols-2">
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

                    <div>
                        <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700">I am a</label>
                        <select id="user_type" name="user_type" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select user type</option>
                            <option value="Job Seeker">Job Seeker</option>
                            <option value="Employer">Employer</option>
                            <option value="Guest">Guest</option>
                        </select>
                    </div>

                    <div>
                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subject</label>
                        <input type="text" id="subject" name="subject" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="5" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Map and Contact Information -->
            <div class="space-y-8">
                <!-- Office Information -->
                <div class="p-6 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">PESO Rosario Office</h2>
                    <div class="space-y-3 text-gray-700">
                        <p class="flex items-start">
                            <svg class="w-5 h-5 mt-1 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Public Employment Service Office (PESO) - Rosario, Batangas, Philippines</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>(043) 123-4567</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>peso.rosario@example.com</span>
                        </p>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <h2 class="p-4 text-xl font-semibold text-gray-900 border-b">Our Location</h2>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1369.6288128961426!2d121.20611068042547!3d13.845323687122285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd142fe515b14d%3A0x620b03b019e1f3ba!2sPublic%20Employment%20Service%20Office%20(PESO)%20-%20Rosario!5e0!3m2!1sen!2sph!4v1757165465316!5m2!1sen!2sph" 
                            width="100%" 
                            height="350" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-80 sm:h-96"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>