<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Personal Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Provide your name, contact information, and other personal details
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar with steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=1" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Basic Info</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Education</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Certificates</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 28.57%"></div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=2" id="profileForm">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block mb-1 text-xs font-medium text-gray-500">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required
                                value="<?php echo htmlspecialchars($jobseeker['first_name'] ?? $_POST['first_name'] ?? $user['first_name'] ?? ''); ?>"
                                placeholder="First Name"
                                maxlength="50"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateName(this, 'first_name')">
                            <div id="first_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required
                                value="<?php echo htmlspecialchars($jobseeker['last_name'] ?? $_POST['last_name'] ?? $user['last_name'] ?? ''); ?>"
                                placeholder="Last Name"
                                maxlength="50"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateName(this, 'last_name')">
                            <div id="last_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Middle Name -->
                    <div>
                        <label for="middle_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Middle Name
                        </label>
                        <div class="mt-1">
                            <input id="middle_name" name="middle_name" type="text"
                                value="<?php echo htmlspecialchars($jobseeker['middle_name'] ?? $_POST['middle_name'] ?? $user['middle_name'] ?? ''); ?>"
                                placeholder="Middle Name"
                                maxlength="50"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateMiddleName(this)">
                            <div id="middle_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- Suffix - IMPROVED DROPDOWN -->
                    <div>
                        <label for="suffix" class="block mb-1 text-xs font-medium text-gray-500">
                            Suffix
                        </label>
                        <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($jobseeker['suffix'] ?? $_POST['suffix'] ?? ''); ?>' || 'Select Suffix' }">
                            <button type="button" @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                                <span x-text="selected === 'Select Suffix' ? 'Select Suffix' : selected"
                                    :class="selected === 'Select Suffix' ? 'text-gray-400' : 'text-gray-700'"></span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="suffix" x-model="selected === 'Select Suffix' ? '' : selected">

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button type="button"
                                        @click="selected = 'Select Suffix'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Select Suffix
                                    </button>
                                    <button type="button"
                                        @click="selected = 'Jr.'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Jr.
                                    </button>
                                    <button type="button"
                                        @click="selected = 'Sr.'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Sr.
                                    </button>
                                    <button type="button"
                                        @click="selected = 'II'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        II
                                    </button>
                                    <button type="button"
                                        @click="selected = 'III'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        III
                                    </button>
                                    <button type="button"
                                        @click="selected = 'IV'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        IV
                                    </button>
                                    <button type="button"
                                        @click="selected = 'V'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        V
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Birthdate - FIXED CALENDAR INPUT -->
                    <div>
                        <label for="date_of_birth" class="block mb-1 text-xs font-medium text-gray-500">
                            Birthdate <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1">
                            <input id="date_of_birth" name="date_of_birth" type="date" required
                                value="<?php
                                        // Convert display format (MM/DD/YYYY) to HTML date format (YYYY-MM-DD)
                                        $birthdate = $jobseeker['date_of_birth'] ?? $_POST['date_of_birth'] ?? '';
                                        if (!empty($birthdate)) {
                                            // If it's already in YYYY-MM-DD format, use it
                                            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthdate)) {
                                                echo htmlspecialchars($birthdate);
                                            }
                                            // If it's in MM/DD/YYYY format, convert it
                                            elseif (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $birthdate, $match)) {
                                                echo htmlspecialchars(sprintf('%04d-%02d-%02d', $match[3], $match[1], $match[2]));
                                            }
                                        }
                                        ?>"
                                max="<?php echo date('Y-m-d', strtotime('-16 years')); ?>"
                                min="1940-01-01"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                onchange="validateBirthdate(this)">
                            <div id="date_of_birth_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            Must be at least 16 years old
                        </div>
                    </div>

                    <!-- Gender - IMPROVED DROPDOWN -->
                    <div>
                        <label for="sex" class="block mb-1 text-xs font-medium text-gray-500">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($jobseeker['sex'] ?? $_POST['sex'] ?? ''); ?>' || 'Select Gender' }">
                            <button type="button" @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                                <span x-text="selected === 'Select Gender' ? 'Select Gender' : selected"
                                    :class="selected === 'Select Gender' ? 'text-gray-400' : 'text-gray-700'"></span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="sex" x-model="selected === 'Select Gender' ? '' : selected" required>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button type="button"
                                        @click="selected = 'Male'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Male
                                    </button>
                                    <button type="button"
                                        @click="selected = 'Female'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Female
                                    </button>
                                    <button type="button"
                                        @click="selected = 'Prefer not to say'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Prefer not to say
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="sex_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block mb-1 text-xs font-medium text-gray-500">
                        Complete Address <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="address" name="address" rows="3" required
                            placeholder="Complete Address"
                            maxlength="200"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateAddress(this)"><?php echo htmlspecialchars($jobseeker['address'] ?? $_POST['address'] ?? ''); ?></textarea>
                        <div id="address_error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="address_count">0</span>/200 characters
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Phone Number -->
                    <div>
                        <label for="contact_no" class="block mb-1 text-xs font-medium text-gray-500">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="contact_no" name="contact_no" type="tel" required
                                value="<?php echo htmlspecialchars($jobseeker['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                                placeholder="09123456789 or +639123456789"
                                maxlength="13"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validatePhoneNumber(this)">
                            <div id="contact_no_error" class="hidden mt-1 text-xs text-red-600"></div>
                            <div class="mt-1 text-xs text-gray-500">
                                Format: 09123456789 or +639123456789
                            </div>
                        </div>
                    </div>

                    <!-- Email (readonly) -->
                    <div>
                        <label for="email" class="block mb-1 text-xs font-medium text-gray-500">
                            Email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email"
                                value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>"
                                readonly
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all border border-gray-300 rounded-md shadow-sm bg-gray-50">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=1" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>
                    <button type="submit" name="submit_step2"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700"
                        id="submitBtn">
                        <?php echo ($jobseeker && (!empty($jobseeker['first_name']) || !empty($jobseeker['last_name'])) ? 'Update & Continue' : 'Next Step'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Validation functions
    function validateName(input, fieldName) {
        const value = input.value.trim();
        const errorDiv = document.getElementById(fieldName + '_error');
        const nameRegex = /^[a-zA-Z\s]+$/;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value === '') {
            if (fieldName !== 'middle_name') {
                showError(input, errorDiv, 'This field is required');
                return false;
            }
            return true;
        }

        if (value.length < 2) {
            showError(input, errorDiv, 'Must be at least 2 characters');
            return false;
        }

        if (value.length > 50) {
            showError(input, errorDiv, 'Must be less than 50 characters');
            return false;
        }

        if (!nameRegex.test(value)) {
            showError(input, errorDiv, 'Only letters and spaces are allowed');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateMiddleName(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('middle_name_error');
        const nameRegex = /^[a-zA-Z\s]*$/; // Allow empty for middle name

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value === '') {
            return true; // Middle name is optional
        }

        if (value.length > 50) {
            showError(input, errorDiv, 'Must be less than 50 characters');
            return false;
        }

        if (!nameRegex.test(value)) {
            showError(input, errorDiv, 'Only letters and spaces are allowed');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateBirthdate(input) {
        const value = input.value;
        const errorDiv = document.getElementById('date_of_birth_error');

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (!value) {
            showError(input, errorDiv, 'Birthdate is required');
            return false;
        }

        const birthDate = new Date(value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 16) {
            showError(input, errorDiv, 'You must be at least 16 years old');
            return false;
        }

        if (birthDate.getFullYear() < 1940) {
            showError(input, errorDiv, 'Year must be 1940 or later');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateAddress(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('address_error');
        const countSpan = document.getElementById('address_count');
        const addressRegex = /^[a-zA-Z0-9\s,.#-]*$/;

        // Update character count
        countSpan.textContent = value.length;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value === '') {
            showError(input, errorDiv, 'Address is required');
            return false;
        }

        if (value.length > 200) {
            showError(input, errorDiv, 'Address must be less than 200 characters');
            return false;
        }

        if (!addressRegex.test(value)) {
            showError(input, errorDiv, 'Address contains invalid characters');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validatePhoneNumber(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('contact_no_error');

        // Allow only digits, +, and remove spaces
        let cleanValue = value.replace(/[^\d+]/g, '');
        input.value = cleanValue;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (cleanValue === '') {
            showError(input, errorDiv, 'Phone number is required');
            return false;
        }

        // Philippine number patterns
        const patterns = [
            /^09\d{9}$/, // 09123456789
            /^\+639\d{9}$/, // +639123456789
            /^639\d{9}$/ // 639123456789
        ];

        const isValid = patterns.some(pattern => pattern.test(cleanValue));

        if (!isValid) {
            showError(input, errorDiv, 'Please enter a valid Philippine phone number');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function showError(input, errorDiv, message) {
        input.classList.add('border-red-500');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    // Form submission validation
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Validate all fields
        const firstName = document.getElementById('first_name');
        const lastName = document.getElementById('last_name');
        const middleName = document.getElementById('middle_name');
        const birthdate = document.getElementById('date_of_birth');
        const address = document.getElementById('address');
        const phone = document.getElementById('contact_no');

        if (!validateName(firstName, 'first_name')) isValid = false;
        if (!validateName(lastName, 'last_name')) isValid = false;
        if (!validateMiddleName(middleName)) isValid = false;
        if (!validateBirthdate(birthdate)) isValid = false;
        if (!validateAddress(address)) isValid = false;
        if (!validatePhoneNumber(phone)) isValid = false;

        // Check dropdowns
        const genderInput = document.querySelector('input[name="sex"]');
        if (!genderInput.value || genderInput.value === 'Select Gender') {
            document.getElementById('sex_error').textContent = 'Please select a gender';
            document.getElementById('sex_error').classList.remove('hidden');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fix the errors before continuing.');
        }
    });

    // Initialize character count for address
    document.addEventListener('DOMContentLoaded', function() {
        const addressField = document.getElementById('address');
        const countSpan = document.getElementById('address_count');
        if (addressField && countSpan) {
            countSpan.textContent = addressField.value.length;
        }
    });
</script>