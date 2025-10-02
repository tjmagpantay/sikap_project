<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<!-- Job Posting Guide Section -->
<section id="post-guide" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Employer Resources</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Job Posting Guide
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                How to Effectively Post and Manage Job Listings on Sikap
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Quick Navigation -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-center text-primary">Quick Navigation</h3>
            <nav class="flex flex-wrap justify-center gap-2">
                <a href="#section-1" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">1. Introduction</a>
                <a href="#section-2" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">2. Getting Started</a>
                <a href="#section-3" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">3. Creating Job Posts</a>
                <a href="#section-4" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">4. Best Practices</a>
                <a href="#section-5" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">5. Managing Posts</a>
            </nav>
        </div>

        <!-- Main Content - Full Width -->
        <div class="space-y-6">
            <!-- Introduction -->
            <div id="section-1" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">1</span>
                    Introduction
                </h2>
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <p class="text-sm text-gray-700">
                        Creating effective job postings is essential for attracting qualified candidates. This guide will help you optimize your job listings on Sikap, ensuring you reach the right talent for your organization.
                    </p>
                </div>
            </div>

            <!-- Getting Started -->
            <div id="section-2" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">2</span>
                    Getting Started
                </h2>

                <h3 class="mb-3 text-base font-semibold text-gray-800">Prerequisites</h3>
                <p class="mb-4 text-sm text-gray-600">Before posting a job, make sure you have:</p>
                
                <div class="grid gap-3 md:grid-cols-3">
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">A verified employer account</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">A completed company profile</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">An approved accreditation status</span>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 rounded-lg bg-primary border-primary">
                    <p class="text-sm font-medium text-white">💡 Pro Tip: A complete company profile increases trust and improves your chances of attracting more applicants.</p>
                </div>
            </div>

            <!-- Creating an Effective Job Post -->
            <div id="section-3" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">3</span>
                    Creating an Effective Job Post
                </h2>

                <!-- Job Title -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">1. Job Title</h3>
                    <p class="mb-3 text-sm text-gray-600">Use titles that are clear, standard, and searchable:</p>
                    <div class="space-y-2">
                        <div class="p-3 border border-green-200 rounded bg-green-50">
                            <span class="text-sm text-green-700"> Use common industry titles (e.g., Software Engineer, Sales Associate)</span>
                        </div>
                        <div class="p-3 border border-red-200 rounded bg-red-50">
                            <span class="text-sm text-red-700"> Avoid internal jargon or abbreviations</span>
                        </div>
                        <div class="p-3 border border-blue-200 rounded bg-blue-50">
                            <span class="text-sm text-blue-700">Be specific and indicate seniority if needed (Junior Accountant, Senior Developer)</span>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">2. Job Description</h3>
                    <p class="mb-3 text-sm text-gray-600">Provide a comprehensive yet concise overview:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Role purpose and significance</li>
                        <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Daily tasks and responsibilities</li>
                        <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Team structure and reporting lines</li>
                        <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Work location and schedule (onsite/hybrid/remote)</li>
                        <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Company culture and values</li>
                    </ul>
                </div>

                <!-- Requirements & Qualifications -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">3. Requirements & Qualifications</h3>
                    <p class="mb-3 text-sm text-gray-600">Clearly define what candidates need:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Minimum education and certifications</li>
                        <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Relevant skills and experience</li>
                        <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Technical proficiencies or licenses</li>
                        <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Physical requirements (if applicable)</li>
                    </ul>
                </div>

                <!-- Benefits & Compensation -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">4. Benefits & Compensation</h3>
                    <p class="mb-3 text-sm text-gray-600">Attract candidates with transparent and competitive details:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Salary range or pay structure</li>
                        <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Benefits package (healthcare, allowances, etc.)</li>
                        <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Work arrangements (hybrid, remote, onsite)</li>
                        <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Growth and training opportunities</li>
                        <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Perks and incentives</li>
                    </ul>
                </div>
            </div>

            <!-- Best Practices -->
            <div id="section-4" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">4</span>
                    Best Practices
                </h2>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Content Guidelines -->
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Content Guidelines</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Use inclusive, welcoming language</li>
                            <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Be transparent and realistic about expectations</li>
                            <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Keep descriptions concise but informative</li>
                            <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Highlight career growth opportunities</li>
                            <li class="flex items-start"><span class="mr-2 text-green-600">•</span>Showcase your work culture</li>
                        </ul>
                    </div>

                    <!-- Technical Tips -->
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Technical Tips</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Include clear application instructions</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Set realistic deadlines</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Use keywords for better searchability</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Optimize for mobile viewing</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Provide contact information</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Managing Your Job Posts -->
            <div id="section-5" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">5</span>
                    Managing Your Job Posts
                </h2>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Application Management -->
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Application Management</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Review applications within 48 hours</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Update the status once the role is filled</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Respond to inquiries promptly</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Use Sikap's screening tools for efficiency</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Schedule interviews directly via Sikap</li>
                        </ul>
                    </div>

                    <!-- Performance Tracking -->
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Performance Tracking</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Monitor views and applications</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Track conversion rates (views → applications)</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Assess candidate quality metrics</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Optimize posts using insights and data</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Track time-to-hire to improve efficiency</li>
                        </ul>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 border-yellow-400 rounded-lg bg-yellow-50">
                    <p class="text-sm font-medium text-yellow-800">⚠️ Important: Keep your job posts updated—outdated or incomplete posts reduce candidate trust and platform credibility.</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="p-6 border rounded-lg bg-gradient-to-r from-primary/10 to-secondary/10 border-primary/20">
                <h3 class="mb-3 text-lg font-semibold text-center text-primary">Need Help with Job Posting?</h3>
                <p class="mb-4 text-sm text-center text-gray-700">
                    Contact PESO Rosario for assistance with creating effective job posts and maximizing your hiring success.
                </p>
                
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-800">Email</p>
                        <a href="mailto:pesorosariobats@gmail.com" class="text-sm text-primary hover:underline">pesorosariobats@gmail.com</a>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-800">Phone</p>
                        <p class="text-sm text-gray-600">(319) 555-0115</p>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-800">Office Hours</p>
                        <p class="text-sm text-gray-600">Monday-Friday, 8:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Footer Statement -->
            <div class="p-8 text-center border rounded-lg bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10 border-primary/20">
                <h2 class="mb-4 text-2xl font-bold text-primary">Maximize Your Hiring Success</h2>
                <p class="max-w-4xl mx-auto mb-6 text-sm leading-relaxed text-gray-700">
                    With these guidelines, employers can maximize their hiring success on Sikap. A well-crafted job post not only attracts more applicants but also ensures better job-matching accuracy—making it easier to find the right talent quickly.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Effective Posting</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Better Matching</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Quality Candidates</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Hiring Success</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>