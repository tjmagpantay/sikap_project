<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';

// Decode existing social media data
$socials = [];
if (!empty($business['business_socials'])) {
    $socials = json_decode($business['business_socials'], true) ?? [];
}
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Social Media Profile
            </h2>

            <p class="mt-2 text-sm text-center text-gray-500">
                Link your company's social media accounts
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-4xl"> <!-- ✅ FIXED: Increased max width -->
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar with clickable steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=2" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Social</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 60%"></div>
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

            <form id="businessStep3Form" class="space-y-6" method="POST" action="?page=complete-employer-business&step=3">
                <!-- Social Link 1 - Facebook -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Facebook
                    </label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4"> <!-- ✅ FIXED: Changed to 4 columns for better layout -->
                        <div class="md:col-span-1">
                            <div class="flex items-center h-full px-4 py-3 text-sm text-gray-700 border border-gray-300 rounded-md bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                </svg>
                                <span class="font-medium">Facebook</span>
                            </div>
                        </div>
                        <div class="md:col-span-3"> <!-- ✅ FIXED: Takes up 3/4 of the width -->
                            <input id="facebook" name="facebook" type="url"
                                value="<?php echo htmlspecialchars($socials['facebook'] ?? $_POST['facebook'] ?? ''); ?>"
                                placeholder="https://facebook.com/yourpage"
                                maxlength="255"
                                class="block w-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'facebook')"
                                onblur="validateField(this, 'facebook')">
                            <div id="facebook_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Social Link 2 - Twitter -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Twitter / X
                    </label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="md:col-span-1">
                            <div class="flex items-center h-full px-4 py-3 text-sm text-gray-700 border border-gray-300 rounded-md bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                                <span class="font-medium">Twitter</span>
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <input id="twitter" name="twitter" type="url"
                                value="<?php echo htmlspecialchars($socials['twitter'] ?? $_POST['twitter'] ?? ''); ?>"
                                placeholder="https://twitter.com/yourprofile"
                                maxlength="255"
                                class="block w-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'twitter')"
                                onblur="validateField(this, 'twitter')">
                            <div id="twitter_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Social Link 3 - Instagram -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Instagram
                    </label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="md:col-span-1">
                            <div class="flex items-center h-full px-4 py-3 text-sm text-gray-700 border border-gray-300 rounded-md bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                                <span class="font-medium">Instagram</span>
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <input id="instagram" name="instagram" type="url"
                                value="<?php echo htmlspecialchars($socials['instagram'] ?? $_POST['instagram'] ?? ''); ?>"
                                placeholder="https://instagram.com/yourprofile"
                                maxlength="255"
                                class="block w-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'instagram')"
                                onblur="validateField(this, 'instagram')">
                            <div id="instagram_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Social Link 4 - YouTube -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        YouTube
                    </label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="md:col-span-1">
                            <div class="flex items-center h-full px-4 py-3 text-sm text-gray-700 border border-gray-300 rounded-md bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                                <span class="font-medium">YouTube</span>
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <input id="youtube" name="youtube" type="url"
                                value="<?php echo htmlspecialchars($socials['youtube'] ?? $_POST['youtube'] ?? ''); ?>"
                                placeholder="https://youtube.com/yourchannel"
                                maxlength="255"
                                class="block w-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'youtube')"
                                onblur="validateField(this, 'youtube')">
                            <div id="youtube_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Information Note -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary">
                                <strong>Note:</strong> Social media links are optional but help candidates learn more about your company culture and values.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=2" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <?php
                    // Check if business has existing social media data
                    $hasExistingData = !empty($socials['facebook']) || !empty($socials['twitter']) || !empty($socials['instagram']) || !empty($socials['youtube']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" name="submit_step3" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update
                        </button>
                    <?php else: ?>
                        <button type="submit" name="submit_step3" id="submitBtn"
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
    // Validation rules for social media URLs
    const validationRules = {
        facebook: {
            required: false,
            pattern: /^https?:\/\/(www\.)?(facebook\.com|fb\.me)\/.+$/i,
            maxLength: 255,
            messages: {
                pattern: 'Please enter a valid Facebook URL (e.g., https://facebook.com/yourpage)',
                maxLength: 'Facebook URL cannot exceed 255 characters'
            }
        },
        twitter: {
            required: false,
            pattern: /^https?:\/\/(www\.)?(twitter\.com|x\.com)\/.+$/i,
            maxLength: 255,
            messages: {
                pattern: 'Please enter a valid Twitter/X URL (e.g., https://twitter.com/yourprofile)',
                maxLength: 'Twitter URL cannot exceed 255 characters'
            }
        },
        instagram: {
            required: false,
            pattern: /^https?:\/\/(www\.)?instagram\.com\/.+$/i,
            maxLength: 255,
            messages: {
                pattern: 'Please enter a valid Instagram URL (e.g., https://instagram.com/yourprofile)',
                maxLength: 'Instagram URL cannot exceed 255 characters'
            }
        },
        youtube: {
            required: false,
            pattern: /^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/i,
            maxLength: 255,
            messages: {
                pattern: 'Please enter a valid YouTube URL (e.g., https://youtube.com/yourchannel)',
                maxLength: 'YouTube URL cannot exceed 255 characters'
            }
        }
    };

    // Initialize validation on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateSubmitButton();
    });

    function validateField(element, fieldName) {
        const value = element.value.trim();
        const rules = validationRules[fieldName];
        const errorElement = document.getElementById(fieldName + '_error');

        let isValid = true;
        let errorMessage = '';

        // Reset UI
        element.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
        element.classList.add('border-gray-300', 'focus:ring-primary/50', 'focus:border-primary');
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.textContent = '';
        }

        // If field is empty, it's valid (all social media fields are optional)
        if (!value || value === '') {
            return true;
        }

        // Check pattern
        if (rules.pattern && !rules.pattern.test(value)) {
            isValid = false;
            errorMessage = rules.messages.pattern;
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

        // Update UI if validation failed
        if (!isValid) {
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

        // Validate all social media fields
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
    document.getElementById('businessStep3Form').addEventListener('submit', function(e) {
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