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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Review & Complete Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Review all information before completing your profile setup
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
                        <a href="?page=complete-jobseeker-profile&step=2" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Basic Info</span>
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">7</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 100%"></div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Personal Information Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Personal Information
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=2" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Full Name</span>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                <?php
                                $fullName = trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? ''));
                                echo htmlspecialchars($fullName ?: 'N/A');
                                ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Email</span>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Contact Number</span>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Date of Birth</span>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                <?php
                                echo $jobseeker['date_of_birth'] ? date('F j, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A';
                                ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Gender</span>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($jobseeker['sex'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Address</span>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($jobseeker['address'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Documents Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documents
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=1" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($documents)): ?>
                        <div class="space-y-2">
                            <?php foreach ($documents as $document): ?>
                                <div class="p-3 bg-white border rounded-md">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($document['file_type']); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($document['file_name']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No documents uploaded yet.</p>
                    <?php endif; ?>
                </div>

                <!-- Education Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Education
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=3" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($education) && $education[0]['school_name'] !== 'N/A'): ?>
                        <div class="p-3 bg-white rounded-md">
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Institution</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($education[0]['school_name']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Degree/Program</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($education[0]['education_level']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Field of Study</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($education[0]['field_of_study']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Duration</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        <?php
                                        $startYear = $education[0]['start_date'] ? date('Y', strtotime($education[0]['start_date'])) : 'N/A';
                                        $endYear = $education[0]['end_date'] ? date('Y', strtotime($education[0]['end_date'])) : 'N/A';
                                        echo "$startYear - $endYear";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No educational background information.</p>
                    <?php endif; ?>
                </div>

                <!-- Work Experience Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2v0" />
                            </svg>
                            Work Experience
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=4" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($workExperience)): ?>
                        <div class="p-3 bg-white rounded-md">
                            <?php
                            $currentWork = null;
                            foreach ($workExperience as $work) {
                                if ($work['currently_working'] === 'Yes') {
                                    $currentWork = $work;
                                    break;
                                }
                            }
                            ?>
                            <?php if ($currentWork): ?>
                                <div class="pb-3 mb-3 border-b">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($currentWork['job_title']); ?></h4>
                                        <span class="inline-flex px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Current</span>
                                    </div>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($currentWork['company_name']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php
                            $previousJobs = array_filter($workExperience, function ($work) {
                                return $work['currently_working'] !== 'Yes';
                            });
                            if (!empty($previousJobs)):
                            ?>
                                <div class="mb-2 text-xs font-medium text-gray-500">Previous Experience</div>
                                <?php foreach (array_slice($previousJobs, 0, 2) as $work): ?>
                                    <div class="mb-2 last:mb-0">
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($work['job_title']); ?></p>
                                        <p class="text-xs text-gray-600"><?php echo htmlspecialchars($work['company_name']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No work experience information.</p>
                    <?php endif; ?>
                </div>

                <!-- Skills Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Skills & Expertise
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=5" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($skills)): ?>
                        <div class="p-3 bg-white rounded-md">
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($skills as $skill): ?>
                                    <?php if ($skill['skill_name'] !== 'N/A'): ?>
                                        <div class="inline-flex items-center px-3 py-1 text-sm bg-gray-100 rounded-full">
                                            <span class="font-medium text-gray-900"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                            <span class="ml-2 text-xs
                                                <?php
                                                switch ($skill['proficiency_level']) {
                                                    case 'Expert':
                                                        echo 'text-purple-600';
                                                        break;
                                                    case 'Advanced':
                                                        echo 'text-green-600';
                                                        break;
                                                    case 'Intermediate':
                                                        echo 'text-blue-600';
                                                        break;
                                                    default:
                                                        echo 'text-gray-600';
                                                }
                                                ?>">
                                                (<?php echo htmlspecialchars($skill['proficiency_level']); ?>)
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No skills information provided.</p>
                    <?php endif; ?>
                </div>

                <!-- Certificates Summary -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Certificates
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=6" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($certificates) && $certificates[0]['certificate_title'] !== 'N/A'): ?>
                        <div class="p-3 bg-white rounded-md">
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Certificate/License</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($certificates[0]['certificate_title']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Issuing Organization</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($certificates[0]['issuing_organization']); ?></p>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Date Issued</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        <?php echo $certificates[0]['date_issued'] ? date('F j, Y', strtotime($certificates[0]['date_issued'])) : 'N/A'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No certificates or licenses information.</p>
                    <?php endif; ?>
                </div>
            </div>

            <form method="POST" action="?page=complete-jobseeker-profile&step=7" class="mt-8">
                <div class="flex justify-center">
                    <button type="submit"
                        class="inline-flex items-center px-8 py-3 text-base font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Complete Profile Setup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>