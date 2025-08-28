<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen">
    <div class="mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl py-8">
        <div class="max-w-5xl mx-auto">
            <h2 class="mb-8 text-2xl font-bold text-gray-900">Manage Applicants</h2>
            <div class="bg-white rounded-lg shadow">
                <div class="w-full overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-primary">
                            <tr>
                                <th class="w-2/5 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">Applicant</th>
                                <th class="w-1/6 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">Applied At</th>
                                <th class="w-1/6 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">Status</th>
                                <th class="w-1/4 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($applicants)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                                <i class="text-2xl text-gray-400 fas fa-user-friends"></i>
                                            </div>
                                            <h3 class="mt-4 text-lg font-medium text-gray-900">No applicants yet</h3>
                                            <p class="max-w-sm mt-2 text-sm text-gray-500">
                                                Applicants will appear here once they apply to this job post.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($applicants as $app): ?>
                                    <tr class="hover:bg-gray-50">
                                        <!-- Applicant Info -->
                                        <td class="px-6 py-4 align-top">
                                            <div class="flex items-center">
                                                <?php if (!empty($app['profile_picture'])): ?>
                                                    <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>" alt="Profile" class="object-cover w-12 h-12 mr-3 border border-gray-200 rounded-full">
                                                <?php else: ?>
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 bg-gray-200 rounded-full">
                                                        <i class="text-gray-400 fas fa-user"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                                    </div>
                                                    <?php if (!empty($app['email'])): ?>
                                                        <div class="text-xs text-gray-500"><?php echo htmlspecialchars($app['email']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Applied At -->
                                        <td class="px-6 py-4 align-top">
                                            <span class="text-sm text-gray-700">
                                                <?php echo date('M j, Y', strtotime($app['applied_at'])); ?>
                                            </span>
                                        </td>
                                        <!-- Status -->
                                        <td class="px-6 py-4 align-top">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                            <?php
                                            switch ($app['application_status']) {
                                                case 'pending':
                                                    echo 'text-yellow-800 bg-yellow-100';
                                                    break;
                                                case 'accepted':
                                                    echo 'text-green-800 bg-green-100';
                                                    break;
                                                case 'rejected':
                                                    echo 'text-red-800 bg-red-100';
                                                    break;
                                                default:
                                                    echo 'text-gray-800 bg-gray-100';
                                            }
                                            ?>">
                                                <?php echo ucfirst($app['application_status']); ?>
                                            </span>
                                        </td>
                                        <!-- Actions -->
                                        <td class="px-6 py-4 align-top">
                                            <div class="flex items-center space-x-2">
                                                <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-900 border border-transparent rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <i class="mr-2 fas fa-eye"></i> Review
                                                </a>
                                                <!-- Add more actions here if needed -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>