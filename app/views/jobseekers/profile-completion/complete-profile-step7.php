<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
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
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

                            Personal Information
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=2" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Full Name</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php
                                $fullName = trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? ''));
                                echo htmlspecialchars($fullName ?: 'N/A');
                                ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Email</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Contact Number</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Date of Birth</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php
                                echo $jobseeker['date_of_birth'] ? date('F j, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A';
                                ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Gender</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($jobseeker['sex'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Address</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($jobseeker['address'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Documents Summary -->
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

                            Documents
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=1" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($documents)): ?>
                        <div class="space-y-2">
                            <?php foreach ($documents as $document): ?>
                                <div class="p-3 bg-white border rounded-md ">
                                    <div class="flex ">
                                        <div class="flex items-center justify-center w-12 h-12 mr-2 bg-red-100 rounded-md hover:bg-red-200">
                                            <img
                                                src="../public/assets/icons/pdf-icon.png"
                                                alt="Icon"
                                                class="object-cover w-8 h-8" />
                                        </div>
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
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

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
                                    <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($education[0]['school_name']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Degree/Program</span>
                                    <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($education[0]['education_level']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Field of Study</span>
                                    <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($education[0]['field_of_study']); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Duration</span>
                                    <p class="mt-1 text-sm text-grayMain">
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
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

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
                                        <span class="inline-flex px-2 py-1 text-xs font-medium border border-gray-200 rounded-md text-primary">Current</span>
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
                        <p class="p-3 text-xs text-gray-600 bg-gray-100 rounded-md">No work experience information.</p>
                    <?php endif; ?>
                </div>

                <!-- Skills Summary -->
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

                            Skills & Expertise
                            <span class="ml-2 text-xs font-light text-gray-400">(<?php echo count($skills); ?> skills)</span>
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=5" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($skills)): ?>
                        <div class="p-3 ">
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($skills as $skill): ?>
                                    <?php if (!empty($skill['skill_name']) && $skill['skill_name'] !== 'N/A'): ?>
                                        <div class="inline-flex items-center px-3 py-1 text-sm border border-gray-100 rounded-md">
                                            <span class="text-sm text-grayMain"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                            <span class="ml-2 text-xs
                                <?php
                                        switch ($skill['proficiency_level'] ?? 'Intermediate') {
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
                                                (<?php echo htmlspecialchars($skill['proficiency_level'] ?? 'Intermediate'); ?>)
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
                <div class="p-4 border border-gray-200 rounded-lg ">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">

                            Certificates & Licenses
                            <span class="ml-2 text-xs font-light text-gray-400">(<?php echo count($certificates); ?> certificates)</span>
                        </h3>
                        <a href="?page=complete-jobseeker-profile&step=6" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <?php if (!empty($certificates)): ?>
                        <div class="space-y-3">
                            <?php foreach ($certificates as $index => $cert): ?>
                                <?php if (!empty($cert['certificate_title']) && $cert['certificate_title'] !== 'N/A'): ?>
                                    <div class="p-3 bg-white border-l-4 border-blue-500 rounded-md">
                                        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                            <div>
                                                <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Certificate</span>
                                                <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($cert['certificate_title']); ?></p>
                                            </div>
                                            <div>
                                                <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Issuing Organization</span>
                                                <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($cert['issuing_organization'] ?? 'Unknown'); ?></p>
                                            </div>
                                            <div>
                                                <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Date Issued</span>
                                                <p class="mt-1 text-sm text-grayMain">
                                                    <?php echo $cert['date_issued'] ? date('F j, Y', strtotime($cert['date_issued'])) : 'N/A'; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    // Show only first 3 certificates to avoid cluttering
                                    if ($index >= 2) {
                                        if (count($certificates) > 3) {
                                            echo '<p class="p-2 text-xs text-center text-gray-500">... and ' . (count($certificates) - 3) . ' more certificate(s)</p>';
                                        }
                                        break;
                                    }
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No certificates or licenses information.</p>
                    <?php endif; ?>
                </div>
            </div>

            <form method="POST" action="?page=complete-jobseeker-profile&step=7" class="mt-8">
                <div class="flex items-center justify-between">
                    <!-- Left Side - Previous Button -->
                    <div>
                        <a href="?page=complete-jobseeker-profile&step=6"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Previous Step
                        </a>
                    </div>

                    <!-- Right Side - Complete Profile Button -->
                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Complete Profile Setup
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>