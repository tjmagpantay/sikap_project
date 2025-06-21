<div class="p-6 bg-white border border-gray-200 rounded-lg">
    <h3 class="mb-4 text-lg font-semibold text-gray-900">Top Job Post</h3>
    
    <div class="space-y-3">
        <?php
        $locations = [
            ['code' => 'NY', 'name' => 'New York', 'width' => '100%', 'color' => 'bg-blue-500'],
            ['code' => 'MA', 'name' => 'Massachusetts', 'width' => '85%', 'color' => 'bg-blue-400'],
            ['code' => 'NH', 'name' => 'New Hampshire', 'width' => '70%', 'color' => 'bg-blue-300'],
            ['code' => 'OR', 'name' => 'Oregon', 'width' => '60%', 'color' => 'bg-blue-200']
        ];
        
        foreach ($locations as $location): 
        ?>
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-8 h-6 text-xs font-medium text-white bg-gray-600 rounded">
                    <?php echo $location['code']; ?>
                </div>
                <span class="text-sm text-gray-600"><?php echo $location['name']; ?></span>
            </div>
            <div class="flex-1 mx-4">
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="<?php echo $location['color']; ?> h-2 rounded-full" style="width: <?php echo $location['width']; ?>"></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>