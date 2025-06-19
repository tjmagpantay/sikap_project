<?php
// filepath: app/views/jobseekers/job-application/apply-job-step2.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-4xl sm:px-6 lg:px-8">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Apply for Job</h1>
            <span class="text-sm text-gray-600">Step 2 of 4</span>
        </div>
        
        <!-- Progress indicators -->
        <div class="flex items-center">
            <div class="flex items-center text-green-600">
                <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <span class="ml-2 text-sm font-medium">Personal Info & Documents</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-green-600 rounded"></div>
            
            <div class="flex items-center text-blue-600">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
                    <span class="text-sm font-medium text-white">2</span>
                </div>
                <span class="ml-2 text-sm font-medium">Screening Questions</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded"></div>
            
            <div class="flex items-center text-gray-400">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                    <span class="text-sm font-medium">3</span>
                </div>
                <span class="ml-2 text-sm font-medium">Eligibility</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded"></div>
            
            <div class="flex items-center text-gray-400">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                    <span class="text-sm font-medium">4</span>
                </div>
                <span class="ml-2 text-sm font-medium">Review & Submit</span>
            </div>
        </div>
    </div>

    <!-- Job Info Card -->
    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h2 class="text-lg font-semibold text-blue-900"><?php echo htmlspecialchars($job['job_title']); ?></h2>
        <p class="text-blue-700">
            <?php 
            $companyName = $job['company_name'] ?? 
                          ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
            echo htmlspecialchars($companyName); 
            ?>
        </p>
    </div>

    <!-- Messages -->
    <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800"><?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
        <!-- Screening Questions -->
        <div class="bg-white shadow rounded-lg p-6">
            <?php if (empty($screeningQuestions)): ?>
                <!-- No Screening Questions -->
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Screening Questions</h3>
                    <p class="text-gray-600">This employer hasn't added any screening questions for this position.</p>
                </div>
            <?php else: ?>
                <!-- Has Screening Questions -->
                <h3 class="text-lg font-medium text-gray-900 mb-6">Screening Questions</h3>
                <p class="text-sm text-gray-600 mb-6">Please answer the following questions from the employer:</p>
                
                <div class="space-y-6">
                    <?php foreach ($screeningQuestions as $index => $question): ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-900 mb-3">
                                Question <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question_text']); ?>
                                <?php if ($question['is_required']): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>
                            
                            <?php 
                            $existingAnswer = $answersArray[$question['question_id']] ?? '';
                            $questionName = 'question_' . $question['question_id'];
                            ?>
                            
                            <?php if ($question['question_type'] === 'text'): ?>
                                <input type="text" 
                                       name="<?php echo $questionName; ?>" 
                                       value="<?php echo htmlspecialchars($existingAnswer); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       <?php echo $question['is_required'] ? 'required' : ''; ?>>
                                       
                            <?php elseif ($question['question_type'] === 'textarea'): ?>
                                <textarea name="<?php echo $questionName; ?>" 
                                          rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          <?php echo $question['is_required'] ? 'required' : ''; ?>><?php echo htmlspecialchars($existingAnswer); ?></textarea>
                                          
                            <?php elseif ($question['question_type'] === 'multiple_choice' && !empty($question['question_option'])): ?>
                                <?php 
                                $options = explode('|', $question['question_option']);
                                ?>
                                <div class="space-y-2">
                                    <?php foreach ($options as $option): ?>
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="<?php echo $questionName; ?>" 
                                                   value="<?php echo htmlspecialchars(trim($option)); ?>"
                                                   <?php echo ($existingAnswer === trim($option)) ? 'checked' : ''; ?>
                                                   class="text-blue-600 focus:ring-blue-500"
                                                   <?php echo $question['is_required'] ? 'required' : ''; ?>>
                                            <span class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars(trim($option)); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                                
                            <?php elseif ($question['question_type'] === 'yes_no'): ?>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="<?php echo $questionName; ?>" 
                                               value="Yes"
                                               <?php echo ($existingAnswer === 'Yes') ? 'checked' : ''; ?>
                                               class="text-blue-600 focus:ring-blue-500"
                                               <?php echo $question['is_required'] ? 'required' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Yes</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="<?php echo $questionName; ?>" 
                                               value="No"
                                               <?php echo ($existingAnswer === 'No') ? 'checked' : ''; ?>
                                               class="text-blue-600 focus:ring-blue-500"
                                               <?php echo $question['is_required'] ? 'required' : ''; ?>>
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
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                <i class="fas fa-arrow-left mr-1"></i> Back to Step 1
            </a>
            
            <button type="submit" 
                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                Continue to Step 3 <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </form>
</div>