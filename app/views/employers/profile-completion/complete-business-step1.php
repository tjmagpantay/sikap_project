<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Business Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Upload your logo, banner and company details
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar with clickable steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">1</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=2" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Social</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 20%"></div>
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

            <form id="businessStep1Form" class="space-y-6" method="POST" action="?page=complete-employer-business&step=1" enctype="multipart/form-data">

                <!-- Business Logo Upload -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">
                        Business Logo
                    </label>
                    <p class="mb-3 text-xs text-gray-500">
                        Square logo works best. Recommended size: 200x200 pixels. Max file size 5 MB.
                    </p>

                    <div class="grid grid-cols-2 gap-4 p-4 rounded-lg bg-gray-50" style="border-width:2px; border-style:dashed !important; border-color:currentColor !important;">
                        <!-- Left Column - Current Logo Display -->
                        <div class="flex items-center justify-center">
                            <?php if (!empty($business['business_logo'])): ?>
                                <div class="text-center">
                                    <img src="<?php echo htmlspecialchars($business['business_logo']); ?>"
                                        alt="Current Logo"
                                        class="object-contain w-16 h-16 mx-auto border border-gray-300 rounded-md">
                                    <p class="mt-1 text-xs text-gray-500">Current logo</p>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 border-2 border-gray-300 border-dashed rounded-md">
                                    <svg class="w-6 h-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M8 14s0-2 2-2h28s2 0 2 2v28s0 2-2 2H10s-2 0-2-2V14z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 30l10-10 10 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="30" cy="20" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column - Upload Function -->
                        <div class="flex flex-col justify-center">
                            <div class="p-4 text-center transition-colors rounded-lg border-primary hover:border-blue-400"
                                ondrop="handleFileDrop(event, 'business_logo')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                                <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <label for="business_logo" class="block cursor-pointer">
                                    <span class="text-sm font-medium text-primary hover:text-blue-500">
                                        <?php echo !empty($business['business_logo']) ? 'Replace logo' : 'Upload logo'; ?>
                                    </span>
                                    <input id="business_logo" name="business_logo" type="file" class="sr-only"
                                        accept="image/jpeg,image/png" onchange="validateImageFile(this, 'business_logo')">
                                </label>
                                <p class="mt-1 text-xs text-gray-500">JPEG, PNG up to 5MB</p>
                            </div>
                            <div id="business_logo_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Banner Image Upload -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">
                        Banner Image
                    </label>
                    <p class="mb-3 text-xs text-gray-500">
                        A photo at least 400px wide works best. Recommended dimension: 1520x400 pixels. Max file size 5 MB.
                    </p>

                    <?php if (!empty($business['banner_image'])): ?>
                        <div class="mb-4">
                            <img src="<?php echo htmlspecialchars($business['banner_image']); ?>"
                                alt="Current Banner"
                                class="object-cover w-full h-32 border border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Current banner image. Upload a new one to replace it.</p>
                        </div>
                    <?php endif; ?>

                    <div class="p-6 text-center transition-colors rounded-lg border-primary hover:border-blue-400" style="border-width:2px; border-style:dashed !important; border-color:currentColor !important;"
                        ondrop="handleFileDrop(event, 'banner_image')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <svg class="w-12 h-12 mx-auto mb-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <label for="banner_image" class="block cursor-pointer">
                            <span class="text-sm font-medium text-primary hover:text-blue-500">
                                <?php echo !empty($business['banner_image']) ? 'Replace banner' : 'Upload banner'; ?>
                            </span>
                            <input id="banner_image" name="banner_image" type="file" class="sr-only"
                                accept="image/jpeg,image/png" onchange="validateImageFile(this, 'banner_image')">
                        </label>
                        <p class="mt-1 text-xs text-gray-500">or drag and drop image files</p>
                        <p class="mt-2 text-xs text-gray-500">
                            <strong>JPEG, PNG files only</strong> • Maximum 5MB • At least 400px wide recommended
                        </p>
                    </div>
                    <div id="banner_image_error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Company Name -->
                <div>
                    <label for="business_name" class="block mb-1 text-sm font-medium text-primary">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <input id="business_name" name="business_name" type="text" required maxlength="150"
                            value="<?php echo htmlspecialchars($business['business_name'] ?? $_POST['business_name'] ?? ''); ?>"
                            placeholder="Enter your company name"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_name')"
                            onblur="validateField(this, 'business_name')">
                        <div id="business_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="business_desc" class="block mb-1 text-sm font-medium text-primary">
                        About Us <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <textarea id="business_desc" name="business_desc" rows="6" required maxlength="1000"
                            placeholder="Write down about your company here. Let the candidate know who we are..."
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_desc')"
                            onblur="validateField(this, 'business_desc')"><?php echo htmlspecialchars($business['business_desc'] ?? $_POST['business_desc'] ?? ''); ?></textarea>
                        <div id="business_desc_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Describe your company, mission, values, and what makes you unique.</p>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-profile" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Setup
                    </a>
                    <?php
                    // Check if business has existing data
                    $hasExistingData = !empty($business['business_name']) || !empty($business['business_desc']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" name="submit_step1" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update
                        </button>
                    <?php else: ?>
                        <button type="submit" name="submit_step1" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next Step
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
        business_name: {
            required: true,
            pattern: /^[A-Za-z0-9\s&.,-]+$/,
            minLength: 2,
            maxLength: 150,
            messages: {
                required: 'Company name is required',
                pattern: 'Company name can contain letters, numbers, spaces, and symbols (&.,-)',
                minLength: 'Company name must be at least 2 characters long',
                maxLength: 'Company name cannot exceed 150 characters'
            }
        },
        business_desc: {
            required: true,
            minLength: 10,
            maxLength: 1000,
            messages: {
                required: 'About us is required',
                minLength: 'About us must be at least 10 characters long',
                maxLength: 'About us cannot exceed 1000 characters'
            }
        }
    };

    // File validation settings
    const fileValidation = {
        business_logo: {
            maxSize: 5 * 1024 * 1024, // 5MB
            allowedTypes: ['image/jpeg', 'image/png'],
            messages: {
                invalidType: 'Business logo must be JPEG or PNG format',
                tooLarge: 'Business logo file size must be less than 5MB'
            }
        },
        banner_image: {
            maxSize: 5 * 1024 * 1024, // 5MB
            allowedTypes: ['image/jpeg', 'image/png'],
            minWidth: 400,
            messages: {
                invalidType: 'Banner image must be JPEG or PNG format',
                tooLarge: 'Banner image file size must be less than 5MB',
                tooSmall: 'Banner image should be at least 400px wide'
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
        // Check maximum length
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

    // File validation function
    function validateImageFile(input, fieldName) {
        const file = input.files[0];
        const errorElement = document.getElementById(fieldName + '_error');
        const rules = fileValidation[fieldName];

        if (!file) {
            // File removed, hide error
            if (errorElement) {
                errorElement.classList.add('hidden');
                errorElement.textContent = '';
            }
            return true;
        }

        let isValid = true;
        let errorMessage = '';

        // Check file type
        if (!rules.allowedTypes.includes(file.type)) {
            isValid = false;
            errorMessage = rules.messages.invalidType;
        }
        // Check file size
        else if (file.size > rules.maxSize) {
            isValid = false;
            errorMessage = rules.messages.tooLarge;
        }
        // Check image dimensions for banner (if specified)
        else if (fieldName === 'banner_image' && rules.minWidth) {
            const img = new Image();
            img.onload = function() {
                if (this.width < rules.minWidth) {
                    showImageError(errorElement, rules.messages.tooSmall);
                } else {
                    hideImageError(errorElement);
                }
            };
            img.src = URL.createObjectURL(file);
            return true; // Return true for now, will be validated async
        }

        // Update UI
        if (isValid) {
            hideImageError(errorElement);
        } else {
            showImageError(errorElement, errorMessage);
            input.value = ''; // Clear the invalid file
        }

        return isValid;
    }

    function showImageError(errorElement, message) {
        if (errorElement) {
            errorElement.classList.remove('hidden');
            errorElement.textContent = message;
        }
    }

    function hideImageError(errorElement) {
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.textContent = '';
        }
    }

    // Drag and drop handlers
    function handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.classList.add('border-blue-400', 'bg-blue-50');
    }

    function handleDragLeave(event) {
        event.preventDefault();
        event.currentTarget.classList.remove('border-blue-400', 'bg-blue-50');
    }

    function handleFileDrop(event, fieldName) {
        event.preventDefault();
        event.currentTarget.classList.remove('border-blue-400', 'bg-blue-50');

        const files = event.dataTransfer.files;
        const input = document.getElementById(fieldName);

        if (files.length > 0) {
            // Create a new FileList-like object
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;

            // Trigger validation
            validateImageFile(input, fieldName);
        }
    }

    // Form submission validation
    document.getElementById('businessStep1Form').addEventListener('submit', function(e) {
        if (!validateAllFields()) {
            e.preventDefault();
            alert('Please fix all validation errors before submitting.');
            return false;
        }
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

    /* Drag and drop styles */
    .border-primary {
        border-color: #1d4ed8 !important;
    }

    .border-blue-400 {
        border-color: #60a5fa !important;
    }

    .bg-blue-50 {
        background-color: #eff6ff !important;
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