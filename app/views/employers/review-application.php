<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-6 py-8 mx-auto max-w-7xl">
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
            <div class="w-full space-y-4 md:w-4/12">
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">

                    <!-- Profile Header with Gray Background -->
                    <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <!-- Circle Profile Photo -->
                                <div class="mr-4">
                                    <?php if (!empty($application['profile_picture'])): ?>
                                        <img src="<?php echo '/sikap/public/' . htmlspecialchars($application['profile_picture']); ?>"
                                            alt="Profile"
                                            class="object-cover w-16 h-16 rounded-md shadow-sm">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-md">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Name and Position -->
                                <div class="flex-1">
                                    <h1 class="text-lg font-semibold text-gray-900 sm:text-xl">
                                        <?php echo htmlspecialchars(trim(($application['first_name'] ?? '') . ' ' . ($application['last_name'] ?? ''))); ?>
                                    </h1>
                                    <!-- Position Applied For -->
                                    <p class="text-xs text-gray-700">
                                        Applied: <?php echo htmlspecialchars(date('M j, Y', strtotime($application['applied_at']))); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Status Badge - Top Right -->
                            <div class="flex-shrink-0 ml-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium 
                                    <?php
                                    switch ($application['application_status']) {
                                        case 'pending':
                                            echo 'bg-blue-100 text-primary border border-blue-200 rounded-md';
                                            break;
                                        case 'reviewed':
                                            echo 'bg-blue-100 text-primary border border-blue-200 rounded-md';
                                            break;
                                        case 'shortlisted':
                                            echo 'bg-blue-100 text-primary border border-blue-200 rounded-md';
                                            break;
                                        case 'rejected':
                                            echo 'bg-red-100 text-red-800 border border-red-200 rounded-md';
                                            break;
                                        case 'hired':
                                            echo 'bg-blue-100 text-primary border border-blue-200 rounded-md';
                                            break;
                                        case 'resigned':
                                            echo 'bg-blue-100 text-primary border border-blue-200 rounded-md';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800 border border-gray-200 rounded-md';
                                    }
                                    ?>">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <?php
                                        switch ($application['application_status']) {
                                            case 'pending':
                                                echo '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />';
                                                break;
                                            case 'reviewed':
                                                echo '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />';
                                                break;
                                            case 'shortlisted':
                                                echo '<path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />';
                                                break;
                                            case 'rejected':
                                                echo '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />';
                                                break;
                                            case 'hired':
                                                echo '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />';
                                                break;
                                            case 'resigned':
                                                echo '<path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 6.707 6.293a1 1 0 00-1.414 1.414L8.586 11l-3.293 3.293a1 1 0 001.414 1.414L10 12.414l3.293 3.293a1 1 0 001.414-1.414L11.414 11l3.293-3.293z" clip-rule="evenodd" />';
                                                break;
                                            default:
                                                echo '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />';
                                        }
                                        ?>
                                    </svg>
                                    <?php echo ucfirst($application['application_status']); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Profile Completion Progress Bar -->
                        <div class="p-3 border border-gray-300 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-gray-500">Profile Completion</span>
                                <span class="text-xs font-bold text-primary">
                                    <?php
                                    $completion = $application['profile_completion_percentage'] ?? 0;
                                    echo $completion;
                                    ?>%
                                </span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div class="h-2 transition-all duration-300 rounded-full bg-primary"
                                    style="width: <?php echo $completion; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content - Quick Actions -->
                    <div class="p-4 sm:p-6">
                        <h4 class="mb-3 text-sm font-semibold text-gray-900">Quick Actions</h4>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2">
                            <!-- Accept Application Button -->
                            <?php if ($application['application_status'] !== 'hired' && $application['application_status'] !== 'resigned'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="hired">
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Accept Application
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Reject Application Button -->
                            <?php if ($application['application_status'] !== 'rejected' && $application['application_status'] !== 'resigned'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-red-700 transition-colors duration-200 bg-red-100 border border-red-300 rounded-md shadow-sm hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject Application
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Mark as Reviewed Button -->
                            <?php if ($application['application_status'] === 'pending'): ?>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
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
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.978 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.978-2.89a1 1 0 00-1.176 0l-3.978 2.89c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.978-2.89c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.518-4.674z" />
                                        </svg>
                                        Shortlist
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Set Resigned Button -->
                            <?php if ($application['application_status'] === 'hired'): ?>
                                <form method="POST" action="?page=review-application&action=setResigned&application_id=<?php echo $application['application_id']; ?>" class="inline">
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to set this employee as resigned? This action cannot be undone.')"
                                        class="items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm nline-flex bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Set Resigned
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Schedule Interview Button -->
                            <?php if (
                                $application['application_status'] !== 'resigned' &&
                                (!$resignationRequest || $resignationRequest['request_status'] === 'pending')
                            ): ?>
                                <button @click="activeTab = 'schedule'" class="items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm nline-flex bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 01-2 2z" />
                                    </svg>
                                    Schedule Interview
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Resignation Request Card -->
                <div class="p-4 bg-white border border-gray-200 rounded-lg sm:p-6">
                    <?php if ($resignationRequest && $resignationRequest['request_status'] === 'pending'): ?>
                        <!-- Resignation Request Pending Actions -->
                        <div class="flex items-start mb-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mr-3 bg-orange-100 rounded-full">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-semibold text-orange-800">Pending Resignation Request</h5>
                                <p class="mt-1 text-sm text-orange-600">This employee has requested to resign from their position and awaits your decision.</p>
                            </div>
                        </div>

                        <?php if (!empty($resignationRequest['resignation_reason'])): ?>
                            <div class="p-4 mb-4 bg-orange-100 border border-orange-200 rounded-md">
                                <p class="mb-2 text-sm font-medium text-orange-800">Resignation Reason:</p>
                                <p class="text-sm leading-relaxed text-orange-700"><?php echo nl2br(htmlspecialchars($resignationRequest['resignation_reason'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <!-- Approve Resignation Form -->
                            <form method="POST" action="?page=review-application&action=approveResignation&application_id=<?php echo $application['application_id']; ?>" class="space-y-3">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-orange-800">Optional Notes</label>
                                    <textarea name="employer_notes"
                                        placeholder="Add any final comments or acknowledgments..."
                                        rows="3"
                                        class="w-full px-3 py-2 text-sm border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 placeholder:text-orange-400"></textarea>
                                </div>
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to approve this resignation request? This action cannot be undone.')"
                                    class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Approve Resignation
                                </button>
                            </form>

                            <!-- Reject Resignation Form -->
                            <form method="POST" action="?page=review-application&action=rejectResignation&application_id=<?php echo $application['application_id']; ?>" class="space-y-3">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-orange-800">Reason for Rejection <span class="text-red-500">*</span></label>
                                    <textarea name="employer_notes"
                                        placeholder="Please explain why you're rejecting this resignation request..."
                                        rows="3"
                                        required
                                        class="w-full px-3 py-2 text-sm border border-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 placeholder:text-red-400"></textarea>
                                </div>
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to reject this resignation request?')"
                                    class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-red-700 transition-colors duration-200 bg-red-100 border border-red-300 rounded-md shadow-sm hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reject Request
                                </button>
                            </form>
                        </div>

                    <?php elseif ($resignationRequest && $resignationRequest['request_status'] === 'approved'): ?>
                        <!-- Resignation Request Approved Message -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mr-3 bg-blue-100 rounded-full">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-sm font-semibold text-grayMain">Resignation Request Approved</h5>
                                    <p class="py-2 text-sm text-gray-600">
                                        You have successfully approved this employee's resignation request on
                                        <?php echo date('F j, Y \a\t g:i A', strtotime($resignationRequest['reviewed_at'])); ?>.
                                    </p>

                                    <?php if (!empty($resignationRequest['employer_notes'])): ?>
                                        <div class="p-3 mt-3 border border-gray-200 rounded-md">
                                            <p class="mb-1 text-sm font-medium text-grayMain">Your Notes:</p>
                                            <p class="text-sm text-gray-600"><?php echo nl2br(htmlspecialchars($resignationRequest['employer_notes'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-primary">
                                            Employee Status: Resigned
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($resignationRequest && $resignationRequest['request_status'] === 'rejected'): ?>
                        <!-- Resignation Request Rejected Message -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mr-3 bg-red-100 rounded-full">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-sm font-semibold text-grayMain">Resignation Request Rejected</h5>
                                    <p class="py-2 text-sm text-gray-600">
                                        You have rejected this employee's resignation request on
                                        <?php echo date('F j, Y \a\t g:i A', strtotime($resignationRequest['reviewed_at'])); ?>.
                                    </p>

                                    <?php if (!empty($resignationRequest['employer_notes'])): ?>
                                        <div class="p-3 mt-3 bg-red-100 border border-red-200 rounded-md">
                                            <p class="mb-1 text-sm font-medium text-grayMain">Reason for Rejection:</p>
                                            <p class="text-sm text-gray-600"><?php echo nl2br(htmlspecialchars($resignationRequest['employer_notes'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-primary">
                                            Employee Status: <?php echo ucfirst($application['application_status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- No resignation request -->
                        <div class="py-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Resignation Request</h3>
                            <p class="mt-1 text-sm text-gray-500">This employee hasn't submitted any resignation request.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Section - Detailed View with Tabs -->
            <div class="w-full md:w-8/12">
                <div class="overflow-hidden bg-white border border-gray-200 rounded-md shadow">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex gap-8 px-4 sm:px-6 " aria-label="Tabs">
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
                    <div class="p-4 min-h-[600px] border-t border-gray-200 overflow-visible sm:p-6">
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
                                            <h4 class="pb-2 mb-2 font-semibold border-b border-gray-200 text-primary text-md">Top Skills</h4>
                                            <div class="flex flex-wrap gap-2 mt-3">
                                                <?php foreach (array_slice($application['skills'], 0, 6) as $skill): ?>
                                                    <span class="px-2 py-1 text-xs font-medium rounded text-primary bg-gray-50 hover:bg-blue-100">
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
                                                    <div class="flex items-center gap-3">
                                                        <svg class="w-6 h-6 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <div>
                                                            <h5 class="text-sm font-medium text-primary"><?php echo htmlspecialchars($certificate['certificate_title']); ?></h5>
                                                            <p class="text-xs text-gray-400"><?php echo htmlspecialchars($certificate['issuing_organization']); ?></p>
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
                                <!-- Cover Letter -->
                                <div class="py-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Cover Letter</h4>
                                    <div class="p-6 rounded-lg bg-gray-50">
                                        <p class="text-sm leading-relaxed text-gray-900">
                                            <?= htmlspecialchars($application['cover_letter'] ?? 'No cover letter provided.') ?>
                                        </p>
                                    </div>
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
                                                        echo 'bg-gray-100 text-primary';
                                                        break;
                                                    case 'reviewed':
                                                        echo 'bg-gray-100 text-primary';
                                                        break;
                                                    case 'shortlisted':
                                                        echo 'bg-gray-100 text-primary';
                                                        break;
                                                    case 'rejected':
                                                        echo 'bg-red-100 text-red-800';
                                                        break;
                                                    case 'hired':
                                                        echo 'bg-gray-100 text-primary';
                                                        break;
                                                    default:
                                                        echo 'bg-gray-200 text-gray-800';
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
                            <div class="space-y-4 overflow-visible">
                                <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Update Application Status</h4>
                                <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>" class="space-y-4 overflow-visible">
                                    <div class="overflow-visible">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                        <div class="relative overflow-visible" x-data="{ 
                                            open: false, 
                                            selected: '<?php
                                                        $statusLabels = [
                                                            'pending' => 'Pending',
                                                            'reviewed' => 'Reviewed',
                                                            'shortlisted' => 'Shortlisted',
                                                            'rejected' => 'Rejected',
                                                            'hired' => 'Hired',
                                                            'resigned' => 'Resigned'
                                                        ];
                                                        echo $statusLabels[$application['application_status']] ?? 'Pending';
                                                        ?>', 
                                            selectedValue: '<?php echo $application['application_status']; ?>' 
                                        }">
                                            <button type="button" @click="open = !open"
                                                @click.away="open = false"
                                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                                <span x-text="selected" :class="{'text-gray-500': selected === 'Select Status', 'text-gray-900': selected !== 'Select Status'}"></span>
                                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>

                                            <div x-show="open"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="absolute left-0 z-[9999] w-full mt-2 bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-200 max-h-64 overflow-y-auto"
                                                style="z-index: 9999;"
                                                x-cloak>
                                                <div class="py-1">
                                                    <button type="button" @click="selected = 'Pending'; selectedValue = 'pending'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                            </svg>
                                                            Pending
                                                        </div>
                                                    </button>
                                                    <button type="button" @click="selected = 'Reviewed'; selectedValue = 'reviewed'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            Reviewed
                                                        </div>
                                                    </button>
                                                    <button type="button" @click="selected = 'Shortlisted'; selectedValue = 'shortlisted'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                            </svg>
                                                            Shortlisted
                                                        </div>
                                                    </button>
                                                    <button type="button" @click="selected = 'Rejected'; selectedValue = 'rejected'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                            </svg>
                                                            Rejected
                                                        </div>
                                                    </button>
                                                    <button type="button" @click="selected = 'Hired'; selectedValue = 'hired'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            Hired
                                                        </div>
                                                    </button>
                                                    <button type="button" @click="selected = 'Resigned'; selectedValue = 'resigned'; open = false"
                                                        class="block w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100 hover:text-primary">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 6.707 6.293a1 1 0 00-1.414 1.414L8.586 11l-3.293 3.293a1 1 0 001.414 1.414L10 12.414l3.293 3.293a1 1 0 001.414-1.414L11.414 11l3.293-3.293z" clip-rule="evenodd" />
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="status" :value="selectedValue">
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
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
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
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
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 01-2 2z" />
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
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-xs placeholder:text-xs placeholder:text-gray-400"
                                                    placeholder="Office address or online meeting link"
                                                    required>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Notes (Optional)</label>
                                            <textarea name="notes" rows="4"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-xs placeholder:text-xs placeholder:text-gray-400"
                                                placeholder="Add any additional instructions or requirements for the candidate"><?php echo htmlspecialchars($interview['notes'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="flex gap-3">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 01-2 2z" />
                                                </svg>
                                                <?php echo (!empty($interview) && !empty($interview['interview_date'])) ? 'Update Interview' : 'Schedule Interview'; ?>
                                            </button>

                                            <?php if (!empty($interview) && !empty($interview['interview_date'])): ?>
                                                <button type="button" @click="editingInterview = false"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary ">
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