<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/../components/admin_auth_check.php';
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create New Event</h1>
        <p class="mt-2 text-sm text-gray-700">Add a new event or program</p>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['error'])): ?>
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="max-w-3xl p-6 bg-white rounded-lg shadow">
        <form action="index.php?page=admin-event-store" method="POST" enctype="multipart/form-data" id="event-form">
            <div class="grid gap-6">
                <!-- Title -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="title"
                        id="title"
                        required
                        maxlength="100"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                        placeholder="Enter event title">
                    <div id="title-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        <span id="title-count">0</span>/100 characters
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ open: false, selected: 'Select Type', selectedValue: '' }">
                        <button type="button" @click="open = !open" @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                            <span x-text="selected" :class="{'text-gray-500': selected === 'Select Type', 'text-gray-900': selected !== 'Select Type'}"></span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                            <div class="py-1">
                                <button type="button" @click="selected = 'Program'; selectedValue = 'program'; open = false; document.getElementById('type').value = 'program'; validateType();"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Program
                                </button>
                                <button type="button" @click="selected = 'Job Fair'; selectedValue = 'jobfair'; open = false; document.getElementById('type').value = 'jobfair'; validateType();"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Job Fair
                                </button>
                                <button type="button" @click="selected = 'Local Recruitment'; selectedValue = 'local recruitment'; open = false; document.getElementById('type').value = 'local recruitment'; validateType();"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Local Recruitment
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="type" name="type" :value="selectedValue">
                    </div>
                    <div id="type-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ open: false, selected: 'Show', selectedValue: 'show' }">
                        <button type="button" @click="open = !open" @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                            <span x-text="selected"></span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                            <div class="py-1">
                                <button type="button" @click="selected = 'Show'; selectedValue = 'show'; open = false; document.getElementById('status').value = 'show';"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Show
                                </button>
                                <button type="button" @click="selected = 'Hide'; selectedValue = 'hide'; open = false; document.getElementById('status').value = 'hide';"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Hide
                                </button>
                                <button type="button" @click="selected = 'Draft'; selectedValue = 'draft'; open = false; document.getElementById('status').value = 'draft';"
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Draft
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="status" name="status" :value="selectedValue">
                    </div>
                    <div id="status-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Start Time -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                            name="time_start"
                            id="time_start"
                            required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <div id="start-time-error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-400">
                            Cannot be in the past
                        </div>
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                            name="time_end"
                            id="time_end"
                            required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <div id="end-time-error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-400">
                            Must be after start time
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <textarea name="description"
                        id="description"
                        rows="4"
                        maxlength="1000"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                        placeholder="Enter event description (optional)"></textarea>
                    <div id="description-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        <span id="description-count">0</span>/1000 characters
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Image
                    </label>
                    <input type="file"
                        name="image"
                        id="image"
                        accept="image/jpeg,image/jpg,image/png"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                        onchange="previewImage(event)">
                    <div id="image-error" class="hidden mt-1 text-xs text-red-600"></div>
                    <div class="mt-1 text-xs text-gray-400">
                        Optional. Supported formats: JPG, JPEG, PNG. Maximum size: 5MB.
                    </div>
                    <div id="imagePreview" class="hidden mt-4">
                        <img src="" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Moved to Right -->
            <div class="flex items-end justify-end gap-3 mt-8">
                <a href="index.php?page=admin-events"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" id="submit-btn"
                    class="px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-primary">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get form elements
        const form = document.getElementById('event-form');
        const title = document.getElementById('title');
        const type = document.getElementById('type');
        const status = document.getElementById('status');
        const startTime = document.getElementById('time_start');
        const endTime = document.getElementById('time_end');
        const description = document.getElementById('description');
        const image = document.getElementById('image');

        // Character counters
        const titleCount = document.getElementById('title-count');
        const descriptionCount = document.getElementById('description-count');

        // Prevent input beyond maxlength for all fields
        function enforceMaxLength(element, maxLength) {
            element.addEventListener('input', function() {
                if (this.value.length > maxLength) {
                    this.value = this.value.slice(0, maxLength);
                }
            });

            element.addEventListener('paste', function(e) {
                setTimeout(() => {
                    if (this.value.length > maxLength) {
                        this.value = this.value.slice(0, maxLength);
                        updateCharacterCounts();
                    }
                }, 0);
            });
        }

        // Apply maxlength enforcement
        enforceMaxLength(title, 100);
        enforceMaxLength(description, 1000);

        // Validation functions
        function validateTitle() {
            const value = title.value.trim();
            const errorElement = document.getElementById('title-error');

            clearError(title, errorElement);

            if (!value) {
                showError(title, errorElement, 'Title is required.');
                return false;
            }

            if (value.length < 3) {
                showError(title, errorElement, 'Title must be at least 3 characters long.');
                return false;
            }

            if (value.length > 100) {
                showError(title, errorElement, 'Title cannot exceed 100 characters.');
                return false;
            }

            return true;
        }

        function validateType() {
            const value = type.value;
            const errorElement = document.getElementById('type-error');

            clearError(type, errorElement);

            if (!value) {
                showError(type, errorElement, 'Please select an event type.');
                return false;
            }

            return true;
        }

        function validateStatus() {
            const value = status.value;
            const errorElement = document.getElementById('status-error');

            clearError(status, errorElement);

            if (!value) {
                showError(status, errorElement, 'Please select a status.');
                return false;
            }

            return true;
        }

        function validateStartTime() {
            const value = startTime.value;
            const errorElement = document.getElementById('start-time-error');

            clearError(startTime, errorElement);

            if (!value) {
                showError(startTime, errorElement, 'Start time is required.');
                return false;
            }

            const startDate = new Date(value);
            const now = new Date();

            if (startDate <= now) {
                showError(startTime, errorElement, 'Start time cannot be in the past.');
                return false;
            }

            return true;
        }

        function validateEndTime() {
            const startValue = startTime.value;
            const endValue = endTime.value;
            const errorElement = document.getElementById('end-time-error');

            clearError(endTime, errorElement);

            if (!endValue) {
                showError(endTime, errorElement, 'End time is required.');
                return false;
            }

            const endDate = new Date(endValue);
            const now = new Date();

            if (endDate <= now) {
                showError(endTime, errorElement, 'End time cannot be in the past.');
                return false;
            }

            if (startValue) {
                const startDate = new Date(startValue);
                if (endDate <= startDate) {
                    showError(endTime, errorElement, 'End time must be after start time.');
                    return false;
                }
            }

            return true;
        }

        function validateDescription() {
            const value = description.value.trim();
            const errorElement = document.getElementById('description-error');

            clearError(description, errorElement);

            if (value && value.length > 1000) {
                showError(description, errorElement, 'Description cannot exceed 1000 characters.');
                return false;
            }

            return true;
        }

        function validateImage() {
            const file = image.files[0];
            const errorElement = document.getElementById('image-error');

            clearError(image, errorElement);

            if (file) {
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    showError(image, errorElement, 'Please upload a valid image file (JPG, JPEG, or PNG).');
                    return false;
                }

                // Check file size (5MB = 5 * 1024 * 1024 bytes)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    showError(image, errorElement, 'Image size cannot exceed 5MB.');
                    return false;
                }
            }

            return true;
        }

        // Helper functions
        function showError(element, errorElement, message) {
            element.classList.add('border-red-500');
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }

        function clearError(element, errorElement) {
            element.classList.remove('border-red-500');
            errorElement.textContent = '';
            errorElement.classList.add('hidden');
        }

        // Character counters
        function updateCharacterCounts() {
            if (titleCount) titleCount.textContent = title.value.length;
            if (descriptionCount) descriptionCount.textContent = description.value.length;
        }

        // Event listeners for real-time validation and character counting
        title.addEventListener('input', function() {
            updateCharacterCounts();
            validateTitle();
        });

        description.addEventListener('input', function() {
            updateCharacterCounts();
            validateDescription();
        });

        startTime.addEventListener('change', function() {
            validateStartTime();
            validateEndTime(); // Revalidate end time when start time changes
        });

        endTime.addEventListener('change', validateEndTime);
        image.addEventListener('change', validateImage);

        // Initialize character counts
        updateCharacterCounts();

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Run all validations
            if (!validateTitle()) isValid = false;
            if (!validateType()) isValid = false;
            if (!validateStatus()) isValid = false;
            if (!validateStartTime()) isValid = false;
            if (!validateEndTime()) isValid = false;
            if (!validateDescription()) isValid = false;
            if (!validateImage()) isValid = false;

            if (!isValid) {
                e.preventDefault();

                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return false;
            }
        });
    });

    // Image preview function
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const image = preview.querySelector('img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
                preview.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>