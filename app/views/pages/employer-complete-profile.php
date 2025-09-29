<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Employer Profile</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form class="w-full max-w-2xl p-8 bg-white rounded shadow-md" method="POST" action="?page=employer-complete-profile" enctype="multipart/form-data">
        <h2 class="mb-6 text-2xl font-bold text-center">Complete Your Employer Profile</h2>
        <?php if (!empty($error)) : ?>
            <div class="mb-4 text-sm text-center text-red-600"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
            <div>
                <label class="block mb-1 font-medium" for="first_name">First Name</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="first_name" name="first_name" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="middle_name">Middle Name</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="middle_name" name="middle_name">
            </div>
            <div>
                <label class="block mb-1 font-medium" for="last_name">Last Name</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="position">Position</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="position" name="position" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="contact_no">Contact No.</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="contact_no" name="contact_no" required>
            </div>
        </div>
        <h3 class="mt-8 mb-4 text-xl font-semibold">Business Information</h3>
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
            <div>
                <label class="block mb-1 font-medium" for="business_name">Business Name</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="business_name" name="business_name" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_logo">Business Logo</label>
                <input class="w-full px-3 py-2 border rounded" type="file" id="business_logo" name="business_logo" accept="image/*">
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_address">Business Address</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="business_address" name="business_address" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_type">Business Type</label>
                <select class="w-full px-3 py-2 border rounded" id="business_type" name="business_type" required>
                    <option value="">Select Type</option>
                    <option value="sole_proprietorship">Sole Proprietorship</option>
                    <option value="partnership">Partnership</option>
                    <option value="corporation">Corporation</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_size">Business Size</label>
                <select class="w-full px-3 py-2 border rounded" id="business_size" name="business_size" required>
                    <option value="">Select Size</option>
                    <option value="micro">Micro</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_desc">Business Description</label>
                <textarea class="w-full px-3 py-2 border rounded" id="business_desc" name="business_desc" rows="3" required></textarea>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_email">Business Email</label>
                <input class="w-full px-3 py-2 border rounded" type="email" id="business_email" name="business_email" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_contact">Business Contact</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="business_contact" name="business_contact" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_industry">Business Industry</label>
                <input class="w-full px-3 py-2 border rounded" type="text" id="business_industry" name="business_industry" required>
            </div>
            <div>
                <label class="block mb-1 font-medium" for="business_socials">Business Socials (JSON)</label>
                <textarea class="w-full px-3 py-2 border rounded" id="business_socials" name="business_socials" rows="2"></textarea>
            </div>
        </div>
        <button class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700" type="submit">Save Profile</button>
    </form>
</body>

</html>