<!-- Profile Content (Default Tab) -->
<div class="grid w-full grid-cols-1 gap-4 mb-8 md:grid-cols-2">
    <!-- Profile Details Header -->
    <div class="flex items-center justify-between w-full col-span-1 mb-4 md:col-span-2">
        <h4 class="text-base font-semibold text-primary">Profile Details</h4>
        <a href="?page=complete-jobseeker-profile&step=3"
            class="flex items-center text-sm text-primary hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>

    <div>
        <p class="text-xs text-gray-500">Full Name</p>
        <p class="text-sm">
            <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? '') . ' ' . ($jobseeker['suffix'] ?? ''))); ?>
        </p>
    </div>
    <div>
        <p class="text-xs text-gray-500">Gender</p>
        <p class="text-sm"><?php echo htmlspecialchars($jobseeker['sex'] ?? 'N/A'); ?></p>
    </div>
    <div>
        <p class="text-xs text-gray-500">Date of Birth</p>
        <p class="text-sm">
            <?php echo !empty($jobseeker['date_of_birth']) && $jobseeker['date_of_birth'] ? date('F j, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A'; ?>
        </p>
    </div>
    <div>
        <p class="text-xs text-gray-500">Phone Number</p>
        <p class="text-sm"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
    </div>
    <div class="md:col-span-2">
        <p class="text-xs text-gray-500">Address</p>
        <p class="text-sm"><?php echo htmlspecialchars($jobseeker['address'] ?? 'N/A'); ?></p>
    </div>
    <div class="md:col-span-2">
        <p class="text-xs text-gray-500">Email</p>
        <p class="text-sm"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
    </div>
</div>

<!-- Employment Status Section -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-base font-semibold text-primary">Employment Status</h4>
        <a href="?page=complete-jobseeker-profile&step=5"
            class="flex items-center text-sm text-primary hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>

    <?php if (!empty($workExperience) && is_array($workExperience) && isset($workExperience[0]['currently_working']) && $workExperience[0]['currently_working'] === 'Yes'): ?>
        <p class="mb-4 text-sm text-gray-500">
            Currently working as <?php echo htmlspecialchars($workExperience[0]['job_title'] ?? 'N/A'); ?>
            at <?php echo htmlspecialchars($workExperience[0]['company_name'] ?? 'N/A'); ?>.
        </p>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <p class="text-xs text-gray-500">Current Job</p>
                <p class="text-sm font-medium"><?php echo htmlspecialchars($workExperience[0]['job_title'] ?? 'N/A'); ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Company</p>
                <p class="text-sm font-medium"><?php echo htmlspecialchars($workExperience[0]['company_name'] ?? 'N/A'); ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Employment Type</p>
                <p class="text-sm font-medium"><?php echo htmlspecialchars(ucfirst($workExperience[0]['employment_type'] ?? 'N/A')); ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Start Date</p>
                <p class="text-sm font-medium">
                    <?php echo !empty($workExperience[0]['start_date']) ? date('M Y', strtotime($workExperience[0]['start_date'])) : 'N/A'; ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <p class="p-3 text-xs text-gray-500 border border-gray-200 rounded bg-gray-50">
            Currently seeking employment opportunities.
        </p>
    <?php endif; ?>
</div>

<!-- Work Experience Card -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-base font-semibold text-primary">Work Experience</h4>
        <a href="?page=complete-jobseeker-profile&step=5"
            class="flex items-center text-sm text-primary hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>
    <?php if (!empty($workExperience) && is_array($workExperience)): ?>
        <div class="space-y-4">
            <?php foreach ($workExperience as $work): ?>
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                        <div>
                            <p class="text-xs text-gray-400">Job Title</p>
                            <p class="font-medium"><?php echo htmlspecialchars($work['job_title'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Duration</p>
                            <p class="font-medium">
                                <?php
                                $start = !empty($work['start_date']) ? date('M Y', strtotime($work['start_date'])) : 'N/A';
                                $end = ($work['currently_working'] ?? '') === 'Yes' ? 'Present' : (!empty($work['end_date']) ? date('M Y', strtotime($work['end_date'])) : 'N/A');
                                echo $start . ' - ' . $end;
                                ?>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-400">Company/Organization</p>
                            <p class="font-medium"><?php echo htmlspecialchars($work['company_name'] ?? 'N/A'); ?></p>
                        </div>
                        <?php if (!empty($work['responsibilities']) && $work['responsibilities'] !== 'N/A'): ?>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-400">Responsibilities</p>
                                <p class="text-sm"><?php echo htmlspecialchars($work['responsibilities']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-500">No work experience added yet.</p>
    <?php endif; ?>
</div>

<!-- Educational Background Card -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-base font-semibold text-primary">Educational Background</h4>
        <a href="?page=complete-jobseeker-profile&step=4"
            class="flex items-center text-sm text-primary hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>
    <?php if (!empty($education) && is_array($education)): ?>
        <div class="space-y-4">
            <?php foreach ($education as $edu): ?>
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                        <div>
                            <p class="text-xs text-gray-400">Institution Name</p>
                            <p class="font-medium"><?php echo htmlspecialchars($edu['school_name'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Duration</p>
                            <p class="font-medium">
                                <?php
                                $start = !empty($edu['start_date']) ? date('Y', strtotime($edu['start_date'])) : '';
                                $end = !empty($edu['end_date']) ? date('Y', strtotime($edu['end_date'])) : '';
                                echo $start && $end ? $start . ' - ' . $end : 'N/A';
                                ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Degree/Program</p>
                            <p class="font-medium"><?php echo htmlspecialchars($edu['education_level'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Field of Study</p>
                            <p class="font-medium"><?php echo htmlspecialchars($edu['field_of_study'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-500">No educational background added yet.</p>
    <?php endif; ?>
</div>

<!-- Skills Card -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-base font-semibold text-primary">Skills & Expertise</h4>
        <a href="?page=complete-jobseeker-profile&step=6"
            class="flex items-center text-sm text-primary hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </a>
    </div>
    <?php if (!empty($skills) && is_array($skills)): ?>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($skills as $skill): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                <?php
                switch ($skill['proficiency_level'] ?? '') {
                    case 'Expert':
                        echo 'bg-green-100 text-green-800';
                        break;
                    case 'Advanced':
                        echo 'bg-blue-100 text-blue-800';
                        break;
                    case 'Intermediate':
                        echo 'bg-yellow-100 text-yellow-800';
                        break;
                    default:
                        echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                    <?php echo htmlspecialchars($skill['skill_name'] ?? 'N/A'); ?>
                    <span class="ml-1 text-xs opacity-75">(<?php echo $skill['proficiency_level'] ?? 'N/A'; ?>)</span>
                </span>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-500">No skills added yet.</p>
    <?php endif; ?>
</div>

<!-- Certificates Card -->
<?php if (!empty($certificates) && is_array($certificates)): ?>
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold text-primary">Certificates & Licenses</h4>
            <a href="?page=complete-jobseeker-profile&step=7"
                class="flex items-center text-sm text-primary hover:text-primary-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
        <div class="space-y-3">
            <?php foreach ($certificates as $cert): ?>
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <h5 class="text-sm font-medium"><?php echo htmlspecialchars($cert['certificate_title'] ?? 'N/A'); ?></h5>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($cert['issuing_organization'] ?? 'N/A'); ?></p>
                            <?php if (!empty($cert['date_issued'])): ?>
                                <p class="mt-1 text-xs text-gray-400">
                                    Issued: <?php echo date('M Y', strtotime($cert['date_issued'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>