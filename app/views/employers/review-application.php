<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Header with back button -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="?page=manage-applications" class="flex items-center text-sm font-medium transition-colors text-primary hover:text-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Applications
                </a>
                <h1 class="mt-2 text-2xl font-bold text-gray-900">Review Application</h1>
            </div>
            <span class="px-3 py-1 text-xs font-medium rounded-full 
                <?php
                switch ($application['application_status']) {
                    case 'pending':
                        echo 'bg-yellow-100 text-yellow-800';
                        break;
                    case 'reviewed':
                        echo 'bg-blue-100 text-blue-800';
                        break;
                    case 'shortlisted':
                        echo 'bg-purple-100 text-purple-800';
                        break;
                    case 'rejected':
                        echo 'bg-red-100 text-red-800';
                        break;
                    case 'hired':
                        echo 'bg-green-100 text-green-800';
                        break;
                    default:
                        echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php echo ucfirst($application['application_status']); ?>
            </span>
        </div>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row" x-data="{ activeTab: 'profile' }">

            <!-- Left Section - Applicant Summary (4/12 width) -->
            <div class="w-full md:w-4/12">
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Applicant Header -->
                    <div class="px-6 py-6 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <?php if (!empty($application['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($application['profile_picture']); ?>"
                                    alt="Profile"
                                    class="object-cover w-16 h-16 border border-gray-200 rounded-full">
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 truncate">
                                    <?php echo htmlspecialchars(trim(($application['first_name'] ?? '') . ' ' . ($application['middle_name'] ?? '') . ' ' . ($application['last_name'] ?? '') . ' ' . ($application['suffix'] ?? ''))); ?>
                                </h3>
                                <p class="text-sm text-gray-600 truncate">
                                    <?php echo htmlspecialchars($application['email'] ?? ''); ?>
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    <?php echo htmlspecialchars($application['contact_no'] ?? 'No phone provided'); ?>
                                </p>
                                <p class="mt-1 text-xs text-gray-400">
                                    Applied <?php echo date('M j, Y', strtotime($application['applied_at'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Application Details -->
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <h4 class="mb-3 text-sm font-medium text-gray-900">Application Details</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-xs font-medium text-gray-500">Application ID</span>
                                    <span class="text-xs text-gray-900">#<?php echo htmlspecialchars($application['application_id']); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs font-medium text-gray-500">Jobseeker ID</span>
                                    <span class="text-xs text-gray-900">#<?php echo htmlspecialchars($application['jobseeker_id']); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs font-medium text-gray-500">Status</span>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                        <?php
                                        switch ($application['application_status']) {
                                            case 'pending':
                                                echo 'text-yellow-800 bg-yellow-100';
                                                break;
                                            case 'reviewed':
                                                echo 'text-blue-800 bg-blue-100';
                                                break;
                                            case 'shortlisted':
                                                echo 'text-purple-800 bg-purple-100';
                                                break;
                                            case 'rejected':
                                                echo 'text-red-800 bg-red-100';
                                                break;
                                            case 'hired':
                                                echo 'text-green-800 bg-green-100';
                                                break;
                                            default:
                                                echo 'text-gray-800 bg-gray-100';
                                        }
                                        ?>">
                                        <?php echo ucfirst($application['application_status']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="mb-3 text-sm font-medium text-gray-900">Quick Actions</h4>
                            <div class="space-y-2">
                                <button class="w-full px-3 py-2 text-xs font-medium text-left text-green-700 transition-colors rounded-md bg-green-50 hover:bg-green-100">
                                    <svg class="inline-block w-2 h-2 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Accept Application
                                </button>
                                <button class="w-full px-3 py-2 text-xs font-medium text-left text-red-700 transition-colors rounded-md bg-red-50 hover:bg-red-100">
                                    <svg class="inline-block w-2 h-2 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reject Application
                                </button>
                                <button class="w-full px-3 py-2 text-xs font-medium text-left transition-colors rounded-md text-primary bg-blue-50 hover:bg-blue-100">
                                    <svg class="inline-block w-2 h-2 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Schedule Interview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Detailed View with Tabs (8/12 width) -->
            <div class="w-full md:w-8/12">
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex px-6 space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'profile'"
                                :class="activeTab === 'profile' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Applicant Profile
                            </button>
                            <button @click="activeTab = 'resume'"
                                :class="activeTab === 'resume' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Resume
                            </button>
                            <button @click="activeTab = 'application'"
                                :class="activeTab === 'application' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Application
                            </button>
                            <button @click="activeTab = 'schedule'"
                                :class="activeTab === 'schedule' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Schedule Interview
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6 min-h-[600px]">
                        <!-- Applicant Profile Tab -->
                        <div x-show="activeTab === 'profile'" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-4">
                                    <h4 class="text-lg font-medium text-gray-900">Personal Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                            <p class="mt-1 text-sm text-gray-900">
                                                <?php echo htmlspecialchars(trim(($application['first_name'] ?? '') . ' ' . ($application['middle_name'] ?? '') . ' ' . ($application['last_name'] ?? '') . ' ' . ($application['suffix'] ?? ''))); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['email'] ?? 'Not provided'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Contact Number</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['contact_no'] ?? 'Not provided'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Address</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['address'] ?? 'Not provided'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                                            <p class="mt-1 text-sm text-gray-900">
                                                <?php
                                                if (!empty($application['date_of_birth'])) {
                                                    $birthDate = new DateTime($application['date_of_birth']);
                                                    $today = new DateTime();
                                                    $age = $today->diff($birthDate)->y;
                                                    echo date('F j, Y', strtotime($application['date_of_birth'])) . " (Age: $age)";
                                                } else {
                                                    echo 'Not provided';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Gender</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars(ucfirst($application['sex'] ?? 'Not specified')); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <h4 class="text-lg font-medium text-gray-900">Application Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Position Applied</label>
                                            <p class="mt-1 text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($application['job_title'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Job Type</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $application['job_type'] ?? ''))); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Location</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['location'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Applied Date</label>
                                            <p class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y \a\t g:i A', strtotime($application['applied_at'])); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Current Status</label>
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php
                                                switch ($application['application_status']) {
                                                    case 'pending':
                                                        echo 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'reviewed':
                                                        echo 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'shortlisted':
                                                        echo 'bg-purple-100 text-purple-800';
                                                        break;
                                                    case 'rejected':
                                                        echo 'bg-red-100 text-red-800';
                                                        break;
                                                    case 'hired':
                                                        echo 'bg-green-100 text-green-800';
                                                        break;
                                                    default:
                                                        echo 'bg-gray-100 text-gray-800';
                                                }
                                                ?>">
                                                <?php echo ucfirst($application['application_status']); ?>
                                            </span>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Application ID</label>
                                            <p class="mt-1 font-mono text-sm text-gray-900">#<?php echo htmlspecialchars($application['application_id']); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Profile Completion</label>
                                            <div class="mt-1">
                                                <?php $completion = $application['profile_completion'] ?? 0; ?>
                                                <div class="flex items-center">
                                                    <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                                        <div class="bg-primary h-2 rounded-full" style="width: <?php echo $completion; ?>%"></div>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900"><?php echo $completion; ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Summary for Context -->
                            <?php if (!empty($application['job_summary'])): ?>
                                <div class="pt-6 border-t border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900 mb-3">Position Overview</h4>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h5 class="font-medium text-gray-900 mb-2"><?php echo htmlspecialchars($application['job_title']); ?></h5>
                                        <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($application['job_summary'])); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Resume Tab -->
                        <div x-show="activeTab === 'resume'">
                            <div class="py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Resume Preview</h3>
                                <p class="mt-1 text-sm text-gray-500">View and download the applicant's resume</p>
                                <div class="mt-6 space-x-3">
                                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Resume
                                    </button>
                                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        Download Resume
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Application Tab -->
                        <div x-show="activeTab === 'application'">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="mb-4 text-lg font-medium text-gray-900">Update Application Status</h4>
                                    <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="space-y-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                            <select name="application_status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                                <?php foreach (['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'] as $status): ?>
                                                    <option value="<?php echo $status; ?>" <?php if ($application['application_status'] == $status) echo 'selected'; ?>>
                                                        <?php echo ucfirst($status); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Update Status
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="pt-6 border-t border-gray-200">
                                    <h5 class="mb-3 font-medium text-gray-900">Cover Letter</h5>
                                    <div class="p-4 text-sm text-gray-700 rounded-lg bg-gray-50">
                                        <?php echo htmlspecialchars($application['cover_letter'] ?? 'No cover letter provided.'); ?>
                                    </div>
                                </div>

                                <div class="flex pt-4 space-x-4">
                                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Accept Application
                                    </button>
                                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject Application
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Interview Tab -->
                        <div x-show="activeTab === 'schedule'">
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-medium text-gray-900">Interview Schedule</h4>
                                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add Schedule Interview
                                    </button>
                                </div>

                                <!-- Interview Scheduling Form -->
                                <form method="POST" action="?page=review-application&action=scheduleInterview&application_id=<?php echo $application['application_id']; ?>" class="space-y-6">
                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Date & Time</label>
                                            <input type="datetime-local" name="interview_date"
                                                value="<?php echo htmlspecialchars($interview['interview_date'] ?? ''); ?>"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                            <input type="text" name="interview_location"
                                                value="<?php echo htmlspecialchars($interview['interview_location'] ?? ''); ?>"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                                                placeholder="Office address or Zoom meeting link">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Notes</label>
                                        <textarea name="notes" rows="4"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                                            placeholder="Add any additional instructions for the candidate"><?php echo htmlspecialchars($interview['notes'] ?? ''); ?></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Schedule Interview
                                        </button>
                                    </div>
                                </form>

                                <!-- Sample Interview Schedule (like in the reference image) -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h5 class="mb-4 font-medium text-gray-900">Interview List</h5>
                                    <div class="space-y-3">
                                        <div class="p-4 border rounded-lg">
                                            <div class="flex items-center justify-between mb-2">
                                                <h6 class="font-medium text-gray-900">Tomorrow - 10 July, 2021</h6>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full">
                                                    <span class="text-xs font-medium text-gray-600">KM</span>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Kathryn Murphy</p>
                                                    <p class="text-xs text-gray-500">Written Test</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-medium text-gray-900">10:00 AM - 11:30 AM</p>
                                                    <p class="text-xs text-gray-500">Silver Crysta Room, Nomad</p>
                                                </div>
                                                <button class="text-sm font-medium text-primary hover:text-primary-dark">
                                                    Add Feedback
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>