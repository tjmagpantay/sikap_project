<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\profile-jobseeker.php
require_once __DIR__ . '/../../models/Jobseeker.php';

// Get jobseeker data with error handling
$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

// Add error handling for all data retrieval
$education = $jobseekerModel->getEducation($_SESSION['user_id']);
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
$skills = $jobseekerModel->getSkills($_SESSION['user_id']);
$certificates = $jobseekerModel->getCertificates($_SESSION['user_id']);

// Convert false results to empty arrays to prevent errors
if ($education === false) $education = [];
if ($workExperience === false) $workExperience = [];
if ($skills === false) $skills = [];
if ($certificates === false) $certificates = [];

// Ensure jobseeker data is available
if ($jobseeker === false) {
  $jobseeker = [
    'first_name' => '',
    'last_name' => '',
    'middle_name' => '',
    'suffix' => '',
    'date_of_birth' => null,
    'sex' => '',
    'address' => '',
    'contact_no' => ''
  ];
}

// Calculate profile completion percentage
$completionPercentage = $jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
if ($completionPercentage === false) $completionPercentage = 0;
?>

<?php include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen">
  <?php include_once __DIR__ . '/../components/navbar-top.php'; ?>
  <?php include_once __DIR__ . '/navbar-jobseeker.php'; ?>

  <div class="py-8 mx-auto max-w-7xl sm:px-6 lg:px-12">
    <div class="flex flex-col gap-8 md:flex-row">
      <!-- Sidebar -->
      <div class="w-full md:w-1/3">
        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex flex-col items-center">
            <!-- Profile Photo -->
            <div class="relative group">
              <img src="<?php echo htmlspecialchars($jobseeker['profile_photo'] ?? '/app/assets/images/default-avatar.svg'); ?>"
                alt="Profile" class="object-cover w-20 h-20 border-2 border-gray-200 rounded-full shadow-sm">
              <form method="POST" enctype="multipart/form-data" id="profile-photo-form">
                <button type="button"
                  class="absolute flex items-center justify-center text-white transition-all duration-200 border-2 border-white rounded-full shadow-lg w-7 h-7 bg-primary -top-2 -right-2 hover:bg-primary-dark hover:shadow-xl group-hover:scale-110"
                  onclick="document.getElementById('profile-photo-input').click()" title="Change profile photo">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                  </svg>
                </button>
                <input type="file" name="profile_photo" id="profile-photo-input" accept="image/*" class="hidden"
                  onchange="document.getElementById('profile-photo-form').submit();">
              </form>
            </div>
            <!-- Name & Info -->
            <div class="mt-4 text-center">
              <h2 class="text-lg font-bold text-gray-800">
                <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? '') . ' ' . ($jobseeker['suffix'] ?? ''))); ?>
              </h2>
              <p class="text-xs text-gray-600"><?php echo htmlspecialchars($jobseeker['sex'] ?? ''); ?></p>
              <p class="mt-1 text-xs text-gray-500"><?php echo htmlspecialchars($jobseeker['address'] ?? ''); ?></p>
            </div>
            <!-- Profile Completion -->
            <div class="w-full mt-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Profile Completion</span>
                <span class="text-sm font-medium text-blue-600"><?php echo round($completionPercentage); ?>%</span>
              </div>
              <div class="w-full h-2 bg-gray-200 rounded-full">
                <div class="h-2 transition-all duration-300 bg-blue-600 rounded-full" style="width: <?php echo $completionPercentage; ?>%"></div>
              </div>
              <div class="flex items-center justify-between mt-1">
                <p class="text-xs text-gray-500">
                  <?php echo $completionPercentage; ?>% completed
                </p>
                <?php if ($completionPercentage < 100): ?>
                  <a href="?page=complete-jobseeker-profile" class="text-xs text-blue-600 hover:text-blue-700">Complete</a>
                <?php else: ?>
                  <span class="text-xs text-green-600">✓ Complete</span>
                <?php endif; ?>
              </div>
            </div>
            <!-- Contact Info -->
            <?php if (!empty($jobseeker['contact_no'])): ?>
              <div class="w-full p-3 mt-4 rounded-lg bg-gray-50">
                <div class="flex items-center">
                  <i class="mr-2 text-gray-500 fas fa-phone"></i>
                  <span class="text-sm text-gray-700"><?php echo htmlspecialchars($jobseeker['contact_no']); ?></span>
                </div>
              </div>
            <?php endif; ?>
            <!-- Quick Actions -->
            <div class="w-full mt-4 space-y-4">
              <a href="?page=complete-jobseeker-profile" class="flex items-center justify-center w-full px-4 py-2 text-white transition-colors rounded-lg bg-primary hover:bg-blue-700">
                <i class="mr-2 fas fa-cog"></i>
                Edit Profile
              </a>
              <a href="?page=jobseeker-documents" class="flex items-center justify-center w-full px-4 py-2 text-blue-700 transition-colors bg-blue-100 rounded-lg hover:bg-blue-200">
                <i class="mr-2 fas fa-file-alt"></i>
                Resume & Documents
              </a>
              <a href="?page=jobseeker-applications" class="flex items-center justify-center w-full px-4 py-2 text-green-700 transition-colors bg-green-100 rounded-lg hover:bg-green-200">
                <i class="mr-2 fas fa-briefcase"></i>
                Job Applications
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="w-full space-y-8 md:w-2/3 ">
        <!-- Navigation Tabs -->
        <div class="flex mb-6 space-x-4 border-b">
          <a href="?page=profile-jobseeker"
            class="pb-2 font-semibold text-green-600 transition-colors border-b-2 border-green-500">
            Applicant Profile
          </a>
          <a href="?page=jobseeker-documents"
            class="pb-2 text-gray-500 transition-colors hover:text-green-600">
            Resume & Documents
          </a>
          <a href="?page=jobseeker-applications"
            class="pb-2 text-gray-500 transition-colors hover:text-green-600">
            Job Applications
          </a>
        </div>

        <!-- Personal Information Card -->
        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold">Personal Information</h4>
            <a href="?page=complete-jobseeker-profile&step=2"
              class="flex items-center text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-edit"></i>
              Edit
            </a>
          </div>
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <p class="text-gray-500">Full Name</p>
              <p class="font-medium">
                <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? '') . ' ' . ($jobseeker['suffix'] ?? ''))); ?>
              </p>
            </div>
            <div>
              <p class="text-gray-500">Gender</p>
              <p class="font-medium"><?php echo htmlspecialchars($jobseeker['sex'] ?? 'N/A'); ?></p>
            </div>
            <div>
              <p class="text-gray-500">Date of Birth</p>
              <p class="font-medium">
                <?php echo !empty($jobseeker['date_of_birth']) && $jobseeker['date_of_birth'] ? date('F j, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A'; ?>
              </p>
            </div>
            <div>
              <p class="text-gray-500">Phone Number</p>
              <p class="font-medium"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
            </div>
            <div class="md:col-span-2">
              <p class="text-gray-500">Address</p>
              <p class="font-medium"><?php echo htmlspecialchars($jobseeker['address'] ?? 'N/A'); ?></p>
            </div>
            <div class="md:col-span-2">
              <p class="text-gray-500">Email</p>
              <p class="font-medium"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
            </div>
          </div>
        </div>

        <!-- Employment Status Card -->
        <div class="p-6 mt-2 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold">Employment Status</h4>
            <a href="?page=complete-jobseeker-profile&step=3"
              class="flex items-center text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-edit"></i>
              Edit
            </a>
          </div>
          <?php if (!empty($workExperience) && is_array($workExperience) && isset($workExperience[0]['currently_working']) && $workExperience[0]['currently_working'] === 'Yes'): ?>
            <p class="mb-4 text-sm text-gray-600">
              Currently working as <?php echo htmlspecialchars($workExperience[0]['job_title'] ?? 'N/A'); ?>
              at <?php echo htmlspecialchars($workExperience[0]['company_name'] ?? 'N/A'); ?>.
            </p>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <div>
                <p class="text-gray-500">Current Job</p>
                <p class="font-medium"><?php echo htmlspecialchars($workExperience[0]['job_title'] ?? 'N/A'); ?></p>
              </div>
              <div>
                <p class="text-gray-500">Company</p>
                <p class="font-medium"><?php echo htmlspecialchars($workExperience[0]['company_name'] ?? 'N/A'); ?></p>
              </div>
              <div>
                <p class="text-gray-500">Employment Type</p>
                <p class="font-medium"><?php echo htmlspecialchars(ucfirst($workExperience[0]['employment_type'] ?? 'N/A')); ?></p>
              </div>
              <div>
                <p class="text-gray-500">Start Date</p>
                <p class="font-medium">
                  <?php echo !empty($workExperience[0]['start_date']) ? date('M Y', strtotime($workExperience[0]['start_date'])) : 'N/A'; ?>
                </p>
              </div>
            </div>
          <?php else: ?>
            <p class="text-sm text-gray-600">
              Currently seeking employment opportunities.
            </p>
          <?php endif; ?>
        </div>

        <!-- Work Experience Card -->
        <div class="p-6 mt-2 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold">Work Experience</h4>
            <a href="?page=complete-jobseeker-profile&step=5"
              class="flex items-center text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-edit"></i>
              Edit
            </a>
          </div>
          <?php if (!empty($workExperience) && is_array($workExperience)): ?>
            <div class="space-y-4">
              <?php foreach ($workExperience as $work): ?>
                <div class="p-4 border border-gray-200 rounded-lg">
                  <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                    <div>
                      <p class="text-gray-500">Job Title</p>
                      <p class="font-medium"><?php echo htmlspecialchars($work['job_title'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                      <p class="text-gray-500">Duration</p>
                      <p class="font-medium">
                        <?php
                        $start = !empty($work['start_date']) ? date('M Y', strtotime($work['start_date'])) : 'N/A';
                        $end = ($work['currently_working'] ?? '') === 'Yes' ? 'Present' : (!empty($work['end_date']) ? date('M Y', strtotime($work['end_date'])) : 'N/A');
                        echo $start . ' - ' . $end;
                        ?>
                      </p>
                    </div>
                    <div class="md:col-span-2">
                      <p class="text-gray-500">Company/Organization</p>
                      <p class="font-medium"><?php echo htmlspecialchars($work['company_name'] ?? 'N/A'); ?></p>
                    </div>
                    <?php if (!empty($work['responsibilities']) && $work['responsibilities'] !== 'N/A'): ?>
                      <div class="md:col-span-2">
                        <p class="text-gray-500">Responsibilities</p>
                        <p class="text-sm font-medium"><?php echo htmlspecialchars($work['responsibilities']); ?></p>
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
        <div class="p-6 mt-2 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold">Educational Background</h4>
            <a href="?page=complete-jobseeker-profile&step=4"
              class="flex items-center text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-edit"></i>
              Edit
            </a>
          </div>
          <?php if (!empty($education) && is_array($education)): ?>
            <div class="space-y-4">
              <?php foreach ($education as $edu): ?>
                <div class="p-4 border border-gray-200 rounded-lg">
                  <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                    <div>
                      <p class="text-gray-500">Institution Name</p>
                      <p class="font-medium"><?php echo htmlspecialchars($edu['school_name'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                      <p class="text-gray-500">Duration</p>
                      <p class="font-medium">
                        <?php
                        $start = !empty($edu['start_date']) ? date('Y', strtotime($edu['start_date'])) : '';
                        $end = !empty($edu['end_date']) ? date('Y', strtotime($edu['end_date'])) : '';
                        echo $start && $end ? $start . ' - ' . $end : 'N/A';
                        ?>
                      </p>
                    </div>
                    <div>
                      <p class="text-gray-500">Degree/Program</p>
                      <p class="font-medium"><?php echo htmlspecialchars($edu['education_level'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                      <p class="text-gray-500">Field of Study</p>
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
        <div class="p-6 mt-2 bg-white border border-gray-200 shadow rounded-xl">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold">Skills & Expertise</h4>
            <a href="?page=complete-jobseeker-profile&step=6"
              class="flex items-center text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-edit"></i>
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
          <div class="p-6 mt-2 bg-white border border-gray-200 shadow rounded-xl">
            <div class="flex items-center justify-between mb-4">
              <h4 class="text-base font-semibold">Certificates & Licenses</h4>
              <a href="?page=complete-jobseeker-profile&step=7"
                class="flex items-center text-sm text-green-600 hover:text-green-700">
                <i class="mr-1 fas fa-edit"></i>
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
                    <i class="text-green-500 fas fa-certificate"></i>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php
// Handle profile photo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
  $targetDir = __DIR__ . '/../../../public/uploads/profile_photos/';
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
  }
  $fileName = 'jobseeker_' . $_SESSION['user_id'] . '_' . time() . '.' . pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
  $targetFile = $targetDir . $fileName;
  if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
    // Save the new photo path to the database
    $relativePath = '/public/uploads/profile_photos/' . $fileName;
    $jobseekerModel->updateProfilePhoto($_SESSION['user_id'], $relativePath);
    // Refresh page to show new photo
    echo "<script>window.location.reload();</script>";
    exit;
  }
}
?>