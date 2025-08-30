// This helper ensures jobseeker data is available for components like navbar
// Only include this at the top of views that need jobseeker data

if (!isset($jobseeker)) {
    // Fallback: If controller didn't provide jobseeker data, provide default
    $jobseeker = [
        'first_name' => '',
        'last_name' => '',
        'profile_picture' => ''
    ];
    
    // Log that controller should be providing this data
    error_log('Warning: Jobseeker data not provided by controller in ' . $_SERVER['REQUEST_URI']);
}