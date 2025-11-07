<?php
namespace App\Controllers;

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
            throw new \Exception('Image size too large. Maximum size is 5MB.');
        }

        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], $filepath)) {
            throw new \Exception('Failed to upload image.');
        }

        return '/uploads/' . $filename;
    }
}