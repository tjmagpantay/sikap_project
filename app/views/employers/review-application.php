<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen px-4 py-8 sm:px-6 md:px-16 lg:px-24">
    <div class="max-w-5xl mx-auto">
        <!-- Header with back button -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="?page=manage-applications" class="flex items-center text-sm font-medium transition-colors text-primary hover:text-secondary">
                    <i class="mr-2 fas fa-arrow-left"></i> Back to Applications
                </a>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">Review Application</h1>
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

        <!-- Application Details Card -->
        <div class="p-6 mb-8 bg-white border border-gray-100 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-primary">Applicant Information</h2>
                <span class="text-sm text-gray-500">Applied: <?php echo date('M j, Y', strtotime($application['applied_at'])); ?></span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs font-medium text-gray-500">Application ID</p>
                    <p class="font-medium"><?php echo htmlspecialchars($application['application_id']); ?></p>
                </div>
                <div class="p-3 rounded-lg bg-gray-50">
                    <p class="text-xs font-medium text-gray-500">Jobseeker ID</p>
                    <p class="font-medium"><?php echo htmlspecialchars($application['jobseeker_id']); ?></p>
                </div>
            </div>
        </div>

        <!-- Status Update Card -->
        <div class="p-6 mb-8 bg-white border border-gray-100 rounded-lg shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-primary">Update Application Status</h2>

            <form method="POST" action="?page=review-application&action=updateStatus&application_id=<?php echo $application['application_id']; ?>">
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <select name="application_status" class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <?php foreach (['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'] as $status): ?>
                            <option value="<?php echo $status; ?>" <?php if ($application['application_status'] == $status) echo 'selected'; ?>>
                                <?php echo ucfirst($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-primary">
                        <i class="mr-2 fas fa-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Interview Scheduling Card -->
        <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-primary">Schedule Interview</h2>

            <form method="POST" action="?page=review-application&action=scheduleInterview&application_id=<?php echo $application['application_id']; ?>">
                <div class="space-y-4">
                    <!-- Date & Time -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Date & Time</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-calendar-alt"></i>
                            </div>
                            <input type="datetime-local" name="interview_date"
                                value="<?php echo htmlspecialchars($interview['interview_date'] ?? ''); ?>"
                                class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Location</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-map-marker-alt"></i>
                            </div>
                            <input type="text" name="interview_location"
                                value="<?php echo htmlspecialchars($interview['interview_location'] ?? ''); ?>"
                                class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                                placeholder="Office or Zoom meeting link">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Notes</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pt-3 pl-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-edit"></i>
                            </div>
                            <textarea name="notes" rows="4"
                                class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                                placeholder="Add any additional instructions for the candidate"><?php echo htmlspecialchars($interview['notes'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full btn-primary sm:w-auto">
                            <i class="mr-2 fas fa-calendar-check"></i> Schedule Interview
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>