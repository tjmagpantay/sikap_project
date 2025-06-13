<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-user"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Personal Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 2/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Basic personal data (name, contact info, address, etc.)
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 25%"></div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-red-400 fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=2">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required
                                   value="<?php echo htmlspecialchars($jobseeker['first_name'] ?? $_POST['first_name'] ?? $user['first_name'] ?? ''); ?>"
                                   placeholder="First Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required
                                   value="<?php echo htmlspecialchars($jobseeker['last_name'] ?? $_POST['last_name'] ?? $user['last_name'] ?? ''); ?>"
                                   placeholder="Last Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">
                            Middle Name
                        </label>
                        <div class="mt-1">
                            <input id="middle_name" name="middle_name" type="text"
                                   value="<?php echo htmlspecialchars($jobseeker['middle_name'] ?? $_POST['middle_name'] ?? $user['middle_name'] ?? ''); ?>"
                                   placeholder="Middle Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="suffix" class="block text-sm font-medium text-gray-700">
                            Suffix
                        </label>
                        <div class="mt-1">
                            <select id="suffix" name="suffix" class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="">Suffix</option>
                                <option value="Jr." <?php echo ($jobseeker['suffix'] ?? $_POST['suffix'] ?? '') === 'Jr.' ? 'selected' : ''; ?>>Jr.</option>
                                <option value="Sr." <?php echo ($jobseeker['suffix'] ?? $_POST['suffix'] ?? '') === 'Sr.' ? 'selected' : ''; ?>>Sr.</option>
                                <option value="II" <?php echo ($jobseeker['suffix'] ?? $_POST['suffix'] ?? '') === 'II' ? 'selected' : ''; ?>>II</option>
                                <option value="III" <?php echo ($jobseeker['suffix'] ?? $_POST['suffix'] ?? '') === 'III' ? 'selected' : ''; ?>>III</option>
                                <option value="IV" <?php echo ($jobseeker['suffix'] ?? $_POST['suffix'] ?? '') === 'IV' ? 'selected' : ''; ?>>IV</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                            Birthdate <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="date_of_birth" name="date_of_birth" type="date" required
                                   value="<?php echo htmlspecialchars($jobseeker['date_of_birth'] ?? $_POST['date_of_birth'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="sex" name="sex" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="">Gender</option>
                                <option value="Male" <?php echo ($jobseeker['sex'] ?? $_POST['sex'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($jobseeker['sex'] ?? $_POST['sex'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($jobseeker['sex'] ?? $_POST['sex'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="municipal" class="block text-sm font-medium text-gray-700">
                            Municipal
                        </label>
                        <div class="mt-1">
                            <input id="municipal" name="municipal" type="text"
                                   placeholder="Municipal"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700">
                            Barangay
                        </label>
                        <div class="mt-1">
                            <input id="barangay" name="barangay" type="text"
                                   placeholder="Barangay"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="contact_no" class="block text-sm font-medium text-gray-700">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="contact_no" name="contact_no" type="tel" required
                                   value="<?php echo htmlspecialchars($jobseeker['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                                   placeholder="Phone Number"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email"
                                   value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>"
                                   readonly
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none bg-gray-50 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=3" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip For Now
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Next Step
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>