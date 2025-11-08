<?php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;
use app\Models\Post;
use app\Models\User;

class FeedController extends Controller {
    public function index() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $posts = Post::getAllWithUsers();
        $this->view('feed/index.php', ['user' => $user, 'posts' => $posts]);
    }

    public function createPost() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $content = trim($_POST['content'] ?? '');
        $image = $_FILES['image'] ?? null;

        if (empty($content)) {
            Session::set('error', 'Post content cannot be empty');
            header('Location: /feed');
            exit;
        }

        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($image);
        }

        Post::create($user['id'], $content, $imagePath);
        
        Session::set('success', 'Post created successfully!');
        header('Location: /feed');
    }

    private function handleImageUpload(array $image): string {
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 25 * 1024 * 1024; // 25MB

        if (!in_array($image['type'], $allowedTypes)) {
            throw new \Exception('Invalid image type. Only JPG, PNG, GIF, and WebP are allowed.');
        }

        if ($image['size'] > $maxSize) {
            throw new \Exception('Image size too large. Maximum size is 25MB.');
        }

        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], $filepath)) {
            throw new \Exception('Failed to upload image.');
        }

        return '/uploads/' . $filename;
    }

    public function deletePost() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $postId = (int)($_POST['post_id'] ?? 0);
        
        if ($postId > 0) {
            // Verify the post belongs to the current user before deleting
            $post = Post::findById($postId);
            if ($post && $post['user_id'] == $user['id']) {
                Post::delete($postId, $user['id']);
                
                // Also delete the image file if it exists
                if ($post['image_path'] && file_exists(__DIR__ . '/../../public' . $post['image_path'])) {
                    unlink(__DIR__ . '/../../public' . $post['image_path']);
                }
                
                Session::set('success', 'Post deleted successfully!');
            } else {
                Session::set('error', 'You can only delete your own posts.');
            }
        }
        
        header('Location: /feed');
        exit;
    }

    public function showEditPost() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $postId = (int)($_GET['post_id'] ?? 0);
        $post = Post::findById($postId);
        
        // Verify the post belongs to the current user
        if (!$post || $post['user_id'] != $user['id']) {
            Session::set('error', 'You can only edit your own posts.');
            header('Location: /feed');
            exit;
        }

        $posts = Post::getAllWithUsers();
        $this->view('feed/index.php', [
            'user' => $user, 
            'posts' => $posts,
            'editingPost' => $post
        ]);
    }

    public function updatePost() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $postId = (int)($_POST['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        $image = $_FILES['image'] ?? null;
        
        if (empty($content)) {
            Session::set('error', 'Post content cannot be empty');
            header('Location: /feed');
            exit;
        }

        // Verify the post belongs to the current user
        $post = Post::findById($postId);
        if (!$post || $post['user_id'] != $user['id']) {
            Session::set('error', 'You can only edit your own posts.');
            header('Location: /feed');
            exit;
        }

        $imagePath = $post['image_path'];
        $oldImagePath = $post['image_path']; // Store the old path for cleanup

        // Handle image removal first
        $removeImage = ($_POST['remove_image'] ?? '') === '1';
        if ($removeImage && $post['image_path']) {
            $oldImagePath = __DIR__ . '/../../public' . $post['image_path'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $imagePath = null;
            $oldImagePath = null; // Clear old path since we already deleted it
        }

        // Handle new image upload
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $newImagePath = $this->handleImageUpload($image);
            
            // Delete old image if it exists and is different from new one
            if ($oldImagePath && $oldImagePath !== $newImagePath) {
                $fullOldPath = __DIR__ . '/../../public' . $oldImagePath;
                if (file_exists($fullOldPath)) {
                    unlink($fullOldPath);
                }
            }
            
            $imagePath = $newImagePath;
        }

        // Update the post with proper null handling
        Post::update($postId, $user['id'], $content, $imagePath);
        
        Session::set('success', 'Post updated successfully!');
        header('Location: /feed');
        exit;
    }
}