<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\profile-jobseeker.php
require_once __DIR__ . '/../../models/Jobseeker.php';

// Get jobseeker data
$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

// Get additional profile data
$education = $jobseekerModel->getEducation($_SESSION['user_id']);
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
$skills = $jobseekerModel->getSkills($_SESSION['user_id']);
$certificates = $jobseekerModel->getCertificates($_SESSION['user_id']);
$documents = $jobseekerModel->getDocuments($_SESSION['user_id']);

// Calculate profile completion percentage
$completionPercentage = $jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
?>

<?php include_once __DIR__ . '/../components/navbar-top.php'; 
      include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="flex flex-col min-h-screen gap-6 p-6 font-sans bg-gray-100 md:flex-row">
  <!-- Sidebar -->
  <div class="w-full p-4 bg-white shadow md:w-1/4 rounded-xl">
    <div class="flex flex-col items-center">
      <div class="relative">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(($jobseeker['first_name'] ?? '') . '+' . ($jobseeker['last_name'] ?? '')); ?>&background=10b981&color=fff&size=96" 
             class="w-24 h-24 rounded-full" alt="Profile">
        <button class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6 text-white transition-colors bg-green-600 rounded-full hover:bg-green-700 group"
                onclick="document.getElementById('profile-photo-input').click()">
          <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
          </svg>
        </button>
        <!-- Hidden file input for profile photo upload -->
        <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(this)">
      </div>
      <h2 class="mt-2 text-lg font-semibold">
        <?php echo htmlspecialchars(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? 'User')); ?>
      </h2>
      <p class="text-sm text-gray-500">
        <?php 
        $latestWork = !empty($workExperience) ? $workExperience[0] : null;
        echo htmlspecialchars($latestWork['job_title'] ?? 'Job Seeker'); 
        ?>
      </p>
    </div>

    <!-- Recent Applied Jobs -->
    <div class="mt-6">
      <h3 class="mb-2 text-sm text-gray-400">Recent Applied Jobs</h3>
      <?php
      // This would come from applications table - for now showing placeholder
      ?>
      <div class="p-3 mt-1 border rounded bg-gray-50">
        <p class="text-sm font-semibold">Software Developer</p>
        <p class="text-xs text-gray-500">Technology • Full-Time</p>
        <p class="mt-2 text-xs text-right text-gray-400">2 days ago</p>
      </div>
      
      <div class="p-3 mt-2 border rounded bg-gray-50">
        <p class="text-sm font-semibold">Data Analyst</p>
        <p class="text-xs text-gray-500">Analytics • Part-Time</p>
        <p class="mt-2 text-xs text-right text-gray-400">5 days ago</p>
      </div>

      <!-- Profile Completion -->
      <div class="mt-4">
        <p class="mb-1 text-sm text-gray-500">Profile Completion</p>
        <div class="w-full h-2 bg-gray-200 rounded">
          <div class="h-2 transition-all duration-300 bg-green-600 rounded" 
               style="width: <?php echo $completionPercentage; ?>%"></div>
        </div>
        <p class="mt-1 text-xs text-right text-gray-500"><?php echo $completionPercentage; ?>%</p>
      </div>

      <a href="?page=complete-jobseeker-profile" 
         class="flex items-center justify-center w-full py-2 mt-4 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50">
        <i class="mr-2 fas fa-edit"></i>
        <?php echo $completionPercentage < 100 ? 'Complete Profile' : 'Edit Profile'; ?>
      </a>
    </div>

    <!-- Contact Information -->
    <div class="pt-4 mt-6 border-t">
      <h3 class="mb-2 text-sm font-semibold">Contact</h3>
      <ul class="space-y-2 text-sm text-gray-600">
        <li class="flex items-center">
          <i class="w-4 mr-2 text-gray-400 fas fa-envelope"></i>
          <span class="break-all"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></span>
        </li>
        <li class="flex items-center">
          <i class="w-4 mr-2 text-gray-400 fas fa-phone"></i>
          <span><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></span>
        </li>
        <li class="flex items-center">
          <i class="w-4 mr-2 text-gray-400 fas fa-map-marker-alt"></i>
          <span><?php echo htmlspecialchars($jobseeker['address'] ?? 'N/A'); ?></span>
        </li>
        <li class="flex items-center">
          <i class="w-4 mr-2 text-gray-400 fas fa-birthday-cake"></i>
          <span><?php echo $jobseeker['date_of_birth'] ? date('M d, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A'; ?></span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="w-full p-6 bg-white shadow md:w-3/4 rounded-xl">
    <!-- Tab Navigation -->
    <div class="flex mb-4 space-x-8 border-b" x-data="{ activeTab: 'profile' }">
      <button @click="activeTab = 'profile'" 
              :class="activeTab === 'profile' ? 'font-semibold border-b-2 border-green-500 text-green-600' : 'text-gray-500'"
              class="pb-2 transition-colors">
        Applicant Profile
      </button>
      <button @click="activeTab = 'resume'" 
              :class="activeTab === 'resume' ? 'font-semibold border-b-2 border-green-500 text-green-600' : 'text-gray-500'"
              class="pb-2 transition-colors">
        Resume & Documents
      </button>
      <button @click="activeTab = 'applications'" 
              :class="activeTab === 'applications' ? 'font-semibold border-b-2 border-green-500 text-green-600' : 'text-gray-500'"
              class="pb-2 transition-colors">
        Job Applications
      </button>
      <button @click="activeTab = 'settings'" 
              :class="activeTab === 'settings' ? 'font-semibold border-b-2 border-green-500 text-green-600' : 'text-gray-500'"
              class="pb-2 transition-colors">
        Account Settings
      </button>
    </div>

    <!-- Profile Tab -->
    <div x-show="activeTab === 'profile'" x-transition>
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
              <?php echo $jobseeker['date_of_birth'] ? date('F j, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A'; ?>
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
        
        <?php if (!empty($workExperience) && $workExperience[0]['currently_working'] === 'Yes'): ?>
          <p class="mb-4 text-sm text-gray-600">
            Currently working as <?php echo htmlspecialchars($workExperience[0]['job_title']); ?> 
            at <?php echo htmlspecialchars($workExperience[0]['company_name']); ?>.
          </p>
          
          <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
            <div>
              <p class="text-gray-500">Current Job</p>
              <p class="font-medium"><?php echo htmlspecialchars($workExperience[0]['job_title']); ?></p>
            </div>
            <div>
              <p class="text-gray-500">Company</p>
              <p class="font-medium"><?php echo htmlspecialchars($workExperience[0]['company_name']); ?></p>
            </div>
            <div>
              <p class="text-gray-500">Employment Type</p>
              <p class="font-medium"><?php echo htmlspecialchars(ucfirst($workExperience[0]['employment_type'])); ?></p>
            </div>
            <div>
              <p class="text-gray-500">Start Date</p>
              <p class="font-medium">
                <?php echo $workExperience[0]['start_date'] ? date('M Y', strtotime($workExperience[0]['start_date'])) : 'N/A'; ?>
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
        
        <?php if (!empty($workExperience)): ?>
          <?php foreach ($workExperience as $work): ?>
            <div class="p-4 mb-4 border border-gray-200 rounded-lg">
              <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                <div>
                  <p class="text-gray-500">Job Title</p>
                  <p class="font-medium"><?php echo htmlspecialchars($work['job_title']); ?></p>
                </div>
                <div>
                  <p class="text-gray-500">Duration</p>
                  <p class="font-medium">
                    <?php 
                    $start = $work['start_date'] ? date('M Y', strtotime($work['start_date'])) : 'N/A';
                    $end = $work['currently_working'] === 'Yes' ? 'Present' : ($work['end_date'] ? date('M Y', strtotime($work['end_date'])) : 'N/A');
                    echo $start . ' - ' . $end;
                    ?>
                  </p>
                </div>
                <div class="md:col-span-2">
                  <p class="text-gray-500">Company/Organization</p>
                  <p class="font-medium"><?php echo htmlspecialchars($work['company_name']); ?></p>
                </div>
                <?php if ($work['responsibilities'] && $work['responsibilities'] !== 'N/A'): ?>
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
        
        <?php if (!empty($education)): ?>
          <?php foreach ($education as $edu): ?>
            <div class="p-4 mb-4 border border-gray-200 rounded-lg">
              <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                <div>
                  <p class="text-gray-500">Institution Name</p>
                  <p class="font-medium"><?php echo htmlspecialchars($edu['school_name']); ?></p>
                </div>
                <div>
                  <p class="text-gray-500">Duration</p>
                  <p class="font-medium">
                    <?php 
                    $start = $edu['start_date'] ? date('Y', strtotime($edu['start_date'])) : '';
                    $end = $edu['end_date'] ? date('Y', strtotime($edu['end_date'])) : '';
                    echo $start && $end ? $start . ' - ' . $end : 'N/A';
                    ?>
                  </p>
                </div>
                <div>
                  <p class="text-gray-500">Degree/Program</p>
                  <p class="font-medium"><?php echo htmlspecialchars($edu['education_level']); ?></p>
                </div>
                <div>
                  <p class="text-gray-500">Field of Study</p>
                  <p class="font-medium"><?php echo htmlspecialchars($edu['field_of_study']); ?></p>
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
        
        <?php if (!empty($skills)): ?>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($skills as $skill): ?>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                          <?php 
                          switch($skill['proficiency_level']) {
                              case 'Expert': echo 'bg-green-100 text-green-800'; break;
                              case 'Advanced': echo 'bg-blue-100 text-blue-800'; break;
                              case 'Intermediate': echo 'bg-yellow-100 text-yellow-800'; break;
                              default: echo 'bg-gray-100 text-gray-800';
                          }
                          ?>">
                <?php echo htmlspecialchars($skill['skill_name']); ?>
                <span class="ml-1 text-xs opacity-75">(<?php echo $skill['proficiency_level']; ?>)</span>
              </span>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-sm text-gray-500">No skills added yet.</p>
        <?php endif; ?>
      </div>

      <!-- Certificates -->
      <?php if (!empty($certificates)): ?>
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
                    <h5 class="text-sm font-medium"><?php echo htmlspecialchars($cert['certificate_title']); ?></h5>
                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($cert['issuing_organization']); ?></p>
                    <?php if ($cert['date_issued']): ?>
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

    <!-- Resume & Documents Tab -->
    <div x-show="activeTab === 'resume'" x-transition>
      <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
          <h4 class="text-base font-semibold">Documents & Resume</h4>
          <a href="?page=complete-jobseeker-profile&step=1" 
             class="flex items-center text-sm text-green-600 hover:text-green-700">
            <i class="mr-1 fas fa-upload"></i>
            Upload New
          </a>
        </div>
        
        <?php if (!empty($documents)): ?>
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <?php foreach ($documents as $doc): ?>
              <div class="p-4 transition-colors border border-gray-200 rounded-lg hover:border-green-300">
                <div class="flex items-center">
                  <i class="mr-3 text-2xl text-red-500 fas fa-file-pdf"></i>
                  <div class="flex-1">
                    <h5 class="text-sm font-medium"><?php echo htmlspecialchars($doc['file_name']); ?></h5>
                    <p class="text-xs text-gray-500 capitalize"><?php echo htmlspecialchars($doc['file_type']); ?></p>
                    <p class="text-xs text-gray-400">
                      Uploaded: <?php echo date('M d, Y', strtotime($doc['uploaded_at'])); ?>
                    </p>
                  </div>
                  <div class="flex flex-col space-y-1">
                    <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" 
                       class="text-xs text-green-600 hover:text-green-700">
                      <i class="mr-1 fas fa-eye"></i>View
                    </a>
                    <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" download 
                       class="text-xs text-blue-600 hover:text-blue-700">
                      <i class="mr-1 fas fa-download"></i>Download
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="py-8 text-center">
            <i class="mb-4 text-4xl text-gray-300 fas fa-file-upload"></i>
            <p class="text-sm text-gray-500">No documents uploaded yet.</p>
            <a href="?page=complete-jobseeker-profile&step=1" 
               class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
              <i class="mr-2 fas fa-upload"></i>
              Upload Resume/CV
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Job Applications Tab -->
    <div x-show="activeTab === 'applications'" x-transition>
      <div class="mb-6">
        <h4 class="mb-4 text-base font-semibold">My Job Applications</h4>
        
        <!-- This would be populated from job applications table -->
        <div class="py-8 text-center">
          <i class="mb-4 text-4xl text-gray-300 fas fa-briefcase"></i>
          <p class="text-sm text-gray-500">No job applications yet.</p>
          <a href="?page=browse-jobs" 
             class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
            <i class="mr-2 fas fa-search"></i>
            Browse Jobs
          </a>
        </div>
      </div>
    </div>

    <!-- Account Settings Tab -->
    <div x-show="activeTab === 'settings'" x-transition>
      <div class="mb-6">
        <h4 class="mb-4 text-base font-semibold">Account Settings</h4>
        
        <div class="space-y-6">
          <!-- Change Password -->
          <div class="p-4 border border-gray-200 rounded-lg">
            <h5 class="mb-2 text-sm font-medium">Change Password</h5>
            <p class="mb-4 text-xs text-gray-500">Update your password to keep your account secure.</p>
            <button class="text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-key"></i>
              Change Password
            </button>
          </div>

          <!-- Privacy Settings -->
          <div class="p-4 border border-gray-200 rounded-lg">
            <h5 class="mb-2 text-sm font-medium">Privacy Settings</h5>
            <p class="mb-4 text-xs text-gray-500">Control who can see your profile and contact information.</p>
            <button class="text-sm text-green-600 hover:text-green-700">
              <i class="mr-1 fas fa-shield-alt"></i>
              Manage Privacy
            </button>
          </div>

          <!-- Delete Account -->
          <div class="p-4 border border-red-200 rounded-lg bg-red-50">
            <h5 class="mb-2 text-sm font-medium text-red-800">Delete Account</h5>
            <p class="mb-4 text-xs text-red-600">Permanently delete your account and all associated data.</p>
            <button class="text-sm text-red-600 hover:text-red-700">
              <i class="mr-1 fas fa-trash-alt"></i>
              Delete Account
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function handleProfilePhotoUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }
        
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            return;
        }
        
        // Create FormData for upload
        const formData = new FormData();
        formData.append('profile_photo', file);
        
        // Show loading state
        const button = document.querySelector('.bg-green-600');
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        button.disabled = true;
        
        // Upload the file
        fetch('?page=upload-profile-photo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the profile image
                const profileImg = document.querySelector('img[alt="Profile"]');
                profileImg.src = data.image_url + '?t=' + new Date().getTime(); // Add timestamp to force reload
                
                // Show success message
                showNotification('Profile photo updated successfully!', 'success');
            } else {
                showNotification(data.message || 'Failed to upload photo', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to upload photo', 'error');
        })
        .finally(() => {
            // Restore button state
            button.innerHTML = originalContent;
            button.disabled = false;
            input.value = ''; // Clear the input
        });
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' 
                    ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>'
                    : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>'
                }
            </svg>
            <span class="text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}
</script>