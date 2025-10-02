<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<!-- How to Apply Section -->
<section id="how-to-apply" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">User Guide</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                How to Apply
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                Your step-by-step guide to applying for jobs through Sikap
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Quick Navigation -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-center text-primary">Quick Navigation</h3>
            <nav class="flex flex-wrap justify-center gap-2">
                <a href="#section-1" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">1. Create Profile</a>
                <a href="#section-2" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">2. Search Jobs</a>
                <a href="#section-3" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">3. Prepare Application</a>
                <a href="#section-4" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">4. Submit Application</a>
                <a href="#section-5" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">5. Track Application</a>
                <a href="#section-6" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">6. Success Tips</a>
            </nav>
        </div>

        <!-- Main Content - Full Width -->
        <div class="space-y-6">
            <!-- Step 1: Create Your Profile -->
            <div id="section-1" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">1</span>
                    Create Your Profile
                </h2>
                <p class="mb-4 text-sm text-gray-600">Begin by setting up a complete and professional profile that includes:</p>

                <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">Personal information and contact details</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">Educational background</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">Work experience</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">Skills and certifications</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-primary">•</span>
                        <span class="text-sm text-gray-700">A short professional summary</span>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 rounded-lg bg-primary border-primary">
                    <p class="text-sm font-medium text-white">💡 Tip: Keep your profile updated to improve the accuracy of Sikap's machine learning job recommendations.</p>
                </div>
            </div>

            <!-- Step 2: Search for Jobs -->
            <div id="section-2" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">2</span>
                    Search for Jobs
                </h2>
                <p class="mb-4 text-sm text-gray-600">Explore opportunities through:</p>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="p-4 border border-gray-200 rounded-lg ">
                        <h3 class="mb-2 text-base font-semibold text-gray-800">Search bar</h3>
                        <p class="text-sm text-gray-600">Enter keywords related to your skills or desired job</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg ">
                        <h3 class="mb-2 text-base font-semibold text-gray-800">Filters</h3>
                        <p class="text-sm text-gray-600">Narrow results by location, industry, or job type</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg 0">
                        <h3 class="mb-2 text-base font-semibold text-gray-800">Recommended jobs</h3>
                        <p class="text-sm text-gray-600">Personalized matches based on your profile</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg ">
                        <h3 class="mb-2 text-base font-semibold text-gray-800">Featured employers</h3>
                        <p class="text-sm text-gray-600">Verified employers accredited by PESO Rosario</p>
                    </div>
                </div>
            </div>

            <!-- Step 3: Prepare Your Application -->
            <div id="section-3" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">3</span>
                    Prepare Your Application
                </h2>
                <p class="mb-4 text-sm text-gray-600">Before applying, make sure you have:</p>

                <div class="grid gap-3 md:grid-cols-2">
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-secondary">•</span>
                        <span class="text-sm text-gray-700">An updated resume (PDF format preferred)</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-secondary">•</span>
                        <span class="text-sm text-gray-700">Relevant certificates and credentials</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-secondary">•</span>
                        <span class="text-sm text-gray-700">A professional photo (if required)</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-secondary">•</span>
                        <span class="text-sm text-gray-700">A tailored cover letter (highly recommended)</span>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 border-yellow-400 rounded-lg bg-yellow-50">
                    <p class="text-sm font-medium text-yellow-800">⚠️ Note: Each job post may have different requirements—review carefully before applying.</p>
                </div>
            </div>

            <!-- Step 4: Submit Your Application -->
            <div id="section-4" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">4</span>
                    Submit Your Application
                </h2>
                <p class="mb-4 text-sm text-gray-600">To apply for a job:</p>

                <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">1.</span>
                        <span class="text-sm text-gray-700">Click "Apply Now" on the posting</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">2.</span>
                        <span class="text-sm text-gray-700">Review your profile details</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">3.</span>
                        <span class="text-sm text-gray-700">Upload required documents</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">4.</span>
                        <span class="text-sm text-gray-700">Add any extra information requested</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">5.</span>
                        <span class="text-sm text-gray-700">Double-check everything</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 font-bold text-primary">6.</span>
                        <span class="text-sm text-gray-700">Click Submit</span>
                    </div>
                </div>
            </div>

            <!-- Step 5: Track Your Application -->
            <div id="section-5" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">5</span>
                    Track Your Application
                </h2>
                <p class="mb-4 text-sm text-gray-600">After submission, you can:</p>

                <div class="grid gap-3 md:grid-cols-2">
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-blue-600">•</span>
                        <span class="text-sm text-gray-700">View your application status in your profile</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-blue-600">•</span>
                        <span class="text-sm text-gray-700">Receive email updates about your application</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-blue-600">•</span>
                        <span class="text-sm text-gray-700">Respond promptly to employer inquiries</span>
                    </div>
                    <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-blue-600">•</span>
                        <span class="text-sm text-gray-700">Prepare for interviews once shortlisted</span>
                    </div>
                </div>
            </div>

            <!-- Quick Tips for Success -->
            <div id="section-6" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">6</span>
                    Quick Tips for Success
                </h2>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Do's Section -->
                    <div class="p-4 border border-gray-200 rounded-lg ">
                        <h3 class="mb-4 text-lg font-semibold text-center text-gray-800"> Do's</h3>
                        <div class="space-y-3">
                            <div class="p-3 border border-green-200 rounded-lg bg-green-50">
                                <span class="text-sm text-gray-700">Apply early to increase visibility</span>
                            </div>
                            <div class="p-3 border border-green-200 rounded-lg bg-green-50">
                                <span class="text-sm text-gray-700">Read and follow the job description carefully</span>
                            </div>
                            <div class="p-3 border border-green-200 rounded-lg bg-green-50">
                                <span class="text-sm text-gray-700">Proofread your resume and documents before submission</span>
                            </div>
                            <div class="p-3 border border-green-200 rounded-lg bg-green-50">
                                <span class="text-sm text-gray-700">Use a professional email address</span>
                            </div>
                        </div>
                    </div>

                    <!-- Don'ts Section -->
                    <div class="p-4 border border-gray-200 rounded-lg ">
                        <h3 class="mb-4 text-lg font-semibold text-center text-gray-800"> Don'ts</h3>
                        <div class="space-y-3">
                            <div class="p-3 border border-red-200 rounded-lg bg-red-50">
                                <span class="text-sm text-gray-700">Submit incomplete applications</span>
                            </div>
                            <div class="p-3 border border-red-200 rounded-lg bg-red-50">
                                <span class="text-sm text-gray-700">Apply for jobs far outside your qualifications</span>
                            </div>
                            <div class="p-3 border border-red-200 rounded-lg bg-red-50">
                                <span class="text-sm text-gray-700">Ignore employer instructions or requirements</span>
                            </div>
                            <div class="p-3 border border-red-200 rounded-lg bg-red-50">
                                <span class="text-sm text-gray-700">Leave errors and typos in your application</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Statement -->
            <div class="p-8 text-center border rounded-lg bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10 border-primary/20">
                <h2 class="mb-4 text-2xl font-bold text-primary">Start Your Career Journey with Sikap</h2>
                <p class="max-w-4xl mx-auto mb-6 text-sm leading-relaxed text-gray-700">
                    Sikap's intelligent job matching system connects you with opportunities that match your skills and career goals. Follow these steps to maximize your chances of finding the perfect job.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Smart Matching</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Easy Application</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Real-time Tracking</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Professional Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>