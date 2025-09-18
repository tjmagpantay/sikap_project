<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6" x-data>
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Founding Information
            </h2>
            
            <p class="mt-2 text-sm text-center text-gray-500">
                Provide your company's founding information
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
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Founding</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 40%"></div>
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

            <form id="businessStep2Form" class="space-y-6" method="POST" action="?page=complete-employer-business&step=2">
                <!-- Organization Type -->
                <div>
                    <label for="business_type" class="block mb-1 text-xs font-medium text-gray-500">
                        Organization Type <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($business['business_type'] ?? $_POST['business_type'] ?? ''); ?>' || 'Select organization type' }">
                        <button type="button" @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                            <span x-text="selected === 'Select organization type' ? 'Select organization type' : selected"
                                :class="selected === 'Select organization type' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="business_type" x-model="selected === 'Select organization type' ? '' : selected" required>

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
                                    @click="selected = 'Corporation'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Corporation
                                </button>
                                <button type="button"
                                    @click="selected = 'Partnership'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Partnership
                                </button>
                                <button type="button"
                                    @click="selected = 'Sole Proprietorship'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Sole Proprietorship
                                </button>
                                <button type="button"
                                    @click="selected = 'Non-Profit'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Non-Profit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="business_type_error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Industry Type -->
                <div>
                    <label for="business_industry" class="block mb-1 text-xs font-medium text-gray-500">
                        Industry Types <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($business['business_industry'] ?? $_POST['business_industry'] ?? ''); ?>' || 'Select industry type' }">
                        <button type="button" @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                            <span x-text="selected === 'Select industry type' ? 'Select industry type' : selected"
                                :class="selected === 'Select industry type' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="business_industry" x-model="selected === 'Select industry type' ? '' : selected" required>

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
                            <div class="py-1 overflow-y-auto max-h-60">
                                <button type="button"
                                    @click="selected = 'Technology'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Technology
                                </button>
                                <button type="button"
                                    @click="selected = 'Healthcare'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Healthcare
                                </button>
                                <button type="button"
                                    @click="selected = 'Finance'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Finance
                                </button>
                                <button type="button"
                                    @click="selected = 'Education'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Education
                                </button>
                                <button type="button"
                                    @click="selected = 'Manufacturing'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Manufacturing
                                </button>
                                <button type="button"
                                    @click="selected = 'Retail'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Retail
                                </button>
                                <button type="button"
                                    @click="selected = 'Construction'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Construction
                                </button>
                                <button type="button"
                                    @click="selected = 'Transportation'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Transportation
                                </button>
                                <button type="button"
                                    @click="selected = 'Food & Beverage'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Food & Beverage
                                </button>
                                <button type="button"
                                    @click="selected = 'Other'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Other
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="business_industry_error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Address -->
                <div>
                    <label for="business_address" class="block mb-1 text-xs font-medium text-gray-500">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <textarea id="business_address" name="business_address" rows="3" required
                            maxlength="200"
                            placeholder="Enter complete business address"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_address')"
                            onblur="validateField(this, 'business_address')"><?php echo htmlspecialchars($business['business_address'] ?? $_POST['business_address'] ?? ''); ?></textarea>
                        <div id="business_address_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <label for="business_contact" class="block mb-1 text-xs font-medium text-gray-500">
                        Contact <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <input id="business_contact" name="business_contact" type="tel" required
                            maxlength="20"
                            value="<?php echo htmlspecialchars($business['business_contact'] ?? $_POST['business_contact'] ?? ''); ?>"
                            placeholder="09171234567 or (02) 8765 4321"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_contact')"
                            onblur="validateField(this, 'business_contact')">
                        <div id="business_contact_error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-500">
                            Mobile: 09171234567 or Landline: (02) 8765 4321
                        </div>
                    </div>
                </div>

                <!-- Team Size and Year of Establishment -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Team Size -->
                    <div>
                        <label for="business_size" class="block mb-1 text-xs font-medium text-gray-500">
                            Team Size <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($business['business_size'] ?? $_POST['business_size'] ?? ''); ?>' || 'Select team size' }">
                            <button type="button" @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                                <span x-text="selected === 'Select team size' ? 'Select team size' : selected"
                                    :class="selected === 'Select team size' ? 'text-gray-400' : 'text-gray-700'"></span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="business_size" x-model="selected === 'Select team size' ? '' : selected" required>

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
                                        @click="selected = '1-10'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        1-10 employees
                                    </button>
                                    <button type="button"
                                        @click="selected = '11-50'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        11-50 employees
                                    </button>
                                    <button type="button"
                                        @click="selected = '51-100'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        51-100 employees
                                    </button>
                                    <button type="button"
                                        @click="selected = '100+'; open = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        100+ employees
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="business_size_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>

                    <!-- Year of Establishment -->
                    <div>
                        <label for="business_established_year" class="block mb-1 text-xs font-medium text-gray-500">
                            Year of Establishment <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1">
                            <input id="business_established_year" name="business_established_year" type="date" required
                                value="<?php echo htmlspecialchars($business['business_established_year'] ?? $_POST['business_established_year'] ?? ''); ?>"
                                min="1900-01-01"
                                max="<?php echo date('Y-m-d'); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                oninput="validateField(this, 'business_established_year')"
                                onblur="validateField(this, 'business_established_year')">
                            <div id="business_established_year_error" class="hidden mt-1 text-xs text-red-600"></div>
                            <div class="mt-1 text-xs text-gray-500">
                                Must be between 1900 and current year
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Website -->
                <div>
                    <label for="business_website" class="block mb-1 text-xs font-medium text-gray-500">
                        Company Website
                    </label>
                    <div class="relative mt-1">
                        <input id="business_website" name="business_website" type="url"
                            maxlength="255"
                            value="<?php echo htmlspecialchars($business['business_website'] ?? $_POST['business_website'] ?? ''); ?>"
                            placeholder="https://yourcompany.com"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_website')"
                            onblur="validateField(this, 'business_website')">
                        <div id="business_website_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Company Email -->
                <div>
                    <label for="business_email" class="block mb-1 text-xs font-medium text-gray-500">
                        Company Email
                    </label>
                    <div class="relative mt-1">
                        <input id="business_email" name="business_email" type="email"
                            maxlength="100"
                            value="<?php echo htmlspecialchars($business['business_email'] ?? $_POST['business_email'] ?? ''); ?>"
                            placeholder="company@example.com"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateField(this, 'business_email')"
                            onblur="validateField(this, 'business_email')">
                        <div id="business_email_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=1" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <?php
                    // Check if business has existing data for step 2
                    $hasExistingData = !empty($business['business_type']) || !empty($business['business_industry']) || !empty($business['business_address']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" name="submit_step2" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update
                        </button>
                    <?php else: ?>
                        <button type="submit" name="submit_step2" id="submitBtn"
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
        business_address: {
            required: true,
            pattern: /^[A-Za-z0-9\s,.#-]+$/,
            minLength: 10,
            maxLength: 200,
            messages: {
                required: 'Business address is required',
                pattern: 'Address can only contain letters, numbers, spaces, commas, periods, # and -',
                minLength: 'Address must be at least 10 characters long',
                maxLength: 'Address cannot exceed 200 characters'
            }
        },
        business_contact: {
            required: true,
            pattern: /^(09\d{9}|\(\d{2}\)\s?\d{4}\s?\d{4}|\d{2}-\d{3}-\d{4}|\+63\d{10})$/,
            messages: {
                required: 'Business contact is required',
                pattern: 'Please enter a valid mobile (09171234567) or landline ((02) 8765 4321) number'
            }
        },
        business_established_year: {
            required: true,
            messages: {
                required: 'Year of establishment is required',
                invalid: 'Please enter a valid year between 1900 and current year'
            }
        },
        business_website: {
            required: false,
            pattern: /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/,
            maxLength: 255,
            messages: {
                pattern: 'Website must start with http:// or https:// and be a valid URL',
                maxLength: 'Website URL cannot exceed 255 characters'
            }
        },
        business_email: {
            required: false,
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            maxLength: 100,
            messages: {
                pattern: 'Please enter a valid email address',
                maxLength: 'Email cannot exceed 100 characters'
            }
        }
    };

    // Initialize validation on page load
    document.addEventListener('DOMContentLoaded', function() {
        validateAllFields();
    });

    function validateField(element, fieldName) {
        const value = element.value.trim();
        const rules = validationRules[fieldName];
        const errorElement = document.getElementById(fieldName + '_error');

        let isValid = true;
        let errorMessage = '';

        // Check required
        if (rules.required && (!value || value === '')) {
            isValid = false;
            errorMessage = rules.messages.required;
        }
        // Special validation for establishment year
        else if (fieldName === 'business_established_year' && value) {
            const selectedDate = new Date(value);
            const currentYear = new Date().getFullYear();
            const selectedYear = selectedDate.getFullYear();

            if (selectedYear < 1900 || selectedYear > currentYear) {
                isValid = false;
                errorMessage = rules.messages.invalid;
            }
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

    function validateDropdown(fieldName) {
        const hiddenInput = document.querySelector(`input[name="${fieldName}"]`);
        const errorElement = document.getElementById(fieldName + '_error');

        if (!hiddenInput || !hiddenInput.value || hiddenInput.value === '') {
            if (errorElement) {
                errorElement.classList.remove('hidden');
                errorElement.textContent = `Please select a ${fieldName.replace('business_', '').replace('_', ' ')}`;
            }
            return false;
        } else {
            if (errorElement) {
                errorElement.classList.add('hidden');
                errorElement.textContent = '';
            }
            return true;
        }
    }

    function validateAllFields() {
        let allValid = true;

        // Validate dropdown fields
        const dropdownFields = ['business_type', 'business_industry', 'business_size'];
        dropdownFields.forEach(fieldName => {
            const isValid = validateDropdown(fieldName);
            if (!isValid) {
                allValid = false;
            }
        });

        // Validate text fields
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

    // Contact number formatting and validation
    document.getElementById('business_contact').addEventListener('input', function(e) {
        let value = e.target.value;

        // For mobile numbers (09XXXXXXXXX)
        if (value.startsWith('09')) {
            // Only allow digits
            value = value.replace(/\D/g, '');
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
        }
        // For landline with area code format
        else if (value.includes('(') || value.includes(')')) {
            // Allow digits, parentheses, spaces, and hyphens
            value = value.replace(/[^\d()\s-]/g, '');
        }
        // For other formats
        else {
            // Allow digits, spaces, hyphens, parentheses, and plus
            value = value.replace(/[^\d\s\-()+ ]/g, '');
        }

        e.target.value = value;
        validateField(e.target, 'business_contact');
    });

    // Form submission validation
    document.getElementById('businessStep2Form').addEventListener('submit', function(e) {
        if (!validateAllFields()) {
            e.preventDefault();
            alert('Please fix all validation errors before submitting.');
            return false;
        }
    });

    // Watch for changes in Alpine.js dropdowns
    document.addEventListener('alpine:init', () => {
        // Add event listeners for dropdown changes
        setTimeout(() => {
            const dropdownInputs = document.querySelectorAll('input[name="business_type"], input[name="business_industry"], input[name="business_size"]');
            dropdownInputs.forEach(input => {
                const observer = new MutationObserver(() => {
                    updateSubmitButton();
                });
                observer.observe(input, {
                    attributes: true,
                    attributeFilter: ['value']
                });
            });
        }, 100);
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

    /* Alpine.js cloak */
    [x-cloak] {
        display: none !important;
    }
</style>