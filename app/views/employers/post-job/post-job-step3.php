<?php
$existingQuestions = $screeningQuestions ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Post a New Job
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Create screening questions to filter candidates
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar with steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Settings</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 60%"></div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Info Box -->
            <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-primary">
                            Why use screening questions?
                        </h3>
                        <div class="mt-2 text-xs text-primary">
                            <p>Screening questions help you filter candidates before reviewing their full applications. Use them to ask about experience, availability, or specific requirements.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=3&job_id=<?php echo $job_id; ?>">
                <!-- Questions Container -->
                <div id="questionsContainer" class="space-y-4">
                    <?php if (!empty($existingQuestions)): ?>
                        <?php foreach ($existingQuestions as $index => $question): ?>
                            <div class="p-4 border border-gray-200 rounded-lg question-item">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="text-sm font-medium text-gray-900">Question <?php echo $index + 1; ?></h4>
                                    <button type="button" onclick="removeQuestion(this)"
                                        class="text-red-600 hover:text-red-700"> 
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                            Question Text
                                        </label>
                                        <textarea name="questions[<?php echo $index; ?>][text]" rows="2" required
                                            placeholder="Enter your question..."
                                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($question['question_text']); ?></textarea>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">
                                                Question Type
                                            </label>
                                            <select name="questions[<?php echo $index; ?>][type]"
                                                onchange="toggleOptions(this)"
                                                class="block w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                                <option value="text" <?php echo $question['question_type'] == 'text' ? 'selected' : ''; ?>>Text Input</option>
                                                <option value="radio" <?php echo $question['question_type'] == 'radio' ? 'selected' : ''; ?>>Multiple Choice (Single)</option>
                                                <option value="checkbox" <?php echo $question['question_type'] == 'checkbox' ? 'selected' : ''; ?>>Multiple Choice (Multiple)</option>
                                                <option value="dropdown" <?php echo $question['question_type'] == 'dropdown' ? 'selected' : ''; ?>>Dropdown</option>
                                            </select>
                                        </div>

                                        <div class="options-container" style="<?php echo in_array($question['question_type'], ['text']) ? 'display: none;' : ''; ?>">
                                            <label class="block mb-1 text-sm font-medium text-gray-700">
                                                Options (separated by |)
                                            </label>
                                            <input type="text" name="questions[<?php echo $index; ?>][options]"
                                                value="<?php echo htmlspecialchars($question['question_option'] ?? ''); ?>"
                                                placeholder="Option 1|Option 2|Option 3"
                                                class="block w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
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
                        class="inline-flex items-center px-4 py-2 text-sm font-medium bg-white border rounded-md text-primary border-primary hover:bg-blue-50">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Question
                    </button>
                </div>

                <!-- Sample Questions -->
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h4 class="mb-3 text-sm font-medium text-gray-800">Sample Questions</h4>
                    <div class="space-y-2 text-sm text-gray-500">
                        <p><span class="text-gray-800">Experience:</span> "How many years of experience do you have in this field?"</p>
                        <p><span class="text-gray-800">Availability:</span> "When can you start working?"</p>
                        <p><span class="text-gray-800">Salary:</span> "What is your expected salary range?"</p>
                        <p><span class="text-gray-800">Location:</span> "Are you willing to relocate for this position?"</p>
                        <p><span class="text-gray-800">Skills:</span> "Rate your proficiency in [specific skill] from 1-5."</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex gap-3">
                        <button type="submit" name="skip_step"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            Skip This Step
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            Continue to Settings
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
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
        <div class="flex items-start justify-between mb-3">
            <h4 class="text-sm font-medium text-gray-900">Question ${questionCount + 1}</h4>
            <button type="button" onclick="removeQuestion(this)" 
                    class="text-red-600 hover:text-red-700">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                    Question Text
                </label>
                <textarea name="questions[${questionCount}][text]" rows="2" required
                          placeholder="Enter your question..."
                          class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Question Type
                    </label>
                    <select name="questions[${questionCount}][type]" 
                            onchange="toggleOptions(this)"
                            class="block w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="text">Text Input</option>
                        <option value="radio">Multiple Choice (Single)</option>
                        <option value="checkbox">Multiple Choice (Multiple)</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>

                <div class="options-container" style="display: none;">
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Options (separated by |)
                    </label>
                    <input type="text" name="questions[${questionCount}][options]" 
                           placeholder="Option 1|Option 2|Option 3"
                           class="block w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
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