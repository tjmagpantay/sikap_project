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
  <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
    <div class="flex flex-col gap-8 md:flex-row">
      <!-- Sidebar - Fixed -->
      <div class="w-full md:w-1/3">
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
          <div class="flex flex-col items-start">
            <!-- Profile Photo -->
            <div class="flex items-start">
              <div class="relative group">
                <img src="<?php
                          if (!empty($jobseeker['profile_picture'])) {
                            echo htmlspecialchars('/sikap/public/' . $jobseeker['profile_picture']);
                          } else {
                            echo '/sikap/public/assets/images/default-avatar.jpg';
                          }
                          ?>" alt="Profile" class="object-cover w-16 h-16 border-2 border-gray-200 rounded-md shadow-sm">
                <button type="button"
                  class="absolute flex items-center justify-center w-6 h-6 text-white transition-all duration-200 border-2 border-white rounded-full shadow-lg bg-primary -top-1 -right-1 hover:bg-primary-dark hover:shadow-xl group-hover:scale-110"
                  onclick="document.getElementById('profile-picture-input').click()" title="Change profile photo">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                  </svg>
                </button>
                <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(this);">
              </div>

              <!-- Name & Title -->
              <div class="items-center mt-0 ml-4">
                <h2 class="text-lg font-bold text-gray-800">
                  <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? '') . ' ' . ($jobseeker['suffix'] ?? ''))); ?>
                </h2>
                <p class="font-normal text-gray-400 text-md"><?php echo htmlspecialchars($workExperience[0]['job_title'] ?? 'Job Seeker'); ?></p>
              </div>
            </div>

            <!-- Profile Completion -->
            <div class="w-full p-4 mt-6 rounded-sm bg-gray-50">
              <div class="flex items-center justify-between mb-1">
                <span class="text-sm font-normal text-gray-700">Profile Completion</span>
                <span class="text-sm font-normal text-primary"><?php echo round($completionPercentage); ?>%</span>
              </div>
              <div class="w-full h-2 bg-gray-200 rounded-full">
                <div class="h-2 transition-all duration-300 bg-primary" style="width: <?php echo $completionPercentage; ?>%"></div>
              </div>
            </div>

            <!-- Edit Profile Button -->
            <div class="w-full mt-4 mb-4">
              <a href="?page=complete-jobseeker-profile" class="flex items-center justify-center w-full px-4 py-3 text-sm transition-colors border-2 border-gray-200 text-primary hover:bg-gray-50">
                Edit Profile
              </a>
            </div>

            <!-- Contact Info -->
            <div class="w-full">
              <h3 class="mb-3 text-sm font-semibold text-gray-700">Contact</h3>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  <span class="text-sm text-gray-600"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></span>
                </li>
                <?php if (!empty($jobseeker['contact_no'])): ?>
                  <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($jobseeker['contact_no']); ?></span>
                  </li>
                <?php endif; ?>
                <?php if (!empty($jobseeker['address'])): ?>
                  <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($jobseeker['address']); ?></span>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content - Dynamic -->
      <div class="w-full space-y-8 md:w-2/3">
        <div class="p-6 mb-6 bg-white border border-gray-200 shadow rounded-xl">
          <!-- Tab Navigation -->
          <div class="relative flex gap-6 mb-6 border-b">
            <div class="absolute bottom-0 left-0 w-full h-px bg-gray-200"></div>

            <!-- Dynamic Tabs -->
            <button onclick="switchTab('profile')" id="tab-profile"
              class="relative pb-2 font-semibold transition-colors duration-300 text-primary group tab-button active">
              <span>Applicant Profile</span>
              <div class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transition-all duration-300 transform origin-left scale-x-100 tab-indicator"></div>
            </button>

            <button onclick="switchTab('documents')" id="tab-documents"
              class="relative pb-2 text-gray-500 transition-colors duration-300 group hover:text-primary tab-button">
              <span>Resume & Documents</span>
              <div class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transition-all duration-300 transform origin-left scale-x-0 group-hover:scale-x-100 tab-indicator"></div>
            </button>

            <button onclick="switchTab('applications')" id="tab-applications"
              class="relative pb-2 text-gray-500 transition-colors duration-300 group hover:text-primary tab-button">
              <span>Job Applications</span>
              <div class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transition-all duration-300 transform origin-left scale-x-0 group-hover:scale-x-100 tab-indicator"></div>
            </button>
          </div>

          <!-- Loading Indicator -->
          <div id="tab-loading" class="hidden py-8 text-center">
            <svg class="w-8 h-8 mx-auto text-primary animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Loading...</p>
          </div>

          <!-- Dynamic Content Area -->
          <div id="tab-content">
            <!-- Default: Applicant Profile Content -->
            <?php include 'profile-components/profile-content.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let currentTab = 'profile';

  function switchTab(tabName) {
    // Don't reload if already on this tab
    if (currentTab === tabName) return;

    // Show loading
    showLoading();

    // Update tab styles
    updateTabStyles(tabName);

    // Load content via AJAX
    loadTabContent(tabName);

    currentTab = tabName;
  }

  function updateTabStyles(activeTab) {
    // Reset all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
      button.classList.remove('active', 'text-primary', 'font-semibold');
      button.classList.add('text-gray-500');

      const indicator = button.querySelector('.tab-indicator');
      if (indicator) {
        indicator.classList.remove('scale-x-100');
        indicator.classList.add('scale-x-0');
      }
    });

    // Activate current tab
    const activeButton = document.getElementById(`tab-${activeTab}`);
    if (activeButton) {
      activeButton.classList.remove('text-gray-500');
      activeButton.classList.add('text-primary', 'font-semibold', 'active');

      const indicator = activeButton.querySelector('.tab-indicator');
      if (indicator) {
        indicator.classList.remove('scale-x-0');
        indicator.classList.add('scale-x-100');
      }
    }
  }

  function showLoading() {
    document.getElementById('tab-loading').classList.remove('hidden');
    document.getElementById('tab-content').style.opacity = '0.5';
  }

  function hideLoading() {
    document.getElementById('tab-loading').classList.add('hidden');
    document.getElementById('tab-content').style.opacity = '1';
  }

  function loadTabContent(tabName) {
    fetch(`?page=profile-tab-content&tab=${tabName}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.text())
      .then(html => {
        document.getElementById('tab-content').innerHTML = html;
        hideLoading();

        // Update URL without reload
        const newUrl = `${window.location.pathname}?page=profile-jobseeker&tab=${tabName}`;
        window.history.pushState({
          tab: tabName
        }, '', newUrl);
      })
      .catch(error => {
        console.error('Error loading tab content:', error);
        document.getElementById('tab-content').innerHTML = `
            <div class="py-8 text-center">
                <svg class="w-12 h-12 mx-auto text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L5.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Error loading content. Please try again.</p>
                <button onclick="location.reload()" class="px-4 py-2 mt-3 text-sm text-white rounded bg-primary hover:bg-primary-600">
                    Refresh Page
                </button>
            </div>
        `;
        hideLoading();
      });
  }

  // Handle browser back/forward
  window.addEventListener('popstate', function(event) {
    if (event.state && event.state.tab) {
      switchTab(event.state.tab);
    }
  });

  // Initialize tab from URL
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tabFromUrl = urlParams.get('tab');

    if (tabFromUrl && ['profile', 'documents', 'applications'].includes(tabFromUrl)) {
      switchTab(tabFromUrl);
    }
  });

  // Profile photo upload function
  function handleProfilePhotoUpload(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];

      if (!file.type.startsWith('image/')) {
        showNotification('Please select an image file.', 'error');
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        showNotification('File size must be less than 2MB.', 'error');
        return;
      }

      const formData = new FormData();
      formData.append('profile_picture', file);

      const button = document.querySelector('button[title="Change profile photo"]');
      const originalContent = button.innerHTML;
      button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
      button.disabled = true;

      fetch('?page=upload-profile-photo', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const profileImg = document.querySelector('img[alt="Profile"]');
            profileImg.src = '/sikap/public/' + data.image_url + '?t=' + new Date().getTime();
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
          button.innerHTML = originalContent;
          button.disabled = false;
          input.value = '';
        });
    }
  }

  function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 transition-all duration-300 ${
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

    setTimeout(() => {
      if (notification.parentElement) {
        notification.remove();
      }
    }, 5000);
  }
</script>

<style>
  .tab-button.active .tab-indicator {
    transform: scaleX(1);
  }

  #tab-content {
    transition: opacity 0.3s ease;
  }
</style>