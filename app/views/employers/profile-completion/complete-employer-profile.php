<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
$fullName = $user['name'] ?? '';
$nameParts = explode(' ', trim($fullName));
$autoFirstName = $nameParts[0] ?? '';
$autoLastName = count($nameParts) > 1 ? end($nameParts) : '';
$autoMiddleName = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
?>

<?php
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6 ">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Complete Your Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/2 - Employer Profile
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Set up your personal details first
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 rounded bg-primary" style="width: <?php echo $step == 1 ? '50%' : '100%'; ?>"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-4">
                    <a href="?page=complete-employer-profile&step=1"
                        class="flex-1 px-4 py-2 text-sm font-medium text-center rounded-md transition-colors <?php echo $step == 1 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-primary'; ?>">
                        Personal Info
                    </a>
                    <a href="?page=complete-employer-profile&step=2"
                        class="flex-1 px-4 py-2 text-sm font-medium rounded-md text-center transition-colors <?php echo $step == 2 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-secondary'; ?>">
                        Business Setup
                    </a>
                </nav>
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

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form id="employerProfileForm" class="space-y-6" method="POST" action="?page=employer-personal-profile">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block mb-1 text-xs font-medium text-gray-500">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1">
                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                required
                                maxlength="50"
                                value="<?php echo htmlspecialchars($employer['first_name'] ?? $_POST['first_name'] ?? $autoFirstName); ?>"
                                placeholder="First Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'first_name')"
                                onblur="validateField(this, 'first_name')">
                            <div id="first_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="middle_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Middle Name
                        </label>
                        <div class="relative mt-1">
                            <input
                                id="middle_name"
                                name="middle_name"
                                type="text"
                                maxlength="50"
                                value="<?php echo htmlspecialchars($employer['middle_name'] ?? $_POST['middle_name'] ?? $autoMiddleName); ?>"
                                placeholder="Middle Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'middle_name')"
                                onblur="validateField(this, 'middle_name')">
                            <div id="middle_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1">
                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                required
                                maxlength="50"
                                value="<?php echo htmlspecialchars($employer['last_name'] ?? $_POST['last_name'] ?? $autoLastName); ?>"
                                placeholder="Last Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'last_name')"
                                onblur="validateField(this, 'last_name')">
                            <div id="last_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block mb-1 text-xs font-medium text-gray-500">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <input
                            id="position"
                            name="position"
                            type="text"
                            required
                            maxlength="100"
                            value="<?php echo htmlspecialchars($employer['position'] ?? $_POST['position'] ?? ''); ?>"
                            placeholder="e.g., HR Manager, CEO, Recruiter, CEO/Founder"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'position')"
                            onblur="validateField(this, 'position')">
                        <div id="position_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Contact Number -->
                    <div>
                        <label for="contact_no" class="block mb-1 text-xs font-medium text-gray-500">
                            Contact Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1">
                            <input
                                id="contact_no"
                                name="contact_no"
                                type="tel"
                                required
                                maxlength="11"
                                value="<?php echo htmlspecialchars($employer['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                                placeholder="09123456789"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'contact_no')"
                                onblur="validateField(this, 'contact_no')">
                            <div class="mt-1 text-xs text-gray-500">Format: 09XXXXXXXXX (11 digits)</div>
                            <div id="contact_no_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Company Name
                        </label>
                        <div class="relative mt-1">
                            <input
                                id="company_name"
                                name="company_name"
                                type="text"
                                maxlength="150"
                                value="<?php echo htmlspecialchars($employer['company_name'] ?? $_POST['company_name'] ?? ''); ?>"
                                placeholder="Company Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'company_name')"
                                onblur="validateField(this, 'company_name')">
                            <div id="company_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="about_us" class="block mb-1 text-xs font-medium text-gray-500">
                        About Us
                    </label>
                    <div class="relative mt-1">
                        <textarea
                            id="about_us"
                            name="about_us"
                            rows="4"
                            maxlength="500"
                            placeholder="Describe your company and what you do..."
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'about_us')"
                            onblur="validateField(this, 'about_us')"><?php echo htmlspecialchars($employer['about_us'] ?? $_POST['about_us'] ?? ''); ?></textarea>
                        <div id="about_us_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Information Notice -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary">
                                <strong>Next Step:</strong> After saving your personal information, you'll set up your business details including company information, social media links, and required documents.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-profile" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Setup
                    </a>
                    <?php
                    // Check if employer has existing data
                    $hasExistingData = !empty($employer['first_name']) || !empty($employer['last_name']) || !empty($employer['position']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Profile
                        </button>
                    <?php else: ?>
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Save & Continue
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Validation rules
    const validationRules = {
        first_name: {
            required: true,
            pattern: /^[A-Za-z\s-]+$/,
            minLength: 2,
            maxLength: 50,
            messages: {
                required: 'First name is required',
                pattern: 'First name can only contain letters, spaces, and hyphens',
                minLength: 'First name must be at least 2 characters long',
                maxLength: 'First name cannot exceed 50 characters'
            }
        },
        middle_name: {
            required: false,
            pattern: /^[A-Za-z\s-]*$/,
            maxLength: 50,
            messages: {
                pattern: 'Middle name can only contain letters, spaces, and hyphens',
                maxLength: 'Middle name cannot exceed 50 characters'
            }
        },
        last_name: {
            required: true,
            pattern: /^[A-Za-z\s-]+$/,
            minLength: 2,
            maxLength: 50,
            messages: {
                required: 'Last name is required',
                pattern: 'Last name can only contain letters, spaces, and hyphens',
                minLength: 'Last name must be at least 2 characters long',
                maxLength: 'Last name cannot exceed 50 characters'
            }
        },
        position: {
            required: true,
            pattern: /^[A-Za-z\s\/\-&.]+$/,
            minLength: 2,
            maxLength: 100,
            messages: {
                required: 'Position is required',
                pattern: 'Position can contain letters, spaces, /, -, &, and .',
                minLength: 'Position must be at least 2 characters long',
                maxLength: 'Position cannot exceed 100 characters'
            }
        },
        contact_no: {
            required: true,
            pattern: /^09\d{9}$/,
            messages: {
                required: 'Contact number is required',
                pattern: 'Contact number must start with 09 and be exactly 11 digits (e.g., 09123456789)'
            }
        },
        company_name: {
            required: false,
            pattern: /^[A-Za-z0-9\s&.,-]*$/,
            maxLength: 150,
            messages: {
                pattern: 'Company name can contain letters, numbers, spaces, and special characters (&.,-)',
                maxLength: 'Company name cannot exceed 150 characters'
            }
        },
        about_us: {
            required: false,
            minLength: 10,
            maxLength: 500,
            messages: {
                minLength: 'If provided, about us must be at least 10 characters long',
                maxLength: 'About us cannot exceed 500 characters'
            }
        }
    };

    // Initialize validation on page load
    document.addEventListener('DOMContentLoaded', function() {
        validateAllFields();
    });

    function validateField(element, fieldName) {
        const value = element.value;
        const rules = validationRules[fieldName];
        const errorElement = document.getElementById(fieldName + '_error');

        let isValid = true;
        let errorMessage = '';

        // Check required
        if (rules.required && (!value || value.trim() === '')) {
            isValid = false;
            errorMessage = rules.messages.required;
        }
        // Check pattern (only if value is not empty)
        else if (value && rules.pattern && !rules.pattern.test(value)) {
            isValid = false;
            errorMessage = rules.messages.pattern;
        }
        // Check minimum length (only if value is not empty or field is required)
        else if (value && rules.minLength && value.length < rules.minLength) {
            isValid = false;
            errorMessage = rules.messages.minLength;
        }
        // Check maximum length - ONLY show error when limit is reached
        else if (rules.maxLength && value.length >= rules.maxLength) {
            // Prevent further input by truncating
            if (value.length > rules.maxLength) {
                element.value = value.substring(0, rules.maxLength);
            }
            // Show error only when at the limit
            if (element.value.length >= rules.maxLength) {
                isValid = false;
                errorMessage = rules.messages.maxLength;
            }
        }
        // Special case for about_us minimum length (only if not empty)
        else if (fieldName === 'about_us' && value.trim() && value.trim().length < rules.minLength) {
            isValid = false;
            errorMessage = rules.messages.minLength;
        }

        // Update UI
        if (isValid) {
            element.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            element.classList.add('border-gray-300', 'focus:ring-primary/50', 'focus:border-primary');
            if (errorElement) {
                errorElement.classList.add('hidden');
                errorElement.textContent = '';
            }
        } else {
            element.classList.remove('border-gray-300', 'focus:ring-primary/50', 'focus:border-primary');
            element.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            if (errorElement) {
                errorElement.classList.remove('hidden');
                errorElement.textContent = errorMessage;
            }
        }

        // Update submit button state
        updateSubmitButton();

        return isValid;
    }

    function validateAllFields() {
        let allValid = true;

        Object.keys(validationRules).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                const isValid = validateField(field, fieldName);
                if (!isValid) {
                    allValid = false;
                }
            }
        });

        return allValid;
    }

    function updateSubmitButton() {
        const submitBtn = document.getElementById('submitBtn');
        const isValid = validateAllFields();

        if (submitBtn) {
            submitBtn.disabled = !isValid;
        }
    }

    // Form submission validation
    document.getElementById('employerProfileForm').addEventListener('submit', function(e) {
        if (!validateAllFields()) {
            e.preventDefault();
            alert('Please fix all validation errors before submitting.');
            return false;
        }
    });

    // Real-time validation for contact number (prevent non-numeric input)
    document.getElementById('contact_no').addEventListener('input', function(e) {
        // Only allow numbers
        let value = e.target.value.replace(/\D/g, '');

        // Ensure it starts with 09
        if (value.length > 0 && !value.startsWith('09')) {
            value = '09';
        }

        // Limit to 11 digits
        if (value.length > 11) {
            value = value.substring(0, 11);
        }

        e.target.value = value;
        validateField(e.target, 'contact_no');
    });
</script>

<style>
    /* Custom styles for validation */
    .border-red-300 {
        border-color: #fca5a5 !important;
    }

    .focus\:ring-red-500:focus {
        --tw-ring-color: rgb(239 68 68 / 0.5) !important;
    }

    .focus\:border-red-500:focus {
        border-color: #ef4444 !important;
    }

    /* Animation for error messages */
    .validation-error {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>