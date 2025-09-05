<?php
include_once __DIR__ . '/../components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Create Event</title>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Create New Event</h1>
                    <p class="mt-2 text-sm text-gray-700">Add a new event or program</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <div class="max-w-3xl p-6 bg-white rounded-lg shadow">
                    <form action="index.php?page=admin-event-store" method="POST" enctype="multipart/form-data">
                        <div class="grid gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Type</label>
                                <select name="type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="program">Program</option>
                                    <option value="jobfair">Job Fair</option>
                                    <option value="local recruitment">Local Recruitment</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="show">Show</option>
                                    <option value="hide">Hide</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Start Time</label>
                                    <input type="datetime-local" name="time_start" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">End Time</label>
                                    <input type="datetime-local" name="time_end" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="4" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image" accept="image/jpeg,image/png" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                                    onchange="previewImage(event)">
                                <div id="imagePreview" class="hidden mt-4">
                                    <img src="" alt="Preview" class="max-w-xs rounded-lg">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <a href="index.php?page=admin-events"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary/90">
                                Create Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const image = preview.querySelector('img');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>

</html>