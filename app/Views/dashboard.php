<?php
$title = 'Dashboard | AuthBoard';
ob_start();
?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
        <div class="flex items-center space-x-4 mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
                <p class="text-gray-600 dark:text-gray-300">Your email: <?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';