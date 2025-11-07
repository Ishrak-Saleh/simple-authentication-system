<?php
$title = 'Dashboard | AuthBoard';
ob_start();
?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
        <p class="text-gray-600 dark:text-gray-300">Your email: <?= htmlspecialchars($user['email']) ?></p>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';