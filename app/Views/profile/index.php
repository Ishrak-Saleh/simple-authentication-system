<?php
$title = 'Profile | AuthBoard';
ob_start();

// Get user stats using fully qualified namespace
$userPosts = \app\Models\Post::findByUserId($user['id']);
$totalPosts = count($userPosts);

// Calculate total likes across all user's posts
$totalLikes = 0;
foreach ($userPosts as $post) {
    $totalLikes += \app\Models\Post::getLikesCount($post['id']);
}
?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Profile Header Card -->
    <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
        <div class="flex items-center space-x-6">
            <!-- Profile Picture -->
            <div class="relative">
                <div id="profileAvatar" class="w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-dark-200 shadow-lg <?= empty($user['profile_picture']) ? 'bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold' : '' ?>">
                    <?php if (!empty($user['profile_picture'])): ?>
                        <img src="<?= htmlspecialchars($user['profile_picture']) ?>" 
                             alt="Profile Picture" 
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
                
                <!-- Profile Picture Upload Button -->
                <button onclick="document.getElementById('profilePictureInput').click()"
                        class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg hover:bg-blue-600 transition-colors"
                        title="Change profile picture">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>

                <!-- Remove Picture Button (only show if has picture) -->
                <?php if (!empty($user['profile_picture'])): ?>
                <button onclick="removeProfilePicture()"
                        class="absolute top-0 right-0 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-colors"
                        title="Remove profile picture">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                <?php endif; ?>

                <!-- Hidden File Input -->
                <input type="file" 
                       id="profilePictureInput" 
                       accept="image/*" 
                       class="hidden" 
                       onchange="uploadProfilePicture(this.files[0])">
            </div>

            <!-- User Info -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <?= htmlspecialchars($user['name']) ?>
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mb-1">
                    <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Member since <?= date('M Y') ?>
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
        <div class="bg-white dark:bg-dark-200 rounded-lg shadow-sm border border-gray-200 dark:border-dark-100 p-6">
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
                <p class="text-gray-500 dark:text-gray-400">You haven't created any posts yet.</p>
                <a href="/feed" class="inline-block mt-2 text-primary hover:text-blue-600 font-medium transition-colors">
                    Create your first post →
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-dark-200 rounded-lg p-6 flex items-center space-x-3">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
        <span class="text-gray-900 dark:text-white">Uploading...</span>
    </div>
</div>

<script>
function uploadProfilePicture(file) {
    if (!file) return;

    // Validate file type and size
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!allowedTypes.includes(file.type)) {
        alert('Invalid image type. Only JPG, PNG, GIF, and WebP are allowed.');
        return;
    }

    if (file.size > maxSize) {
        alert('Image size too large. Maximum size is 5MB.');
        return;
    }

    // Show loading spinner
    document.getElementById('loadingSpinner').classList.remove('hidden');

    const formData = new FormData();
    formData.append('profile_picture', file);

    fetch('/profile/picture/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingSpinner').classList.add('hidden');
        
        if (data.success) {
            // Update profile picture display
            const profileAvatar = document.getElementById('profileAvatar');
            profileAvatar.innerHTML = `<img src="${data.profilePicture}" alt="Profile Picture" class="w-full h-full object-cover">`;
            profileAvatar.className = 'w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-dark-200 shadow-lg';
            
            // Show remove button if it doesn't exist
            if (!document.querySelector('[onclick="removeProfilePicture()"]')) {
                const removeButton = document.createElement('button');
                removeButton.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                `;
                removeButton.setAttribute('onclick', 'removeProfilePicture()');
                removeButton.setAttribute('class', 'absolute top-0 right-0 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-colors');
                removeButton.setAttribute('title', 'Remove profile picture');
                profileAvatar.parentElement.appendChild(removeButton);
            }

            // Update avatar in header (if exists)
            const headerAvatar = document.querySelector('header .w-8.h-8');
            if (headerAvatar) {
                headerAvatar.outerHTML = `<img src="${data.profilePicture}" alt="Profile" class="w-8 h-8 rounded-full object-cover">`;
            }

            alert(data.message);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        document.getElementById('loadingSpinner').classList.add('hidden');
        console.error('Error:', error);
        alert('An error occurred while uploading the image.');
    });
}

function removeProfilePicture() {
    if (!confirm('Are you sure you want to remove your profile picture?')) {
        return;
    }

    document.getElementById('loadingSpinner').classList.remove('hidden');

    fetch('/profile/picture/remove', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingSpinner').classList.add('hidden');
        
        if (data.success) {
            // Reset to initial avatar
            const profileAvatar = document.getElementById('profileAvatar');
            const userInitial = '<?= strtoupper(substr($user['name'], 0, 1)) ?>';
            profileAvatar.innerHTML = userInitial;
            profileAvatar.className = 'w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-dark-200 shadow-lg bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold';

            // Remove remove button
            const removeButton = document.querySelector('[onclick="removeProfilePicture()"]');
            if (removeButton) {
                removeButton.remove();
            }

            // Update header avatar
            const headerAvatar = document.querySelector('header img[alt="Profile"]');
            if (headerAvatar) {
                headerAvatar.outerHTML = `<div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">${userInitial}</div>`;
            }

            alert(data.message);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        document.getElementById('loadingSpinner').classList.add('hidden');
        console.error('Error:', error);
        alert('An error occurred while removing the profile picture.');
    });
}
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';