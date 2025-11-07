<?php
$title = 'Feed | AuthBoard';
ob_start();
?>
<div class="feed-container">
    <h2>Social Feed</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Create Post Form -->
    <div class="create-post">
        <form method="POST" action="/feed/post" enctype="multipart/form-data" class="post-form">
            <textarea name="content" placeholder="What's on your mind?" required maxlength="500"></textarea>
            <div class="form-group">
                <label for="image">Add Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button type="submit" class="btn-primary">Post</button>
        </form>
    </div>

    <!-- Posts Feed -->
    <div class="posts-feed">
        <?php if (empty($posts)): ?>
            <p class="no-posts">No posts yet. Be the first to share something!</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <div class="post-header">
                        <strong><?= htmlspecialchars($post['user_name']) ?></strong>
                        <span class="post-date">
                            <?= date('M j, Y g:i A', strtotime($post['created_at'])) ?>
                        </span>
                    </div>
                    <div class="post-content">
                        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>
                    <?php if ($post['image_path']): ?>
                        <div class="post-image">
                            <img src="<?= htmlspecialchars($post['image_path']) ?>" 
                                 alt="Post image" 
                                 style="max-width: 100%; border-radius: 8px;">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
.feed-container {
    max-width: 600px;
    margin: 0 auto;
}

.create-post {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.post-form textarea {
    width: 100%;
    min-height: 100px;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
    font-family: inherit;
}

.form-group {
    margin: 10px 0;
}

.btn-primary {
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background: #0056b3;
}

.posts-feed {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.post-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.post-date {
    color: #666;
    font-size: 0.9em;
}

.post-content {
    margin-bottom: 15px;
    line-height: 1.5;
}

.post-image {
    margin-top: 15px;
}

.alert {
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.no-posts {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 40px;
}
</style>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';