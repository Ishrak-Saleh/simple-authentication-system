<?php
$title = $profileUser['name'] . ' | AuthBoard';
ob_start();
?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Public Profile Header -->
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
        <div class="flex items-center space-x-6">
            <!-- Profile Picture -->
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-dark-200 shadow-lg <?= empty($profileUser['profile_picture']) ? 'bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold' : '' ?>">
                <?php if (!empty($profileUser['profile_picture'])): ?>
                    <img src="<?= htmlspecialchars($profileUser['profile_picture']) ?>" 
                         alt="Profile Picture" 
                         class="w-full h-full object-cover">
                <?php else: ?>
                    <?= strtoupper(substr($profileUser['name'], 0, 1)) ?>
                <?php endif; ?>
            </div>

            <!-- User Info -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <?= htmlspecialchars($profileUser['name']) ?>
                    <?php if ($isOwnProfile): ?>
                        <span class="text-purple-600 dark:text-purple-300 text-lg">(You)</span>
                    <?php endif; ?>
                </h1>
                
                <?php if (!empty($profileUser['bio'])): ?>
                    <p class="text-gray-600 dark:text-gray-300 mb-3 text-lg"><?= htmlspecialchars($profileUser['bio']) ?></p>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 italic mb-3">No bio yet</p>
                <?php endif; ?>
                
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Member since <?= date('M Y', strtotime($profileUser['created_at'])) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Posts Card -->
        <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Posts</h3>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?= $totalPosts ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Posts created</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Likes Card -->
        <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Likes</h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?= $totalLikes ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Likes on all posts</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <?php if ($totalPosts > 0): ?>
            <div class="space-y-4">
                <?php 
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
                <p class="text-gray-500 dark:text-gray-400">No posts yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';