<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\components\profile-sidebar.php
?>
<!-- Sidebar -->
<div class="w-full p-4 bg-white shadow md:w-1/4 rounded-xl">
    <div class="flex flex-col items-center">
        <div class="relative">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(($jobseeker['first_name'] ?? '') . '+' . ($jobseeker['last_name'] ?? '')); ?>&background=10b981&color=fff&size=96"
                 class="w-24 h-24 rounded-full" alt="Profile">
            <button class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6 text-white transition-colors bg-green-600 rounded-full hover:bg-green-700"
                    onclick="document.getElementById('profile-photo-input').click()">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(this)">
        </div>
        <h2 class="mt-2 text-lg font-semibold">
            <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? 'User'))); ?>
        </h2>
        <p class="text-sm text-gray-500">
            <?php
            $latestWork = !empty($workExperience) && is_array($workExperience) ? $workExperience[0] : null;
            echo htmlspecialchars($latestWork['job_title'] ?? 'Job Seeker');
            ?>
        </p>
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

    <!-- Recent Applied Jobs -->
    <div class="mt-6">
        <h3 class="mb-2 text-sm text-gray-400">Recent Applied Jobs</h3>
        
        <!-- Temporary placeholder until job application system is built -->
        <div class="p-4 text-center border rounded bg-gray-50">
            <i class="mb-2 text-2xl text-gray-300 fas fa-briefcase"></i>
            <p class="text-xs text-gray-500 mb-2">Job application system coming soon!</p>
            <p class="text-xs text-gray-400">Focus on completing your profile for now.</p>
        </div>
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
                <span><?php echo !empty($jobseeker['date_of_birth']) && $jobseeker['date_of_birth'] ? date('M d, Y', strtotime($jobseeker['date_of_birth'])) : 'N/A'; ?></span>
            </li>
        </ul>
    </div>
</div>

<script>
function handleProfilePhotoUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            return;
        }
        
        const formData = new FormData();
        formData.append('profile_photo', file);
        
        const button = document.querySelector('.bg-green-600');
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        button.disabled = true;
        
        fetch('?page=upload-profile-photo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then((data) => {
            if (data.success) {
                const profileImg = document.querySelector('img[alt="Profile"]');
                profileImg.src = data.image_url + '?t=' + new Date().getTime();
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
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}
</script>