<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Post a New Job
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Create a job posting to find the perfect candidate
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">1</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Settings</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">5</span>
                        </div>
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

            <!-- Form -->
            <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=1<?php echo $job_id ? '&job_id=' . $job_id : ''; ?>" id="job-form">
                <!-- Hidden field to ensure step progression -->
                <input type="hidden" name="continue_to_step2" value="1">

                <!-- Job Title -->
                <div>
                    <label for="job_title" class="block mb-1 text-sm font-medium text-primary">Job Title <span class="text-red-500">*</span></label>
                    <input
                        id="job_title"
                        name="job_title"
                        type="text"
                        required
                        maxlength="100"
                        value="<?php echo htmlspecialchars($jobData['job_title'] ?? $_POST['job_title'] ?? ''); ?>"
                        placeholder="e.g., Senior Web Developer"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary placeholder:text-xs">
                    <div id="job-title-error" class="hidden mt-1 text-xs text-red-600"></div>
                    
                </div>

                <!-- Job Category -->
                <div>
                    <label for="job_category_id" class="block mb-1 text-sm font-medium text-primary">Job Category <span class="text-red-500">*</span></label>
                    <div class="relative" x-data="{ open: false, selected: '<?php echo !empty($jobData['job_category_id']) ? (array_search($jobData['job_category_id'], array_column($categories, 'job_category_id')) !== false ? $categories[array_search($jobData['job_category_id'], array_column($categories, 'job_category_id'))]['category_name'] : 'Select Category') : 'Select Category'; ?>', selectedValue: '<?php echo $jobData['job_category_id'] ?? $_POST['job_category_id'] ?? ''; ?>' }">
                        <button type="button" @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <span x-text="selected" :class="{'text-gray-500': selected === 'Select Category', 'text-gray-900': selected !== 'Select Category'}"></span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                            x-cloak>
                            <div class="py-1 overflow-y-auto max-h-60">
                                <?php foreach ($categories as $category): ?>
                                    <button type="button" @click="selected = '<?php echo htmlspecialchars($category['category_name']); ?>'; selectedValue = '<?php echo $category['job_category_id']; ?>'; open = false; document.getElementById('job_category_id').value = '<?php echo $category['job_category_id']; ?>'; document.getElementById('job_category_id').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" id="job_category_id" name="job_category_id" :value="selectedValue">
                    </div>
                    <div id="job-category-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block mb-1 text-sm font-medium text-primary">Job Type <span class="text-red-500">*</span></label>
                    <div class="relative" x-data="{ 
                        open: false, 
                        selected: '<?php
                                    $jobTypeValue = $jobData['job_type'] ?? $_POST['job_type'] ?? '';
                                    $jobTypes = [
                                        'full-time' => 'Full-time',
                                        'part-time' => 'Part-time',
                                        'contract' => 'Contract',
                                        'internship' => 'Internship',
                                        'freelance' => 'Freelance'
                                    ];
                                    echo !empty($jobTypeValue) && isset($jobTypes[$jobTypeValue]) ? $jobTypes[$jobTypeValue] : 'Select Job Type';
                                    ?>', 
                        selectedValue: '<?php echo $jobTypeValue; ?>' 
                    }">
                        <button type="button" @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <span x-text="selected" :class="{'text-gray-500': selected === 'Select Job Type', 'text-gray-900': selected !== 'Select Job Type'}"></span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                            x-cloak>
                            <div class="py-1">
                                <button type="button" @click="selected = 'Full-time'; selectedValue = 'full-time'; open = false; document.getElementById('job_type').value = 'full-time'; document.getElementById('job_type').dispatchEvent(new Event('change'));"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                    Full-time
                                </button>
                                <button type="button" @click="selected = 'Part-time'; selectedValue = 'part-time'; open = false; document.getElementById('job_type').value = 'part-time'; document.getElementById('job_type').dispatchEvent(new Event('change'));"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                    Part-time
                                </button>
                                <button type="button" @click="selected = 'Contract'; selectedValue = 'contract'; open = false; document.getElementById('job_type').value = 'contract'; document.getElementById('job_type').dispatchEvent(new Event('change'));"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                    Contract
                                </button>
                                <button type="button" @click="selected = 'Internship'; selectedValue = 'internship'; open = false; document.getElementById('job_type').value = 'internship'; document.getElementById('job_type').dispatchEvent(new Event('change'));"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                    Internship
                                </button>
                                <button type="button" @click="selected = 'Freelance'; selectedValue = 'freelance'; open = false; document.getElementById('job_type').value = 'freelance'; document.getElementById('job_type').dispatchEvent(new Event('change'));"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                    Freelance
                                </button>
                            </div>
                        </div>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" id="job_type" name="job_type" :value="selectedValue">
                    </div>
                    <div id="job-type-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block mb-1 text-sm font-medium text-primary">Location <span class="text-red-500">*</span></label>
                    <input id="location" name="location" type="text" required
                        maxlength="100"
                        value="<?php echo htmlspecialchars($jobData['location'] ?? $_POST['location'] ?? ''); ?>"
                        placeholder="e.g., Manila, Philippines"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    <div id="location-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        Format: City, Country or City, Province
                    </div>
                </div>

                <!-- Workplace Option -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">Workplace Option</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="onsite"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? 'onsite') == 'onsite') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">On-site</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="remote"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'remote') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">Remote</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="hybrid"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'hybrid') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">Hybrid</span>
                        </label>
                    </div>
                </div>

                <!-- Age Requirements -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">Age Requirements</label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="min_age" class="block mb-1 text-xs font-medium text-gray-600">Minimum Age</label>
                            <input id="min_age" name="min_age" type="number" min="16" max="65"
                                value="<?php echo htmlspecialchars($jobData['min_age'] ?? $_POST['min_age'] ?? ''); ?>"
                                placeholder="18"
                                class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="max_age" class="block mb-1 text-xs font-medium text-gray-600">Maximum Age</label>
                            <input id="max_age" name="max_age" type="number" min="16" max="65"
                                value="<?php echo htmlspecialchars($jobData['max_age'] ?? $_POST['max_age'] ?? ''); ?>"
                                placeholder="60"
                                class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Leave empty if no age restrictions apply. Age range should be between 16-65 years.</p>
                    <div id="age-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Required Skills -->
                <div>
                    <label for="skills" class="block mb-1 text-sm font-medium text-primary">Required Skills</label>
                    <input id="skills" name="skills" type="text"
                        maxlength="500"
                        value="<?php echo htmlspecialchars(implode(', ', $jobData['skills'] ?? []) ?: ($_POST['skills'] ?? '')); ?>"
                        placeholder="e.g., PHP, JavaScript, MySQL, Communication"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    <div id="skills-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        Separate skills with commas. Each skill should be 1-30 characters.
                    </div>
                </div>

                <!-- Job Summary -->
                <div>
                    <label for="job_summary" class="block mb-1 text-sm font-medium text-primary">Job Summary <span class="text-red-500">*</span></label>
                    <textarea id="job_summary" name="job_summary" rows="3" required
                        maxlength="2000"
                        placeholder="Brief description of the role (2-3 sentences)"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md resize-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['job_summary'] ?? $_POST['job_summary'] ?? ''); ?></textarea>
                    <div id="job-summary-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        <span id="summary-count">0</span>/2000 characters. Minimum 20 characters required.
                    </div>
                </div>

                <!-- Pay Information -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Pay Type -->
                    <div>
                        <label for="pay_type" class="block mb-1 text-sm font-medium text-primary">Pay Type</label>
                        <div class="relative" x-data="{ 
                            open: false, 
                            selected: '<?php
                                        $payTypeValue = $jobData['pay_type'] ?? $_POST['pay_type'] ?? '';
                                        $payTypes = [
                                            'monthly' => 'Monthly',
                                            'hourly' => 'Hourly',
                                            'weekly' => 'Weekly',
                                            'project-based' => 'Project-based',
                                            'negotiable' => 'Negotiable'
                                        ];
                                        echo !empty($payTypeValue) && isset($payTypes[$payTypeValue]) ? $payTypes[$payTypeValue] : 'Select Pay Type';
                                        ?>', 
                            selectedValue: '<?php echo $payTypeValue; ?>' 
                        }">
                            <button type="button" @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <span x-text="selected" :class="{'text-gray-500': selected === 'Select Pay Type', 'text-gray-900': selected !== 'Select Pay Type'}"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button type="button" @click="selected = 'Monthly'; selectedValue = 'monthly'; open = false; document.getElementById('pay_type').value = 'monthly'; document.getElementById('pay_type').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        Monthly
                                    </button>
                                    <button type="button" @click="selected = 'Hourly'; selectedValue = 'hourly'; open = false; document.getElementById('pay_type').value = 'hourly'; document.getElementById('pay_type').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        Hourly
                                    </button>
                                    <button type="button" @click="selected = 'Weekly'; selectedValue = 'weekly'; open = false; document.getElementById('pay_type').value = 'weekly'; document.getElementById('pay_type').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        Weekly
                                    </button>
                                    <button type="button" @click="selected = 'Project-based'; selectedValue = 'project-based'; open = false; document.getElementById('pay_type').value = 'project-based'; document.getElementById('pay_type').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        Project-based
                                    </button>
                                    <button type="button" @click="selected = 'Negotiable'; selectedValue = 'negotiable'; open = false; document.getElementById('pay_type').value = 'negotiable'; document.getElementById('pay_type').dispatchEvent(new Event('change'));"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-primary">
                                        Negotiable
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" id="pay_type" name="pay_type" :value="selectedValue">
                        </div>
                        <div id="pay-type-error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>

                    <!-- Pay Range -->
                    <div>
                        <label for="pay_range" class="block mb-1 text-sm font-medium text-primary">Pay Range</label>
                        <input id="pay_range" name="pay_range" type="text"
                            maxlength="50"
                            value="<?php echo htmlspecialchars($jobData['pay_range'] ?? $_POST['pay_range'] ?? ''); ?>"
                            placeholder="e.g., 20000 - 40000"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <div id="pay-range-error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-400">
                            Format: minimum - maximum (numbers only)
                        </div>
                    </div>
                </div>

                <!-- Full Description -->
                <div>
                    <label for="full_description" class="block mb-1 text-sm font-medium text-primary">Full Description <span class="text-red-500">*</span></label>
                    <textarea id="full_description" name="full_description" rows="5" required
                        maxlength="5000"
                        placeholder="Detailed description of the job, responsibilities, and requirements"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md resize-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['full_description'] ?? $_POST['full_description'] ?? ''); ?></textarea>
                    <div id="full-description-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        <span id="description-count">0</span>/5000 characters. Minimum 100 characters required.
                    </div>
                </div>

                <!-- Application Timeline -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Application Start -->
                    <div>
                        <label for="application_start" class="block mb-1 text-sm font-medium text-primary">Application Start</label>
                        <input id="application_start" name="application_start" type="datetime-local"
                            value="<?php echo htmlspecialchars($jobData['application_start'] ?? $_POST['application_start'] ?? ''); ?>"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <div id="application-start-error" class="hidden mt-1 text-xs text-red-600"></div>
                        <p class="mt-1 text-xs text-gray-400">Leave empty to start accepting applications immediately</p>
                    </div>

                    <!-- Application Deadline -->
                    <div>
                        <label for="application_deadline" class="block mb-1 text-sm font-medium text-primary">Application Deadline</label>
                        <input id="application_deadline" name="application_deadline" type="datetime-local"
                            value="<?php echo htmlspecialchars($jobData['application_deadline'] ?? $_POST['application_deadline'] ?? ''); ?>"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <div id="application-deadline-error" class="hidden mt-1 text-xs text-red-600"></div>
                        <p class="mt-1 text-xs text-gray-400">Set when applications should stop being accepted</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=employer-dashboard"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <button type="submit" id="submit-btn"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        Continue to Attachments
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get form elements
        const form = document.getElementById('job-form');
        const jobTitle = document.getElementById('job_title');
        const jobCategory = document.getElementById('job_category_id');
        const jobType = document.getElementById('job_type');
        const location = document.getElementById('location');
        const minAge = document.getElementById('min_age');
        const maxAge = document.getElementById('max_age');
        const skills = document.getElementById('skills');
        const jobSummary = document.getElementById('job_summary');
        const payType = document.getElementById('pay_type');
        const payRange = document.getElementById('pay_range');
        const fullDescription = document.getElementById('full_description');
        const applicationStart = document.getElementById('application_start');
        const applicationDeadline = document.getElementById('application_deadline');

        // Character counters
        const titleCount = document.getElementById('title-count');
        const locationCount = document.getElementById('location-count');
        const skillsCount = document.getElementById('skills-count');
        const summaryCount = document.getElementById('summary-count');
        const payRangeCount = document.getElementById('pay-range-count');
        const descriptionCount = document.getElementById('description-count');

        // Prevent input beyond maxlength for all fields
        function enforceMaxLength(element, maxLength) {
            element.addEventListener('input', function() {
                if (this.value.length > maxLength) {
                    this.value = this.value.slice(0, maxLength);
                }
            });

            element.addEventListener('paste', function(e) {
                setTimeout(() => {
                    if (this.value.length > maxLength) {
                        this.value = this.value.slice(0, maxLength);
                        updateAllCharacterCounts();
                    }
                }, 0);
            });
        }

        // Apply maxlength enforcement to all text fields
        enforceMaxLength(jobTitle, 100);
        enforceMaxLength(location, 100);
        enforceMaxLength(skills, 500);
        enforceMaxLength(jobSummary, 2000);
        enforceMaxLength(payRange, 50);
        enforceMaxLength(fullDescription, 5000);

        // Validation functions
        function validateJobTitle() {
            const value = jobTitle.value.trim();
            const regex = /^[A-Za-z0-9\s.,&/-]{3,100}$/;
            const errorElement = document.getElementById('job-title-error');

            clearError(jobTitle, errorElement);

            if (!value) {
                showError(jobTitle, errorElement, 'Job title is required.');
                return false;
            }

            if (value.length < 3) {
                showError(jobTitle, errorElement, 'Job title must be at least 3 characters long.');
                return false;
            }

            if (value.length > 100) {
                showError(jobTitle, errorElement, 'Job title cannot exceed 100 characters.');
                return false;
            }

            if (!regex.test(value)) {
                showError(jobTitle, errorElement, 'Job title contains invalid characters. Only letters, numbers, spaces, and common symbols (.,&/-) are allowed.');
                return false;
            }

            return true;
        }

        function validateJobCategory() {
            const value = jobCategory.value;
            const errorElement = document.getElementById('job-category-error');

            clearError(jobCategory, errorElement);

            if (!value) {
                showError(jobCategory, errorElement, 'Please select a job category.');
                return false;
            }

            return true;
        }

        function validateJobType() {
            const value = jobType.value;
            const errorElement = document.getElementById('job-type-error');

            clearError(jobType, errorElement);

            if (!value) {
                showError(jobType, errorElement, 'Please select a job type.');
                return false;
            }

            return true;
        }

        function validateLocation() {
            const value = location.value.trim();
            const regex = /^[A-Za-z\s,.-]{3,100}$/;
            const errorElement = document.getElementById('location-error');

            clearError(location, errorElement);

            if (!value) {
                showError(location, errorElement, 'Location is required.');
                return false;
            }

            if (value.length < 3) {
                showError(location, errorElement, 'Location must be at least 3 characters long.');
                return false;
            }

            if (value.length > 100) {
                showError(location, errorElement, 'Location cannot exceed 100 characters.');
                return false;
            }

            if (!regex.test(value)) {
                showError(location, errorElement, 'Location format should be "City, Country" or "City, Province". Only letters, spaces, commas, periods, and hyphens are allowed.');
                return false;
            }

            if (!value.includes(',')) {
                showError(location, errorElement, 'Please use format: City, Country or City, Province.');
                return false;
            }

            return true;
        }

        function validateAgeRange() {
            const minValue = parseInt(minAge.value);
            const maxValue = parseInt(maxAge.value);
            const errorElement = document.getElementById('age-error');

            clearError(minAge, errorElement);
            clearError(maxAge, errorElement);

            // Both empty is valid
            if (!minAge.value && !maxAge.value) {
                return true;
            }

            // Validate individual values
            if (minAge.value) {
                if (minValue < 16 || minValue > 65) {
                    showError(minAge, errorElement, 'Minimum age must be between 16 and 65.');
                    return false;
                }
            }

            if (maxAge.value) {
                if (maxValue < 16 || maxValue > 65) {
                    showError(maxAge, errorElement, 'Maximum age must be between 16 and 65.');
                    return false;
                }
            }

            // Validate range
            if (minAge.value && maxAge.value && minValue >= maxValue) {
                showError(minAge, errorElement, 'Maximum age must be greater than minimum age.');
                minAge.classList.add('border-red-500');
                maxAge.classList.add('border-red-500');
                return false;
            }

            return true;
        }

        function validateSkills() {
            const value = skills.value.trim();
            const errorElement = document.getElementById('skills-error');

            clearError(skills, errorElement);

            // Skills are optional
            if (!value) {
                return true;
            }

            if (value.length > 500) {
                showError(skills, errorElement, 'Skills cannot exceed 500 characters.');
                return false;
            }

            const skillArray = value.split(',').map(skill => skill.trim()).filter(skill => skill);

            for (let skill of skillArray) {
                if (skill.length < 1 || skill.length > 30) {
                    showError(skills, errorElement, 'Each skill must be between 1 and 30 characters.');
                    return false;
                }

                // Check if skill is numbers only (unless it's tech-related)
                if (/^\d+$/.test(skill) && !['C++', 'HTML5', 'CSS3', 'PHP7', 'PHP8'].includes(skill)) {
                    showError(skills, errorElement, `"${skill}" appears to be numbers only. Please provide valid skill names.`);
                    return false;
                }
            }

            return true;
        }

        function validateJobSummary() {
            const value = jobSummary.value.trim();
            const errorElement = document.getElementById('job-summary-error');

            clearError(jobSummary, errorElement);

            if (!value) {
                showError(jobSummary, errorElement, 'Job summary is required.');
                return false;
            }

            if (value.length < 20) {
                showError(jobSummary, errorElement, 'Job summary must be at least 20 characters long.');
                return false;
            }

            if (value.length > 2000) {
                showError(jobSummary, errorElement, 'Job summary cannot exceed 2000 characters.');
                return false;
            }

            return true;
        }

        function validatePayRange() {
            const payTypeValue = payType.value;
            const payRangeValue = payRange.value.trim();
            const errorElement = document.getElementById('pay-range-error');

            clearError(payRange, errorElement);

            // If no pay type selected, pay range should be empty
            if (!payTypeValue && payRangeValue) {
                showError(payRange, errorElement, 'Please select a pay type first.');
                return false;
            }

            // If pay type selected but no range (optional)
            if (payTypeValue && !payRangeValue) {
                return true; // Optional
            }

            if (payRangeValue) {
                if (payRangeValue.length > 50) {
                    showError(payRange, errorElement, 'Pay range cannot exceed 50 characters.');
                    return false;
                }

                // Check format: number - number
                const rangeRegex = /^\d+\s*-\s*\d+$/;

                if (!rangeRegex.test(payRangeValue)) {
                    showError(payRange, errorElement, 'Pay range format should be: minimum - maximum (e.g., 20000 - 40000)');
                    return false;
                }

                const parts = payRangeValue.split('-').map(part => parseInt(part.trim()));
                const min = parts[0];
                const max = parts[1];

                if (min >= max) {
                    showError(payRange, errorElement, 'Maximum pay must be greater than minimum pay.');
                    return false;
                }

                if (min <= 0 || max <= 0) {
                    showError(payRange, errorElement, 'Pay amounts must be greater than 0.');
                    return false;
                }
            }

            return true;
        }

        function validateFullDescription() {
            const value = fullDescription.value.trim();
            const errorElement = document.getElementById('full-description-error');

            clearError(fullDescription, errorElement);

            if (!value) {
                showError(fullDescription, errorElement, 'Full description is required.');
                return false;
            }

            if (value.length < 100) {
                showError(fullDescription, errorElement, 'Full description must be at least 100 characters long.');
                return false;
            }

            if (value.length > 5000) {
                showError(fullDescription, errorElement, 'Full description cannot exceed 5000 characters.');
                return false;
            }

            return true;
        }

        function validateApplicationDates() {
            const startValue = applicationStart.value;
            const deadlineValue = applicationDeadline.value;
            const startError = document.getElementById('application-start-error');
            const deadlineError = document.getElementById('application-deadline-error');

            clearError(applicationStart, startError);
            clearError(applicationDeadline, deadlineError);

            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            // Validate start date
            if (startValue) {
                const startDate = new Date(startValue);
                if (startDate < today) {
                    showError(applicationStart, startError, 'Application start date cannot be in the past.');
                    return false;
                }
            }

            // Validate deadline
            if (deadlineValue) {
                const deadlineDate = new Date(deadlineValue);
                if (deadlineDate < today) {
                    showError(applicationDeadline, deadlineError, 'Application deadline cannot be in the past.');
                    return false;
                }

                // If both dates are provided, deadline should be after start
                if (startValue) {
                    const startDate = new Date(startValue);
                    if (deadlineDate <= startDate) {
                        showError(applicationDeadline, deadlineError, 'Application deadline must be after the start date.');
                        return false;
                    }
                }
            }

            return true;
        }

        // Helper functions
        function showError(element, errorElement, message) {
            element.classList.add('border-red-500');
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }

        function clearError(element, errorElement) {
            element.classList.remove('border-red-500');
            errorElement.textContent = '';
            errorElement.classList.add('hidden');
        }

        // Character counters
        function updateAllCharacterCounts() {
            if (titleCount) titleCount.textContent = jobTitle.value.length;
            if (locationCount) locationCount.textContent = location.value.length;
            if (skillsCount) skillsCount.textContent = skills.value.length;
            if (summaryCount) summaryCount.textContent = jobSummary.value.length;
            if (payRangeCount) payRangeCount.textContent = payRange.value.length;
            if (descriptionCount) descriptionCount.textContent = fullDescription.value.length;
        }

        // Event listeners for real-time validation and character counting
        jobTitle.addEventListener('input', function() {
            updateAllCharacterCounts();
        });
        jobTitle.addEventListener('blur', validateJobTitle);

        location.addEventListener('input', function() {
            updateAllCharacterCounts();
        });
        location.addEventListener('blur', validateLocation);

        skills.addEventListener('input', function() {
            updateAllCharacterCounts();
        });
        skills.addEventListener('blur', validateSkills);

        jobSummary.addEventListener('input', function() {
            updateAllCharacterCounts();
            validateJobSummary();
        });

        payRange.addEventListener('input', function() {
            updateAllCharacterCounts();
        });
        payRange.addEventListener('blur', validatePayRange);

        fullDescription.addEventListener('input', function() {
            updateAllCharacterCounts();
            validateFullDescription();
        });

        jobCategory.addEventListener('change', validateJobCategory);
        jobType.addEventListener('change', validateJobType);
        minAge.addEventListener('input', validateAgeRange);
        maxAge.addEventListener('input', validateAgeRange);
        payType.addEventListener('change', validatePayRange);
        applicationStart.addEventListener('change', validateApplicationDates);
        applicationDeadline.addEventListener('change', validateApplicationDates);

        // Initialize character counts
        updateAllCharacterCounts();

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Run all validations
            if (!validateJobTitle()) isValid = false;
            if (!validateJobCategory()) isValid = false;
            if (!validateJobType()) isValid = false;
            if (!validateLocation()) isValid = false;
            if (!validateAgeRange()) isValid = false;
            if (!validateSkills()) isValid = false;
            if (!validateJobSummary()) isValid = false;
            if (!validatePayRange()) isValid = false;
            if (!validateFullDescription()) isValid = false;
            if (!validateApplicationDates()) isValid = false;

            if (!isValid) {
                e.preventDefault();

                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return false;
            }
        });
    });
</script>