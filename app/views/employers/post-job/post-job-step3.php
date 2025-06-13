<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\post-job-step3.php

// Get existing screening questions if editing
$existingQuestions = $screeningQuestions ?? [];
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-question-circle"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Screening Questions
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 3/5 - Add Custom Questions for Applicants (Optional)
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-green-600 rounded" style="width: 60%"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-2">
                    <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Job Details
                    </a>
                    <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Documentation
                    </a>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-md">
                        Screening
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
                        Settings
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
                        Review
                    </span>
                </nav>
            </div>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-red-400 fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=post-job&step=3&job_id=<?php echo $job_id; ?>">
                
                <!-- Information Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Why use screening questions?
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Screening questions help you filter candidates before reviewing their full applications. Use them to ask about experience, availability, or specific requirements.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions Container -->
                <div id="questionsContainer" class="space-y-4">
                    <?php if (!empty($existingQuestions)): ?>
                        <?php foreach ($existingQuestions as $index => $question): ?>
                            <div class="question-item border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="text-sm font-medium text-gray-900">Question <?php echo $index + 1; ?></h4>
                                    <button type="button" onclick="removeQuestion(this)" 
                                            class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Question Text
                                        </label>
                                        <textarea name="questions[<?php echo $index; ?>][text]" rows="2" required
                                                  placeholder="Enter your question..."
                                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"><?php echo htmlspecialchars($question['question_text']); ?></textarea>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Question Type
                                            </label>
                                            <select name="questions[<?php echo $index; ?>][type]" 
                                                    onchange="toggleOptions(this)"
                                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                                                <option value="text" <?php echo $question['question_type'] == 'text' ? 'selected' : ''; ?>>Text Input</option>
                                                <option value="radio" <?php echo $question['question_type'] == 'radio' ? 'selected' : ''; ?>>Multiple Choice (Single)</option>
                                                <option value="checkbox" <?php echo $question['question_type'] == 'checkbox' ? 'selected' : ''; ?>>Multiple Choice (Multiple)</option>
                                                <option value="dropdown" <?php echo $question['question_type'] == 'dropdown' ? 'selected' : ''; ?>>Dropdown</option>
                                            </select>
                                        </div>

                                        <div class="options-container" style="<?php echo in_array($question['question_type'], ['text']) ? 'display: none;' : ''; ?>">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Options (comma-separated)
                                            </label>
                                            <input type="text" name="questions[<?php echo $index; ?>][options]" 
                                                   value="<?php echo htmlspecialchars($question['question_option'] ?? ''); ?>"
                                                   placeholder="Option 1, Option 2, Option 3"
                                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Add Question Button -->
                <div class="text-center">
                    <button type="button" onclick="addQuestion()" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-white border border-green-600 rounded-md hover:bg-green-50">
                        <i class="mr-2 fas fa-plus"></i>
                        Add Question
                    </button>
                </div>

                <!-- Sample Questions -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Sample Questions</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><strong>Experience:</strong> "How many years of experience do you have in this field?"</p>
                        <p><strong>Availability:</strong> "When can you start working?"</p>
                        <p><strong>Salary:</strong> "What is your expected salary range?"</p>
                        <p><strong>Location:</strong> "Are you willing to relocate for this position?"</p>
                        <p><strong>Skills:</strong> "Rate your proficiency in [specific skill] from 1-5."</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Previous Step
                    </a>

                    <div class="flex space-x-3">
                        <button type="submit" name="skip_step" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Skip This Step
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                            Continue to Settings
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let questionCount = <?php echo count($existingQuestions); ?>;

function addQuestion() {
    const container = document.getElementById('questionsContainer');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'question-item border border-gray-200 rounded-lg p-4';
    
    questionDiv.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="text-sm font-medium text-gray-900">Question ${questionCount + 1}</h4>
            <button type="button" onclick="removeQuestion(this)" 
                    class="text-red-600 hover:text-red-700">
                <i class="fas fa-trash text-sm"></i>
            </button>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Question Text
                </label>
                <textarea name="questions[${questionCount}][text]" rows="2" required
                          placeholder="Enter your question..."
                          class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Question Type
                    </label>
                    <select name="questions[${questionCount}][type]" 
                            onchange="toggleOptions(this)"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="text">Text Input</option>
                        <option value="radio">Multiple Choice (Single)</option>
                        <option value="checkbox">Multiple Choice (Multiple)</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>

                <div class="options-container" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Options (comma-separated)
                    </label>
                    <input type="text" name="questions[${questionCount}][options]" 
                           placeholder="Option 1, Option 2, Option 3"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(questionDiv);
    questionCount++;
    updateQuestionNumbers();
}

function removeQuestion(button) {
    if (confirm('Are you sure you want to remove this question?')) {
        button.closest('.question-item').remove();
        updateQuestionNumbers();
    }
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((question, index) => {
        question.querySelector('h4').textContent = `Question ${index + 1}`;
    });
}

function toggleOptions(selectElement) {
    const optionsContainer = selectElement.closest('.question-item').querySelector('.options-container');
    const selectedType = selectElement.value;
    
    if (selectedType === 'text') {
        optionsContainer.style.display = 'none';
        optionsContainer.querySelector('input').required = false;
    } else {
        optionsContainer.style.display = 'block';
        optionsContainer.querySelector('input').required = true;
    }
}

// Initialize existing questions
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[name*="[type]"]').forEach(select => {
        toggleOptions(select);
    });
});
</script>