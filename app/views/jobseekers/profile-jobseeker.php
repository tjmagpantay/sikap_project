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

<div class="flex flex-col min-h-screen gap-6 p-6 font-sans bg-gray-100 md:flex-row">
  <!-- Sidebar (This will be reused across all profile pages) -->
  <?php include_once __DIR__ . '/profile-components/profile-sidebar.php'; ?>

  <!-- Main Content -->
  <div class="w-full p-6 bg-white shadow md:w-3/4 rounded-xl">
    <!-- Page Navigation -->
    <div class="flex mb-4 space-x-8 border-b">
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

    <!-- Profile Content -->
    <div>
      <!-- Personal Information -->
      <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
          <h4 class="text-base font-semibold">Personal Information</h4>
          <a href="?page=complete-jobseeker-profile&step=2"
            class="flex items-center text-sm text-green-600 hover:text-green-700">
            <i class="mr-1 fas fa-edit"></i>
            Edit
          </a>
        </div>

        <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
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

      <!-- Employment Status -->
      <div class="mt-6">
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

          <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
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

      <!-- Work Experience -->
      <div class="mt-6">
        <div class="flex items-center justify-between mb-4">
          <h4 class="text-base font-semibold">Work Experience</h4>
          <a href="?page=complete-jobseeker-profile&step=5"
            class="flex items-center text-sm text-green-600 hover:text-green-700">
            <i class="mr-1 fas fa-edit"></i>
            Edit
          </a>
        </div>

        <?php if (!empty($workExperience) && is_array($workExperience)): ?>
          <?php foreach ($workExperience as $work): ?>
            <div class="p-4 mb-4 border border-gray-200 rounded-lg">
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
        <?php else: ?>
          <p class="text-sm text-gray-500">No work experience added yet.</p>
        <?php endif; ?>
      </div>

      <!-- Educational Background -->
      <div class="mt-6">
        <div class="flex items-center justify-between mb-4">
          <h4 class="text-base font-semibold">Educational Background</h4>
          <a href="?page=complete-jobseeker-profile&step=4"
            class="flex items-center text-sm text-green-600 hover:text-green-700">
            <i class="mr-1 fas fa-edit"></i>
            Edit
          </a>
        </div>

        <?php if (!empty($education) && is_array($education)): ?>
          <?php foreach ($education as $edu): ?>
            <div class="p-4 mb-4 border border-gray-200 rounded-lg">
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
        <?php else: ?>
          <p class="text-sm text-gray-500">No educational background added yet.</p>
        <?php endif; ?>
      </div>

      <!-- Skills -->
      <div class="mt-6">
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

      <!-- Certificates -->
      <?php if (!empty($certificates) && is_array($certificates)): ?>
        <div class="mt-6">
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