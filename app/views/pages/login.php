<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form class="w-full max-w-sm p-8 bg-white rounded shadow-md" method="POST" action="?page=login">
        <h2 class="mb-6 text-2xl font-bold text-center">Login</h2>
        <?php if (!empty($error)) : ?>
            <div class="mb-4 text-sm text-center text-red-600"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="mb-4">
            <label class="block mb-1 font-medium" for="email">Email</label>
            <input class="w-full px-3 py-2 border rounded" type="email" id="email" name="email" required>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-medium" for="password">Password</label>
            <input class="w-full px-3 py-2 border rounded" type="password" id="password" name="password" required>
        </div>
        <button class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700" type="submit">Login</button>
        <p class="mt-4 text-sm text-center">
          Don't have an account?
          <a href="?page=signup-jobseeker" class="text-blue-600 hover:underline">Sign up as Jobseeker</a>
        </p>
    </form>
</body>
</html>