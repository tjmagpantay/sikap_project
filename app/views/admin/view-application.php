<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - View Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#092C4C',
                        secondary: '#F3AF0E'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Ensure proper height and overflow for layout */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: calc(100vh - 4rem);
            /* Subtract topbar height */
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content Area (Scrollable) -->
        <div class="flex-1 lg:ml-80 main-content">
            <div class="p-6">
                <!-- Header Section -->
                <div class="mb-6">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <nav class="flex mb-2" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="?page=admin-applications" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                            </svg>
                                            Applications
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Application Details</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                            <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                            <p class="mt-1 text-sm text-gray-600">View detailed information about this job application</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="?page=admin-applications"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Applications
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Left Column - Application Info -->
                    <div class="lg:col-span-2">
                        <!-- Application Overview -->
                        <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Application Overview</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Application ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">#<?php echo htmlspecialchars($application['application_id']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">
                                            <?php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'reviewed' => 'bg-blue-100 text-blue-800',
                                                'shortlisted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'hired' => 'bg-emerald-100 text-emerald-800'
                                            ];
                                            $statusClass = $statusClasses[$application['application_status']] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                                <?php echo ucfirst($application['application_status']); ?>
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Applied Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <?php echo date('F j, Y \a\t g:i A', strtotime($application['applied_at'])); ?>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <?php echo $application['updated_at'] ? date('F j, Y \a\t g:i A', strtotime($application['updated_at'])) : 'Never'; ?>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Job Information -->
                        <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Job Information</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                                        <dd class="mt-1 text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($application['job_title']); ?></dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Company</dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['company_name']); ?></dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['employment_type']); ?></dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['job_location']); ?></dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['salary_range'] ?? 'Not specified'); ?></dd>
                                        </div>
                                    </div>
                                    <?php if (!empty($application['job_description'])): ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Job Description</dt>
                                            <dd class="mt-1 text-sm prose-sm prose text-gray-700 max-w-none">
                                                <?php echo nl2br(htmlspecialchars($application['job_description'])); ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($application['requirements'])): ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                                            <dd class="mt-1 text-sm prose-sm prose text-gray-700 max-w-none">
                                                <?php echo nl2br(htmlspecialchars($application['requirements'])); ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Applicant Information -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Applicant Information</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 w-16 h-16">
                                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary">
                                                <span class="text-xl font-medium text-white">
                                                    <?php echo strtoupper(substr($application['first_name'], 0, 1) . substr($application['last_name'], 0, 1)); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-900">
                                                <?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars($application['age']); ?> years old, <?php echo htmlspecialchars($application['gender']); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <a href="mailto:<?php echo htmlspecialchars($application['email']); ?>" class="text-primary hover:text-primary-dark">
                                                    <?php echo htmlspecialchars($application['email']); ?>
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <?php if (!empty($application['phone'])): ?>
                                                    <a href="tel:<?php echo htmlspecialchars($application['phone']); ?>" class="text-primary hover:text-primary-dark">
                                                        <?php echo htmlspecialchars($application['phone']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    Not provided
                                                <?php endif; ?>
                                            </dd>
                                        </div>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['address']); ?></dd>
                                    </div>

                                    <?php if (!empty($application['education'])): ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Education</dt>
                                            <dd class="mt-1 text-sm prose-sm prose text-gray-700 max-w-none">
                                                <?php echo nl2br(htmlspecialchars($application['education'])); ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($application['experience'])): ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                            <dd class="mt-1 text-sm prose-sm prose text-gray-700 max-w-none">
                                                <?php echo nl2br(htmlspecialchars($application['experience'])); ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($application['skills'])): ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                            <dd class="mt-1 text-sm prose-sm prose text-gray-700 max-w-none">
                                                <?php echo nl2br(htmlspecialchars($application['skills'])); ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Employer Info & Actions -->
                    <div class="lg:col-span-1">
                        <!-- Employer Information -->
                        <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Employer Information</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Company</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($application['employer_company']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <?php echo htmlspecialchars($application['employer_first_name'] . ' ' . $application['employer_last_name']); ?>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <a href="mailto:<?php echo htmlspecialchars($application['employer_email']); ?>" class="text-primary hover:text-primary-dark">
                                                <?php echo htmlspecialchars($application['employer_email']); ?>
                                            </a>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Timeline -->
                        <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Application Timeline</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="flow-root">
                                    <ul class="-mb-8">
                                        <li>
                                            <div class="relative pb-8">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full ring-8 ring-white">
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div>
                                                            <p class="text-sm text-gray-500">
                                                                Application submitted
                                                            </p>
                                                            <p class="mt-0.5 text-xs text-gray-400">
                                                                <?php echo date('M j, Y \a\t g:i A', strtotime($application['applied_at'])); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <?php if ($application['updated_at'] && $application['updated_at'] !== $application['applied_at']): ?>
                                            <li>
                                                <div class="relative">
                                                    <div class="relative flex space-x-3">
                                                        <div>
                                                            <span class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-full ring-8 ring-white">
                                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div>
                                                                <p class="text-sm text-gray-500">
                                                                    Status updated to <?php echo ucfirst($application['application_status']); ?>
                                                                </p>
                                                                <p class="mt-0.5 text-xs text-gray-400">
                                                                    <?php echo date('M j, Y \a\t g:i A', strtotime($application['updated_at'])); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Note -->
                        <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Admin View Only
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>This is a read-only view for administrative purposes. Application status and decisions are managed by the employer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

<script>
    // Mobile menu toggle
    function toggleSidebar() {
        const sidebarMobile = document.getElementById('sidebar-mobile');
        const overlay = document.getElementById('mobile-menu-overlay');

        if (sidebarMobile) {
            sidebarMobile.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    // Close sidebar when clicking overlay
    document.getElementById('mobile-menu-overlay').addEventListener('click', toggleSidebar);
</script>