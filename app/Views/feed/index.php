<?php
$title = 'Feed | AuthBoard';
ob_start();
?>
<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-dark-200 rounded-lg shadow-sm border border-dark-100 p-4">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <button onclick="document.getElementById('postModal').classList.remove('hidden')" 
                    class="flex-1 bg-dark-100 text-gray-400 text-left px-4 py-3 rounded-full hover:bg-dark-300 transition-colors">
                What's on your mind, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>?
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

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
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold <?= $post['user_id'] == $user['id'] ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 'bg-gradient-to-r from-blue-500 to-green-500' ?>">
                                    <?= strtoupper(substr($post['user_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white <?= $post['user_id'] == $user['id'] ? 'text-pink-400' : '' ?>">
                                        <?= htmlspecialchars($post['user_name']) ?>
                                        <?php if ($post['user_id'] == $user['id']): ?>
                                            <span class="text-xs text-pink-300 ml-1">(You)</span>
                                        <?php endif; ?>
                                    </h3>
                                    <p class="text-xs text-gray-400">
                                        <?= date('M j, Y \a\t g:i A', strtotime($post['created_at'])) ?>
                                        <?php if ($post['updated_at'] && $post['updated_at'] !== $post['created_at']): ?>
                                            <span class="text-gray-400 text-xs ml-1">• Edited</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Edit and Delete Buttons - Only show for post owner -->
                            <?php if ($post['user_id'] == $user['id']): ?>
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <button onclick="openEditModal(<?= $post['id'] ?>, `<?= addslashes($post['content']) ?>`, `<?= $post['image_path'] ?? '' ?>`)"
                                        class="text-gray-400 hover:text-green-500 transition-colors p-1 rounded-full hover:bg-dark-100"
                                        title="Edit post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                
                                <!-- Delete Button -->
                                <form method="POST" action="/feed/delete" class="delete-form">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                            class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-dark-100"
                                            title="Delete post">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <?php endif; ?>
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
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Create Post Modal -->
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
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </div>
                <div>
                    <h4 class="font-semibold text-white"><?= htmlspecialchars($user['name']) ?> <span class="text-pink-400 text-sm">(You)</span></h4>
                </div>
            </div>
            
            <textarea name="content" 
                      placeholder="What's on your mind?" 
                      class="w-full h-32 border-0 focus:ring-0 resize-none text-white bg-dark-200 placeholder-gray-400"
                      required></textarea>
            
            <div class="border-t border-dark-100 pt-4">
                <label class="flex items-center space-x-2 text-gray-400 cursor-pointer" for="image">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="fileText">Add Photo</span>
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

<!-- Edit Post Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-dark-200 rounded-lg w-full max-w-md">
        <div class="p-4 border-b border-dark-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Edit Post</h3>
                <button onclick="closeEditModal()" 
                        class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="/feed/update" enctype="multipart/form-data" class="p-4 space-y-4">
            <input type="hidden" name="post_id" id="editPostId">
            
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </div>
                <div>
                    <h4 class="font-semibold text-white"><?= htmlspecialchars($user['name']) ?> <span class="text-pink-400 text-sm">(You)</span></h4>
                </div>
            </div>
            
            <textarea name="content" 
                      id="editContent"
                      placeholder="What's on your mind?" 
                      class="w-full h-32 border-0 focus:ring-0 resize-none text-white bg-dark-200 placeholder-gray-400"
                      required></textarea>
            
            <!-- Current Image Preview -->
            <div id="currentImageContainer" class="hidden">
                <p class="text-gray-400 text-sm mb-2">Current Image:</p>
                <div class="flex items-center space-x-3">
                    <img id="currentImagePreview" class="w-20 h-20 object-cover rounded-lg">
                    <div>
                        <button type="button" onclick="removeCurrentImage()" class="text-red-500 hover:text-red-400 text-sm">
                            Remove Image
                        </button>
                        <input type="hidden" name="remove_image" id="removeImage" value="0">
                    </div>
                </div>
            </div>
            
            <div class="border-t border-dark-100 pt-4">
                <label class="flex items-center space-x-2 text-gray-400 cursor-pointer" for="editImage">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="editFileText">Change Photo</span>
                    <input type="file" name="image" id="editImage" accept="image/*" class="hidden">
                </label>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-100">
                <button type="button" 
                        onclick="closeEditModal()" 
                        class="px-4 py-2 text-gray-400 hover:text-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-primary text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors font-medium">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Create Post Modal - Image validation and file name display
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileText = document.getElementById('fileText');
    
    if (file) {
        const maxSize = 25 * 1024 * 1024; // 25MB
        
        // Show file name
        fileText.textContent = file.name;
        fileText.classList.add('text-primary'); // Highlight the file name
        
        // Size validation
        if (file.size > maxSize) {
            alert('Image size too large. Maximum size is 25MB.');
            e.target.value = '';
            fileText.textContent = 'Add Photo';
            fileText.classList.remove('text-primary');
        }
        
    } else {
        // Reset if no file selected
        fileText.textContent = 'Add Photo';
        fileText.classList.remove('text-primary');
    }
});

// Reset file text when modal is closed
document.querySelector('button[type="button"]').addEventListener('click', function() {
    document.getElementById('fileText').textContent = 'Add Photo';
    document.getElementById('fileText').classList.remove('text-primary');
});

// Edit Modal Functions
function openEditModal(postId, content, imagePath) {
    document.getElementById('editPostId').value = postId;
    document.getElementById('editContent').value = content.replace(/\\'/g, "'");
    
    // Handle current image
    const currentImageContainer = document.getElementById('currentImageContainer');
    const currentImagePreview = document.getElementById('currentImagePreview');
    const removeImageInput = document.getElementById('removeImage');
    
    if (imagePath) {
        currentImagePreview.src = imagePath;
        currentImageContainer.classList.remove('hidden');
        removeImageInput.value = '0';
    } else {
        currentImageContainer.classList.add('hidden');
        removeImageInput.value = '0';
    }
    
    // Reset file input
    document.getElementById('editImage').value = '';
    document.getElementById('editFileText').textContent = 'Change Photo';
    document.getElementById('editFileText').classList.remove('text-primary');
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function removeCurrentImage() {
    document.getElementById('currentImageContainer').classList.add('hidden');
    document.getElementById('removeImage').value = '1';
}

// Edit image file handling
document.getElementById('editImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileText = document.getElementById('editFileText');
    
    if (file) {
        const maxSize = 25 * 1024 * 1024; // 25MB
        
        // Show file name
        fileText.textContent = file.name;
        fileText.classList.add('text-primary');
        
        // Size validation
        if (file.size > maxSize) {
            alert('Image size too large. Maximum size is 25MB.');
            e.target.value = '';
            fileText.textContent = 'Change Photo';
            fileText.classList.remove('text-primary');
        }
    } else {
        fileText.textContent = 'Change Photo';
        fileText.classList.remove('text-primary');
    }
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';