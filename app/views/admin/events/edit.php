<?php
include_once __DIR__ . '/../components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Edit Event</title>
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
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: calc(100vh - 4rem);
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/../components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/../components/sidebar.php'; ?>

        <!-- Main Content Area (Scrollable) -->
        <div class="flex-1 lg:ml-80 main-content">
            <div class="container px-6 py-8 mx-auto">
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Edit Event</h1>
                    <p class="mt-2 text-sm text-gray-700">Modify event details</p>
                </div>

                <div class="max-w-3xl p-6 bg-white rounded-lg shadow">
                    <form action="index.php?page=admin-event-edit&id=<?php echo $event['event_id']; ?>"
                        method="POST"
                        enctype="multipart/form-data">
                        <div class="grid gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                                <input type="text"
                                    name="title"
                                    required
                                    value="<?php echo htmlspecialchars($event['title']); ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Type</label>
                                <select name="type"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="program" <?php echo $event['type'] === 'program' ? 'selected' : ''; ?>>Program</option>
                                    <option value="jobfair" <?php echo $event['type'] === 'jobfair' ? 'selected' : ''; ?>>Job Fair</option>
                                    <option value="local recruitment" <?php echo $event['type'] === 'local recruitment' ? 'selected' : ''; ?>>Local Recruitment</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="show" <?php echo $event['status'] === 'show' ? 'selected' : ''; ?>>Show</option>
                                    <option value="hide" <?php echo $event['status'] === 'hide' ? 'selected' : ''; ?>>Hide</option>
                                    <option value="draft" <?php echo $event['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Start Time</label>
                                    <input type="datetime-local"
                                        name="time_start"
                                        required
                                        value="<?php echo date('Y-m-d\TH:i', strtotime($event['time_start'])); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">End Time</label>
                                    <input type="datetime-local"
                                        name="time_end"
                                        required
                                        value="<?php echo date('Y-m-d\TH:i', strtotime($event['time_end'])); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description"
                                    rows="4"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($event['description']); ?></textarea>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Image</label>
                                <?php if ($event['image']): ?>
                                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($event['image']); ?>">
                                    <div class="mb-4" id="currentImageContainer" style="<?php echo $event['image'] ? '' : 'display:none;'; ?>">
                                        <img id="currentImage" src="<?php echo htmlspecialchars($event['image']); ?>"
                                            alt="Current Image"
                                            class="object-cover w-32 h-32 rounded-lg">
                                        <p class="mt-2 text-sm text-gray-600">Current image</p>
                                    </div>
                                    <input type="file"
                                        name="image"
                                        accept="image/jpeg,image/png"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                                        onchange="previewImage(event)">
                                    <p class="mt-2 text-sm text-gray-500">Leave empty to keep current image</p>
                                <?php else: ?>
                                    <input type="file"
                                        name="image"
                                        accept="image/jpeg,image/png"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                                        onchange="previewImage(event)">
                                    <p class="mt-2 text-sm text-gray-500">Upload an image for this event</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <a href="index.php?page=admin-events"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary/90">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const currentImage = document.getElementById('currentImage');
            const currentImageContainer = document.getElementById('currentImageContainer');

            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                if (currentImage) {
                    currentImage.src = e.target.result;
                } else {
                    // Create image element if it doesn't exist
                    const newImg = document.createElement('img');
                    newImg.id = 'currentImage';
                    newImg.src = e.target.result;
                    newImg.alt = 'Preview Image';
                    newImg.className = 'object-cover w-32 h-32 rounded-lg';

                    if (currentImageContainer) {
                        currentImageContainer.innerHTML = '<p class="mt-2 text-sm text-gray-600">Preview image</p>';
                        currentImageContainer.insertBefore(newImg, currentImageContainer.firstChild);
                    }
                }

                if (currentImageContainer) {
                    currentImageContainer.style.display = '';
                }
            }
            reader.readAsDataURL(file);
        }
    </script>

</body>

</html>