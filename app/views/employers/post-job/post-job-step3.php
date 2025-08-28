<?php
$existingQuestions = $screeningQuestions ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="flex flex-col items-center min-h-screen py-12 bg-gray-50">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold font-inter text-primary">Post a New Job</h1>
            <p class="mt-2 text-sm font-inter text-primary">Step 3 of 5 – Screening Questions</p>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center justify-between mb-10">
            <?php
            $steps = [
                'Job Details',
                'Attachments',
                'Questions',
                'Settings',
                'Review'
            ];
            $currentStep = 3;
            foreach ($steps as $i => $label): ?>
                <div class="flex flex-col items-center flex-1 min-w-[100px] shrink-0">
                    <div class="w-12 h-2 rounded <?php echo ($i + 1) === $currentStep ? 'bg-primary' : 'bg-gray-300'; ?>"></div>
                    <span class="font-inter text-xs mt-2 <?php echo ($i + 1) === $currentStep ? 'font-normal text-primary' : 'text-gray-400'; ?>">
                        <?php echo $label; ?>
                    </span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                    <div class="flex-1 h-3 bg-gray-200"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Success Messages -->
        <?php if (!empty($success)): ?>
            <div class="p-4 mt-6 mb-4 border border-blue-200 rounded-md bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="text-primary fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
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

        <!-- Info Box -->
        <div class="p-4 mb-6 border border-blue-200 rounded-lg bg-blue-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="text-primary fas fa-lightbulb"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-primary">
                        Why use screening questions?
                    </h3>
                    <div class="mt-2 text-sm text-primary">
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
                                    <i class="text-sm fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">
                                        Question Text
                                    </label>
                                    <textarea name="questions[<?php echo $index; ?>][text]" rows="2" required
                                        placeholder="Enter your question..."
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($question['question_text']); ?></textarea>
                                </div>

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                            Question Type
                                        </label>
                                        <select name="questions[<?php echo $index; ?>][type]"
                                            onchange="toggleOptions(this)"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                            <option value="text" <?php echo $question['question_type'] == 'text' ? 'selected' : ''; ?>>Text Input</option>
                                            <option value="radio" <?php echo $question['question_type'] == 'radio' ? 'selected' : ''; ?>>Multiple Choice (Single)</option>
                                            <option value="checkbox" <?php echo $question['question_type'] == 'checkbox' ? 'selected' : ''; ?>>Multiple Choice (Multiple)</option>
                                            <option value="dropdown" <?php echo $question['question_type'] == 'dropdown' ? 'selected' : ''; ?>>Dropdown</option>
                                        </select>
                                    </div>

                                    <div class="options-container" style="<?php echo in_array($question['question_type'], ['text']) ? 'display: none;' : ''; ?>">
                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                            Options (comma-separated)
                                        </label>
                                        <input type="text" name="questions[<?php echo $index; ?>][options]"
                                            value="<?php echo htmlspecialchars($question['question_option'] ?? ''); ?>"
                                            placeholder="Option 1, Option 2, Option 3"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
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
                    <i class="mr-2 fas fa-plus"></i>
                    Add Question
                </button>
            </div>

            <!-- Sample Questions -->
            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                <h4 class="mb-3 text-sm font-medium text-gray-900">Sample Questions</h4>
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

                <div class="flex gap-2 space-x-3">
                    <button type="submit" name="skip_step"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip This Step
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md bg-primary hover:bg-blue-700">
                        Continue to Settings
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
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
                <i class="text-sm fas fa-trash"></i>
            </button>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                    Question Text
                </label>
                <textarea name="questions[${questionCount}][text]" rows="2" required
                          placeholder="Enter your question..."
                          class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Question Type
                    </label>
                    <select name="questions[${questionCount}][type]" 
                            onchange="toggleOptions(this)"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                        <option value="text">Text Input</option>
                        <option value="radio">Multiple Choice (Single)</option>
                        <option value="checkbox">Multiple Choice (Multiple)</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>

                <div class="options-container" style="display: none;">
                    <label class="block mb-1 text-sm font-medium text-gray-700">
                        Options (comma-separated)
                    </label>
                    <input type="text" name="questions[${questionCount}][options]" 
                           placeholder="Option 1, Option 2, Option 3"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
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