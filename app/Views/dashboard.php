<?php
$title = 'Dashboard | AuthBoard';
ob_start();

// Get user stats
$userPosts = \app\Models\Post::findByUserId($user['id']);
$totalPosts = count($userPosts);

// Calculate total likes across all user's posts
$totalLikes = 0;
foreach ($userPosts as $post) {
    $totalLikes += \app\Models\Post::getLikesCount($post['id']);
}
?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- User Profile Card -->
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Welcome, <?= htmlspecialchars($user['name']) ?>! <span class="text-purple-300 text-lg">(You)</span></h2>
                <p class="text-gray-600 dark:text-gray-300">Your email: <?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Posts Card -->
        <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Posts</h3>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?= $totalPosts ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Posts you've created</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Likes Card -->
        <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Likes</h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?= $totalLikes ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Likes on all your posts</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border dark:border-dark-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        
        <?php if ($totalPosts > 0): ?>
            <div class="space-y-4">
                <?php 
                // Show latest 3 posts
                $recentPosts = array_slice($userPosts, 0, 3);
                foreach ($recentPosts as $post): 
                    $postLikes = \app\Models\Post::getLikesCount($post['id']);
                ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-dark-300 rounded-lg">
                        <div class="flex-1">
                            <p class="text-gray-800 dark:text-gray-200 text-sm truncate">
                                "<?= htmlspecialchars(mb_strimwidth($post['content'], 0, 50, '...')) ?>"
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <?= date('M j, Y \a\t g:i A', strtotime($post['created_at'])) ?>
                            </p>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?= $postLikes ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if ($totalPosts > 3): ?>
                    <div class="text-center pt-2">
                        <a href="/feed" class="text-primary hover:text-blue-600 text-sm font-medium transition-colors">
                            View all <?= $totalPosts ?> posts →
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">You haven't created any posts yet.</p>
                <a href="/feed" class="inline-block mt-2 text-primary hover:text-blue-600 font-medium transition-colors">
                    Create your first post →
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';