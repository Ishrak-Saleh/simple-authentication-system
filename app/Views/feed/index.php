<?php
$title = 'Feed | AuthBoard';
ob_start();
?>
<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-dark-200 rounded-lg shadow-sm border border-dark-100 p-4">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <button onclick="document.getElementById('postModal').classList.remove('hidden')" 
                    class="flex-1 bg-dark-100 text-gray-400 text-left px-4 py-3 rounded-full hover:bg-dark-300 transition-colors">
                What's on your mind, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>?
            </button>
        </div>
    </div>

    <!-- Posts Feed -->
    <div class="space-y-4">
        <?php if (empty($posts)): ?>
            <div class="bg-dark-200 rounded-lg shadow-sm border border-dark-100 p-8 text-center">
                <div class="text-gray-500 mb-2">
                    <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-300 mb-2">No posts yet</h3>
                <p class="text-gray-400">Be the first to share something with the community!</p>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="bg-dark-200 rounded-lg shadow-sm border border-dark-100 overflow-hidden">
                    <!-- Post Header -->
                    <div class="p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                <?= strtoupper(substr($post['user_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white"><?= htmlspecialchars($post['user_name']) ?></h3>
                                <p class="text-xs text-gray-400">
                                    <?= date('M j, Y \a\t g:i A', strtotime($post['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="px-4 pb-3">
                        <p class="text-gray-200 whitespace-pre-line"><?= htmlspecialchars($post['content']) ?></p>
                    </div>

                    <?php if ($post['image_path']): ?>
                    <div class="border-t border-dark-100">
                        <div class="flex justify-center bg-dark-300 p-4">
                            <img src="<?= htmlspecialchars($post['image_path']) ?>" 
                                 alt="Post image" 
                                 class="max-w-full max-h-96 object-contain rounded-lg shadow-md"
                                 style="max-width: min(100%, 600px);">
                        </div>
                    </div>
                    <?php endif; ?>


                    <div class="px-4 py-3 border-t border-dark-100">
                        <div class="flex space-x-4 text-gray-400">
                            <button class="flex items-center space-x-1 hover:text-primary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Like</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-primary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.00M16 12h.00M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>Comment</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div id="postModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-dark-200 rounded-lg w-full max-w-md">
        <div class="p-4 border-b border-dark-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Create Post</h3>
                <button onclick="document.getElementById('postModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="/feed/post" enctype="multipart/form-data" class="p-4 space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </div>
                <div>
                    <h4 class="font-semibold text-white"><?= htmlspecialchars($user['name']) ?></h4>
                </div>
            </div>
            
            <textarea name="content" 
                      placeholder="What's on your mind?" 
                      class="w-full h-32 border-0 focus:ring-0 resize-none text-white bg-dark-200 placeholder-gray-400"
                      required></textarea>
            
            <div class="border-t border-dark-100 pt-4">
                <label class="flex items-center space-x-2 text-gray-400 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Add Photo</span>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                </label>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-100">
                <button type="button" 
                        onclick="document.getElementById('postModal').classList.add('hidden')" 
                        class="px-4 py-2 text-gray-400 hover:text-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-primary text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors font-medium">
                    Post
                </button>
            </div>
        </form>
    </div>
</div>

<script>
//Image preview and validation
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 25 * 1024 * 1024; // 25MB
        if (file.size > maxSize) {
            alert('Image size too large. Maximum size is 25MB.');
            e.target.value = '';
        }
    }
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';