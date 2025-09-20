<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">

        <!-- Job Info Card -->
        <div class="p-6 mb-4 border rounded-lg bg-blue-50">
            <div class="flex items-start space-x-4">
                <!-- Business Logo -->
                <div class="flex items-center justify-center w-12 h-12 overflow-hidden border-2 rounded-lg border-primary">
                    <?php if (!empty($job['business_logo'])): ?>
                        <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo"
                            class="object-cover w-full h-full">
                    <?php else: ?>
                        <i class="text-xl text-blue-500 fas fa-building"></i>
                    <?php endif; ?>
                </div>

                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-primary"><?php echo htmlspecialchars($job['job_title']); ?></h2>
                    <p class="text-sm text-gray-500">
                        <?php
                        $companyName = $job['company_name'] ??
                            ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                        echo htmlspecialchars($companyName);
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full hover:bg-green-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Personal Info</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Screening</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Eligibility</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=4&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 50%"></div>
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

            <form class="space-y-6" method="POST">
                <!-- Screening Questions -->
                <div>
                    <?php if (empty($screeningQuestions)): ?>
                        <!-- No Screening Questions -->
                        <div class="p-8 text-center rounded-lg bg-gray-50">
                            <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mb-2 font-medium text-gray-900 text-md">No Screening Questions</h3>
                            <p class="text-xs text-gray-600">This employer hasn't added any screening questions for this position.</p>
                        </div>
                    <?php else: ?>
                        <!-- Has Screening Questions -->
                        <label class="block mb-4 font-medium text-md text-primary">
                            Screening Questions
                        </label>
                        <p class="mb-6 text-sm text-gray-600">Please answer the following questions from the employer:</p>

                        <div class="space-y-6">
                            <?php foreach ($screeningQuestions as $index => $question): ?>
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <label class="block mb-3 text-sm font-medium text-gray-900">
                                        Question <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question_text']); ?>
                                    </label>

                                    <?php
                                    $existingAnswer = $answersArray[$question['question_id']] ?? '';
                                    $questionName = 'question_' . $question['question_id'];
                                    ?>

                                    <?php if ($question['question_type'] === 'text'): ?>
                                        <input type="text"
                                            name="<?php echo $questionName; ?>"
                                            value="<?php echo htmlspecialchars($existingAnswer); ?>"
                                            class="w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">

                                    <?php elseif ($question['question_type'] === 'textarea'): ?>
                                        <textarea name="<?php echo $questionName; ?>"
                                            rows="4"
                                            class="w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"><?php echo htmlspecialchars($existingAnswer); ?></textarea>

                                    <?php elseif (in_array($question['question_type'], ['radio', 'multiple_choice']) && !empty($question['question_option'])): ?>
                                        <?php
                                        // Handle both comma and pipe separators
                                        if (strpos($question['question_option'], '|') !== false) {
                                            $options = explode('|', $question['question_option']);
                                        } else {
                                            $options = explode(',', $question['question_option']);
                                        }
                                        ?>
                                        <div class="space-y-2">
                                            <?php foreach ($options as $option): ?>
                                                <label class="flex items-center p-2 transition-colors rounded-md hover:bg-gray-100">
                                                    <input type="radio"
                                                        name="<?php echo $questionName; ?>"
                                                        value="<?php echo htmlspecialchars(trim($option)); ?>"
                                                        <?php echo ($existingAnswer === trim($option)) ? 'checked' : ''; ?>
                                                        class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                                    <span class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars(trim($option)); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>

                                    <?php elseif ($question['question_type'] === 'checkbox' && !empty($question['question_option'])): ?>
                                        <?php
                                        // Handle both comma and pipe separators
                                        if (strpos($question['question_option'], '|') !== false) {
                                            $options = explode('|', $question['question_option']);
                                        } else {
                                            $options = explode(',', $question['question_option']);
                                        }
                                        $existingAnswers = explode(',', $existingAnswer); // For multiple selections
                                        ?>
                                        <div class="space-y-2">
                                            <?php foreach ($options as $option): ?>
                                                <label class="flex items-center p-2 transition-colors rounded-md hover:bg-gray-100">
                                                    <input type="checkbox"
                                                        name="<?php echo $questionName; ?>[]"
                                                        value="<?php echo htmlspecialchars(trim($option)); ?>"
                                                        <?php echo in_array(trim($option), $existingAnswers) ? 'checked' : ''; ?>
                                                        class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                                    <span class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars(trim($option)); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>

                                    <?php elseif ($question['question_type'] === 'dropdown' && !empty($question['question_option'])): ?>
                                        <?php
                                        // Handle both comma and pipe separators
                                        if (strpos($question['question_option'], '|') !== false) {
                                            $options = explode('|', $question['question_option']);
                                        } else {
                                            $options = explode(',', $question['question_option']);
                                        }
                                        ?>
                                        <select name="<?php echo $questionName; ?>"
                                            class="w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                            <option value="">Select an option...</option>
                                            <?php foreach ($options as $option): ?>
                                                <option value="<?php echo htmlspecialchars(trim($option)); ?>"
                                                    <?php echo ($existingAnswer === trim($option)) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars(trim($option)); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    <?php elseif ($question['question_type'] === 'yes_no'): ?>
                                        <div class="space-y-2">
                                            <label class="flex items-center p-2 transition-colors rounded-md hover:bg-gray-100">
                                                <input type="radio"
                                                    name="<?php echo $questionName; ?>"
                                                    value="Yes"
                                                    <?php echo ($existingAnswer === 'Yes') ? 'checked' : ''; ?>
                                                    class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                                <span class="ml-2 text-sm text-gray-700">Yes</span>
                                            </label>
                                            <label class="flex items-center p-2 transition-colors rounded-md hover:bg-gray-100">
                                                <input type="radio"
                                                    name="<?php echo $questionName; ?>"
                                                    value="No"
                                                    <?php echo ($existingAnswer === 'No') ? 'checked' : ''; ?>
                                                    class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                                <span class="ml-2 text-sm text-gray-700">No</span>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Step 1
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        Continue to Step 3
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>