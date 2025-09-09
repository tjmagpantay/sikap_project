<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Header with breadcrumbs -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <!-- Breadcrumb Navigation -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="?page=employer-dashboard" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <a href="?page=view-all-applicants" class="ml-1 text-sm text-gray-400 hover:text-gray-600 md:ml-2">
                                    Manage Applications
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-primary md:ml-2">Review Application</span>
                            </div>
                        </li>
                    </ol>
                </nav>

            </div>

        </div>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row" x-data="{ activeTab: 'profile', editingInterview: false }">

            <!-- Left Section - Applicant Profile Card -->
            <div class="w-full md:w-4/12">
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Profile Header with Circle Photo -->
                    <div class="flex items-center mb-6">
                        <!-- Circle Profile Photo -->
                        <div class="mr-4">
                            <?php if (!empty($application['profile_picture'])): ?>
                                <img src="<?php echo '/sikap/public/' . htmlspecialchars($application['profile_picture']); ?>"
                                    alt="Profile"
                                    class="object-cover w-16 h-16 rounded-full shadow-sm">
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Name and Date Applied -->
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">
                                <?php echo htmlspecialchars(trim(($application['first_name'] ?? '') . ' ' . ($application['last_name'] ?? ''))); ?>
                            </h3>
                            <p class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($application['position_applied'] ?? 'Job Applicant'); ?>
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Applied <?php echo date('M j, Y', strtotime($application['applied_at'])); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Profile Completion Card -->
                    <div class="p-4 mb-6 bg-gray-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Profile Completion</span>
                            <span class="text-sm font-bold text-primary">
                                <?php
                                $completion = $application['profile_completion_percentage'] ?? 0;
                                echo $completion;
                                ?>%
                            </span>
                        </div>
                        <div class="w-full h-2 bg-gray-200">
                            <div class="h-2 transition-all duration-300 bg-primary"
                                style="width: <?php echo $completion; ?>%"></div>
                        </div>
                    </div>

                    <!-- Status Button -->
                    <div class="mb-6">
                        <button class="w-full px-4 py-2 text-sm font-medium
                            <?php
                            switch ($application['application_status']) {
                                case 'pending':
                                    echo 'text-primary border-2 border-gray';
                                    break;
                                case 'reviewed':
                                    echo 'text-primary bg-blue-100 border-gray';
                                    break;
                                case 'shortlisted':
                                    echo 'text-primary  border border-gray';
                                    break;
                                case 'rejected':
                                    echo 'text-primary border border-gray';
                                    break;
                                case 'hired':
                                    echo 'text-white  border border-gray bg-secondary';
                                    break;
                                default:
                                    echo 'text-primary  border border-gray';
                            }
                            ?>">
                            <?php echo ucfirst($application['application_status']); ?>
                        </button>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-6">
                        <h4 class="mb-3 text-sm font-semibold text-gray-900">Contact</h4>
                        <div class="space-y-3">
                            <!-- Email -->
                            <?php if (!empty($application['email'])): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="break-all">
                                        <?php echo htmlspecialchars($application['email']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Phone -->
                            <?php if (!empty($application['contact_no'])): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span><?php echo htmlspecialchars($application['contact_no']); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Address -->
                            <?php if (!empty($application['address'])): ?>
                                <div class="flex items-start text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="break-words">
                                        <?php echo htmlspecialchars($application['address']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- LinkedIn/Social Media if available -->
                            <?php if (!empty($application['linkedin_url'])): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                    <a href="<?php echo htmlspecialchars($application['linkedin_url']); ?>" target="_blank" class="text-blue-600 break-all hover:text-blue-800">
                                        LinkedIn Profile
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Website if available -->
                            <?php if (!empty($application['website_url'])): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9-3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    <a href="<?php echo htmlspecialchars($application['website_url']); ?>" target="_blank" class="text-blue-600 break-all hover:text-blue-800">
                                        <?php echo htmlspecialchars(parse_url($application['website_url'], PHP_URL_HOST) ?? $application['website_url']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h4 class="mb-3 text-sm font-semibold text-gray-900">Quick Actions</h4>

                        <?php if ($resignationRequest && $resignationRequest['request_status'] === 'pending'): ?>
                            <!-- Resignation Request Pending Actions -->
                            <div class="p-4 mb-4 border border-orange-200 rounded-lg bg-orange-50">
                                <h5 class="text-sm font-medium text-orange-800">Pending Resignation Request</h5>
                                <p class="mt-1 text-xs text-orange-600">This employee has requested to resign from their position.</p>

                                <?php if (!empty($resignationRequest['resignation_reason'])): ?>
                                    <div class="mt-2">
                                        <p class="text-xs font-medium text-orange-700">Reason:</p>
                                        <p class="text-xs text-orange-600"><?php echo nl2br(htmlspecialchars($resignationRequest['resignation_reason'])); ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="flex gap-2 mt-3">
                                    <form method="POST" action="?page=review-application&action=approveResignation&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                        <textarea name="employer_notes" placeholder="Optional notes..." class="w-full mb-2 text-xs border border-orange-300 rounded"></textarea>
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to approve this resignation request?')"
                                            class="px-3 py-2 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700">
                                            Approve Resignation
                                        </button>
                                    </form>

                                    <form method="POST" action="?page=review-application&action=rejectResignation&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                        <textarea name="employer_notes" placeholder="Reason for rejection..." class="w-full mb-2 text-xs border border-red-300 rounded"></textarea>
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to reject this resignation request?')"
                                            class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                            Reject Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                            <!-- Accept Application Button -->
                            <?php if ($application['application_status'] !== 'hired' && $application['application_status'] !== 'resigned'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="hired">
                                    <button type="submit" class="w-full px-3 py-3 text-sm font-medium text-center transition-colors border rounded text-primary bg-blue-50 hover:bg-primary hover:text-white">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Accept
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Reject Application Button -->
                            <?php if ($application['application_status'] !== 'rejected' && $application['application_status'] !== 'resigned'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="w-full px-3 py-3 text-sm font-medium text-center transition-colors border rounded text-primary bg-blue-50 hover:bg-primary hover:text-white">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Mark as Reviewed Button -->
                            <?php if ($application['application_status'] === 'pending'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="w-full px-3 py-3 text-sm font-medium text-center transition-colors border rounded text-primary bg-blue-50 hover:bg-primary hover:text-white">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Reviewed
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Shortlist Button -->
                            <?php if (in_array($application['application_status'], ['pending', 'reviewed'])): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="shortlisted">
                                    <button type="submit" class="w-full px-3 py-3 text-sm font-medium text-center transition-colors border rounded text-primary bg-blue-50 hover:bg-primary hover:text-white">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.978 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.978-2.89a1 1 0 00-1.176 0l-3.978 2.89c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.978-2.89c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.518-4.674z" />
                                        </svg>
                                        Shortlist
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Set Resigned Button (New) -->
                            <?php if ($application['application_status'] === 'hired'): ?>
                                <form method="POST" action="?page=review-application&action=setResigned&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to set this employee as resigned? This action cannot be undone.')"
                                        class="w-full px-3 py-3 text-sm font-medium text-center text-orange-600 transition-colors border rounded bg-orange-50 hover:bg-orange-600 hover:text-white">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Set Resigned
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Schedule Interview Button -->
                            <button @click="activeTab = 'schedule'" class="w-full px-3 py-3 text-sm font-medium text-center transition-colors border rounded text-primary bg-blue-50 hover:bg-primary hover:text-white">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Schedule Interview
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Detailed View with Tabs (8/12 width) -->
            <div class="w-full md:w-8/12">
                <div class="overflow-hidden bg-white border border-gray-200 rounded-md shadow">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex gap-8 px-6 space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'profile'"
                                :class="activeTab === 'profile' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                Applicant Profile
                            </button>
                            <button @click="activeTab = 'resume'"
                                :class="activeTab === 'resume' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                Resume
                            </button>
                            <button @click="activeTab = 'application'"
                                :class="activeTab === 'application' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                Application
                            </button>
                            <button @click="activeTab = 'schedule'"
                                :class="activeTab === 'schedule' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-1 py-4 text-sm font-medium transition-colors duration-200 border-b-2 whitespace-nowrap">
                                Schedule Interview
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6 min-h-[600px]">
                        <!-- Applicant Profile Tab -->
                        <div x-show="activeTab === 'profile'" class="space-y-6">
                            <!-- Personal Information Section -->
                            <div class="space-y-4">
                                <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Personal Information</h4>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs text-gray-400">Full Name</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            <?php echo htmlspecialchars(trim(($application['first_name'] ?? '') . ' ' . ($application['middle_name'] ?? '') . ' ' . ($application['last_name'] ?? '') . ' ' . ($application['suffix'] ?? ''))); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Email Address</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['email'] ?? 'Not provided'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Contact Number</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['contact_no'] ?? 'Not provided'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Address</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['address'] ?? 'Not provided'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Date of Birth</label>
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
                                        <label class="block text-xs text-gray-400">Gender</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars(ucfirst($application['sex'] ?? 'Not specified')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills & Experience Summary -->
                            <?php if (!empty($application['skills']) || !empty($application['work_experience'])): ?>
                                <div class="space-y-4">
                                    <?php if (!empty($application['skills'])): ?>
                                        <div>
                                            <h4 class="pb-2 font-semibold border-b border-gray-200 text-primary text-md">Top Skills</h4>
                                            <div class="flex flex-wrap gap-2 mt-3">
                                                <?php foreach (array_slice($application['skills'], 0, 6) as $skill): ?>
                                                    <span class="px-2 py-1 text-xs font-medium rounded text-primary bg-blue-50 hover:bg-blue-100">
                                                        <?php echo htmlspecialchars($skill['skill_name']); ?>
                                                        <?php if (!empty($skill['proficiency_level'])): ?>
                                                            (<?php echo htmlspecialchars($skill['proficiency_level']); ?>)
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($application['work_experience'])): ?>
                                        <div>
                                            <h4 class="pb-2 font-semibold border-b border-gray-200 text-primary text-md">Recent Experience</h4>
                                            <div class="mt-3 space-y-2">
                                                <?php foreach (array_slice($application['work_experience'], 0, 2) as $work): ?>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($work['job_title']); ?></p>
                                                        <p class="text-xs text-gray-600"><?php echo htmlspecialchars($work['company_name']); ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Education Section -->
                            <?php if (!empty($application['education'])): ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Education Background</h4>
                                    <div class="space-y-4">
                                        <?php foreach ($application['education'] as $education): ?>
                                            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <h5 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($education['school_name']); ?></h5>
                                                        <p class="text-xs text-gray-400"><?php echo htmlspecialchars($education['education_level']); ?></p>
                                                        <?php if (!empty($education['field_of_study'])): ?>
                                                            <p class="text-xs text-gray-400"><?php echo htmlspecialchars($education['field_of_study']); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php
                                                        if (!empty($education['start_date'])) {
                                                            echo date('M Y', strtotime($education['start_date']));
                                                            if (!empty($education['end_date'])) {
                                                                echo ' - ' . date('M Y', strtotime($education['end_date']));
                                                            } else {
                                                                echo ' - Present';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Detailed Work Experience Section -->
                            <?php if (!empty($application['work_experience'])): ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Complete Work Experience</h4>
                                    <div class="space-y-4">
                                        <?php foreach ($application['work_experience'] as $work): ?>
                                            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div class="flex-1">
                                                        <h5 class="font-medium text-gray-900"><?php echo htmlspecialchars($work['job_title']); ?></h5>
                                                        <p class="text-sm text-gray-700"><?php echo htmlspecialchars($work['company_name']); ?></p>
                                                        <?php if (!empty($work['employment_type'])): ?>
                                                            <span class="inline-block px-2 py-1 mt-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">
                                                                <?php echo htmlspecialchars(ucfirst($work['employment_type'])); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php
                                                        if (!empty($work['start_date'])) {
                                                            echo date('M Y', strtotime($work['start_date']));
                                                            if (!empty($work['end_date']) && $work['currently_working'] != 1) {
                                                                echo ' - ' . date('M Y', strtotime($work['end_date']));
                                                            } elseif ($work['currently_working'] == 1) {
                                                                echo ' - Present';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php if (!empty($work['responsibilities'])): ?>
                                                    <div class="mt-2">
                                                        <p class="text-xs font-medium text-gray-400">Responsibilities:</p>
                                                        <p class="mt-1 text-sm text-gray-600"><?php echo nl2br(htmlspecialchars($work['responsibilities'])); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($work['achievements'])): ?>
                                                    <div class="mt-2">
                                                        <p class="text-xs font-medium text-gray-400">Achievements:</p>
                                                        <p class="mt-1 text-sm text-gray-600"><?php echo nl2br(htmlspecialchars($work['achievements'])); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>



                            <!-- Certificates Section -->
                            <?php if (!empty($application['certificates'])): ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Certificates & Achievements</h4>
                                    <div class="space-y-3">
                                        <?php foreach ($application['certificates'] as $certificate): ?>
                                            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <div>
                                                            <h5 class="font-medium text-gray-900"><?php echo htmlspecialchars($certificate['certificate_title']); ?></h5>
                                                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($certificate['issuing_organization']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php if (!empty($certificate['date_issued'])): ?>
                                                            <?php echo date('M Y', strtotime($certificate['date_issued'])); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Application Eligibility Information -->
                            <?php if (!empty($application['interested_program']) || !empty($application['priority_sector'])): ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Application Preferences</h4>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <?php if (!empty($application['interested_program'])): ?>
                                            <div>
                                                <label class="block text-xs text-gray-400">Interested Program</label>
                                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['interested_program']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($application['priority_sector'])): ?>
                                            <div>
                                                <label class="block text-xs text-gray-400">Priority Sector</label>
                                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['priority_sector']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                        </div>
                        <!-- Resume Tab -->
                        <div x-show="activeTab === 'resume'">
                            <?php if (!empty($application['resume_documents'])): ?>
                                <div class="space-y-4">
                                    <h2 class="mb-4 font-semibold text-primary text-md">Resume & CV Documents</h2>
                                    <?php foreach ($application['resume_documents'] as $document): ?>
                                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                                            <div class="flex items-center">
                                                <!-- PDF Icon Container -->
                                                <div class="flex items-center justify-center w-12 h-12 mr-3 overflow-hidden bg-red-100 rounded-lg">
                                                    <img
                                                        src="../public/assets/icons/pdf-icon.png"
                                                        alt="Icon"
                                                        class="object-cover w-8 h-8" />
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-primary"><?php echo htmlspecialchars($document['file_name']); ?></div>
                                                    <div class="text-xs text-gray-500">
                                                        Type: <?php echo htmlspecialchars(ucfirst($document['file_type'])); ?> •
                                                        Uploaded: <?php echo date('M j, Y', strtotime($document['uploaded_at'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="?page=download-document&doc_id=<?php echo $document['document_id']; ?>"
                                                    target="_blank"
                                                    class="px-4 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                    View
                                                </a>
                                                <a href="?page=download-document&doc_id=<?php echo $document['document_id']; ?>&download=1"
                                                    class="px-4 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-gray-50 hover:bg-gray-100">
                                                    Download ↓
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Resume Found</h3>
                                    <p class="mt-1 text-sm text-gray-500">This applicant hasn't uploaded a resume or CV yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Application Tab -->
                        <!-- Application Tab -->
                        <div x-show="activeTab === 'application'" class="space-y-6">
                            <!-- Application Information Section -->
                            <div class="space-y-4">
                                <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Application Information</h4>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs text-gray-400">Job Type</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $application['job_type'] ?? ''))); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Location</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['location'] ?? 'N/A'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Pay Range</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['pay_range'] ?? 'N/A'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Applied Date</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y \a\t g:i A', strtotime($application['applied_at'])); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Current Status</label>
                                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 text-xs font-medium
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
                                        <label class="block text-xs text-gray-400">Interested Program</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['interested_program'] ?? 'None'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400">Priority Sector</label>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['priority_sector'] ?? 'None'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cover Letter -->
                            <div class="space-y-4">
                                <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Cover Letter</h4>
                                <div class="p-6 rounded-lg bg-gray-50">
                                    <p class="text-sm leading-relaxed text-gray-900">
                                        <?= htmlspecialchars($application['cover_letter'] ?? 'No cover letter provided.') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Job Summary for Context -->
                            <?php if (!empty($application['job_summary'])): ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Position Overview</h4>
                                    <div class="p-4 rounded-lg bg-gray-50">
                                        <h5 class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['job_title']); ?></h5>
                                        <p class="text-xs text-gray-400"><?php echo nl2br(htmlspecialchars($application['job_summary'])); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Application Status Management -->
                            <div class="space-y-4">
                                <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Update Application Status</h4>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="space-y-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-xs">
                                            <?php foreach (['pending', 'reviewed', 'shortlisted', 'rejected', 'hired', 'resigned'] as $status): ?>
                                                <option value="<?php echo $status; ?>" <?php if ($application['application_status'] == $status) echo 'selected'; ?>>
                                                    <?php echo ucfirst($status); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Update Status
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Schedule Interview Tab -->
                        <div x-show="activeTab === 'schedule'">
                            <div class="space-y-6">
                                <!-- Header Section -->
                                <div class="flex items-center justify-between">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Interview Schedule</h4>

                                    <?php if (!empty($interview) && !empty($interview['interview_date'])): ?>
                                        <!-- Edit Button - Show only when interview exists and not editing -->
                                        <button @click="editingInterview = true"
                                            x-show="!editingInterview"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent shadow-sm bg-primary hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Schedule
                                        </button>

                                        <!-- Cancel Edit Button - Show only when editing -->
                                        <button @click="editingInterview = false"
                                            x-show="editingInterview"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300shadow-sm hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel
                                        </button>
                                    <?php else: ?>
                                        <!-- Add Schedule Button - Show only when no interview exists -->
                                        <span class="text-sm text-gray-500">No interview scheduled</span>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($interview) && !empty($interview['interview_date'])): ?>
                                    <!-- Display Existing Interview Schedule -->
                                    <div x-show="!editingInterview">
                                        <div class="p-6 bg-gray-50">
                                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Date & Time</label>
                                                    <div class="flex items-center p-3 bg-white rounded-md shadow-sm">
                                                        <svg class="w-5 h-5 mr-3 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-900">
                                                            <?php echo date('F j, Y \a\t g:i A', strtotime($interview['interview_date'])); ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                                    <div class="flex items-center p-3 bg-white rounded-md shadow-sm">
                                                        <svg class="w-5 h-5 mr-3 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-900">
                                                            <?php echo htmlspecialchars($interview['interview_location']); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if (!empty($interview['notes'])): ?>
                                                <div class="mt-6">
                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Notes</label>
                                                    <div class="p-3 bg-white rounded-md shadow-sm">

                                                        <span class="text-sm text-gray-900">
                                                            <?php echo nl2br(htmlspecialchars($interview['notes'])); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Interview Scheduling Form (Show when no interview OR when editing) -->
                                <div x-show="<?php echo empty($interview) || empty($interview['interview_date']) ? 'true' : 'editingInterview'; ?>">
                                    <form method="POST" action="?page=review-application&action=scheduleInterview&application_id=<?php echo $application['application_id']; ?>" class="space-y-6">
                                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-gray-700">Date & Time</label>
                                                <input type="datetime-local" name="interview_date"
                                                    value="<?php echo htmlspecialchars($interview['interview_date'] ?? ''); ?>"
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                                <input type="text" name="interview_location"
                                                    value="<?php echo htmlspecialchars($interview['interview_location'] ?? ''); ?>"
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm placeholder:text-sm placeholder:text-gray-400"
                                                    placeholder="Office address or online meeting link"
                                                    required>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Notes (Optional)</label>
                                            <textarea name="notes" rows="4"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm placeholder:text-sm placeholder:text-gray-400"
                                                placeholder="Add any additional instructions or requirements for the candidate"><?php echo htmlspecialchars($interview['notes'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="flex gap-3">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <?php echo (!empty($interview) && !empty($interview['interview_date'])) ? 'Update Interview' : 'Schedule Interview'; ?>
                                            </button>

                                            <?php if (!empty($interview) && !empty($interview['interview_date'])): ?>
                                                <button type="button" @click="editingInterview = false"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    Cancel
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>