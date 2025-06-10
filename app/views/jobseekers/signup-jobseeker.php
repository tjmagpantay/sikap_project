<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form class="w-full max-w-md p-8 bg-white rounded shadow-md" method="POST" action="?page=signup">
        <h2 class="mb-6 text-2xl font-bold text-center">Sign Up</h2>
        <?php if (!empty($error)) : ?>
            <div class="mb-4 text-sm text-center text-red-600"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="first_name">First Name</label>
            <input class="w-full px-3 py-2 border rounded" type="text" id="first_name" name="first_name" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="last_name">Last Name</label>
            <input class="w-full px-3 py-2 border rounded" type="text" id="last_name" name="last_name" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="email">Email</label>
            <input class="w-full px-3 py-2 border rounded" type="email" id="email" name="email" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="phone_number">Phone Number</label>
            <input class="w-full px-3 py-2 border rounded" type="text" id="phone_number" name="phone_number" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="password">Password</label>
            <input class="w-full px-3 py-2 border rounded" type="password" id="password" name="password" required>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-medium" for="confirm_password">Confirm Password</label>
            <input class="w-full px-3 py-2 border rounded" type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700" type="submit">Sign Up</button>
        <p class="mt-4 text-sm text-center">Already have an account? <a href="?page=login" class="text-blue-600 hover:underline">Login</a></p>
    </form>
</body>
</html> 