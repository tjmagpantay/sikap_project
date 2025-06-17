<?php
// filepath: app/views/jobseekers/apply-job.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="max-w-4xl py-6 mx-auto sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="text-blue-600 hover:text-blue-800">
                    <i class="mr-1 fas fa-arrow-left"></i> Back to Job Details
                </a>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">Apply for Job</h1>
                <h2 class="text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($job['job_title']); ?></h2>
                <p class="text-gray-600"><?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?></p>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <?php if (!empty($error)): ?>
        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- Application Form -->
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Job Summary -->
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Job Summary</h3>
            <div class="p-4 rounded bg-gray-50">
                <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($job['job_summary'])); ?></p>
                <div class="mt-2 text-sm text-gray-500">
                    <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($job['location']); ?></span>
                    <span class="ml-4"><i class="mr-1 fas fa-briefcase"></i><?php echo ucfirst($job['job_type']); ?></span>
                    <?php if ($job['show_pay'] && $job['salary']): ?>
                        <span class="ml-4"><i class="mr-1 fas fa-money-bill"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Resume Section -->
        <?php if ($job['resume_required']): ?>
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">
                Resume <span class="text-red-500">*</span>
            </h3>
            
            <?php if (!empty($documents)): ?>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Select from uploaded documents:</label>
                    <select name="selected_resume" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select a document --</option>
                        <?php foreach ($documents as $doc): ?>
                            <?php if (in_array($doc['file_type'], ['resume', 'cv'])): ?>
                                <option value="<?php echo htmlspecialchars($doc['file_path']); ?>">
                                    <?php echo htmlspecialchars($doc['file_name']); ?> (<?php echo ucfirst($doc['file_type']); ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="my-4 text-center text-gray-500">
                    <span>OR</span>
                </div>
            <?php endif; ?>
            
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Upload new resume:</label>
                <input type="file" name="new_resume" accept=".pdf,.doc,.docx" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX (Max 5MB)</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Cover Letter Section -->
        <?php if ($job['allow_cover_letter']): ?>
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Cover Letter</h3>
            <textarea name="cover_letter" rows="6" 
                      class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Write your cover letter here..."></textarea>
            <p class="mt-1 text-sm text-gray-500">Tell the employer why you're perfect for this role.</p>
        </div>
        <?php endif; ?>

        <!-- Screening Questions -->
        <?php if (!empty($screeningQuestions) && ($job['screening_questions_enabled'] ?? 0) == 1): ?>
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Screening Questions</h3>
            <div class="space-y-4">
                <?php foreach ($screeningQuestions as $question): ?>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            <?php echo htmlspecialchars($question['question_text']); ?>
                            <span class="text-red-500">*</span>
                        </label>
                        
                        <?php if ($question['question_type'] === 'text'): ?>
                            <input type="text" name="question_<?php echo $question['question_id']; ?>" required
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <?php elseif ($question['question_type'] === 'textarea'): ?>
                            <textarea name="question_<?php echo $question['question_id']; ?>" rows="3" required
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        
                        <?php elseif ($question['question_type'] === 'yes_no'): ?>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="Yes" required class="mr-2">
                                    Yes
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="No" required class="mr-2">
                                    No
                                </label>
                            </div>
                        
                        <?php elseif ($question['question_type'] === 'multiple_choice' && !empty($question['question_option'])): ?>
                            <?php $options = json_decode($question['question_option'], true); ?>
                            <?php if ($options): ?>
                                <select name="question_<?php echo $question['question_id']; ?>" required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select an option --</option>
                                    <?php foreach ($options as $option): ?>
                                        <option value="<?php echo htmlspecialchars($option); ?>">
                                            <?php echo htmlspecialchars($option); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Additional Attachments -->
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Attachments (Optional)</h3>
            <div id="attachments-container">
                <div class="flex items-center mb-3 space-x-4 attachment-row">
                    <div class="flex-1">
                        <input type="file" name="attachments[]" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-40">
                        <select name="attachment_types[]" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Portfolio">Portfolio</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Transcript">Transcript</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <button type="button" onclick="removeAttachment(this)" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <button type="button" onclick="addAttachment()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                <i class="mr-1 fas fa-plus"></i> Add another attachment
            </button>
            <p class="mt-2 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 10MB each)</p>
        </div>

        <!-- Submit Section -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Ready to Apply?</h3>
                    <p class="text-sm text-gray-600">Make sure all information is correct before submitting.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Submit Application
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function addAttachment() {
    const container = document.getElementById('attachments-container');
    const newRow = document.createElement('div');
    newRow.className = 'attachment-row flex items-center space-x-4 mb-3';
    newRow.innerHTML = `
        <div class="flex-1">
            <input type="file" name="attachments[]" 
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="w-40">
            <select name="attachment_types[]" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Portfolio">Portfolio</option>
                <option value="Certificate">Certificate</option>
                <option value="Transcript">Transcript</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <button type="button" onclick="removeAttachment(this)" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newRow);
}

function removeAttachment(button) {
    const container = document.getElementById('attachments-container');
    if (container.children.length > 1) {
        button.closest('.attachment-row').remove();
    }
}
</script>