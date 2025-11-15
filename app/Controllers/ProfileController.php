<?php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;
use app\Models\User;
use app\Models\Post;

class ProfileController extends Controller {
    public function showProfile() {
        $user = Session::get('user');
        if (!$user) {
            header('Location: /login');
            exit;
        }

        // Get fresh user data including profile picture
        $userData = User::findById($user['id']);
        if ($userData) {
            // Update session with latest data
            Session::set('user', [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'profile_picture' => $userData['profile_picture']
            ]);
            $user = Session::get('user');
        }

        $this->view('profile/index.php', ['user' => $user]);
    }

    public function updateProfilePicture() {
        $user = Session::get('user');
        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $image = $_FILES['profile_picture'] ?? null;

        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error']);
            return;
        }

        try {
            $imagePath = $this->handleImageUpload($image);
            
            // Update user profile picture in database
            User::updateProfilePicture($user['id'], $imagePath);
            
            // Update session
            Session::set('user', array_merge($user, ['profile_picture' => $imagePath]));
            
            echo json_encode([
                'success' => true, 
                'message' => 'Profile picture updated successfully!',
                'profilePicture' => $imagePath
            ]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function removeProfilePicture() {
        $user = Session::get('user');
        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        try {
            // Remove old profile picture file if exists
            if (!empty($user['profile_picture'])) {
                $oldImagePath = __DIR__ . '/../../public' . $user['profile_picture'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Update database
            User::removeProfilePicture($user['id']);
            
            // Update session
            Session::set('user', array_merge($user, ['profile_picture' => null]));
            
            echo json_encode([
                'success' => true, 
                'message' => 'Profile picture removed successfully!'
            ]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function handleImageUpload(array $image): string {
        $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB for profile pictures

        if (!in_array($image['type'], $allowedTypes)) {
            throw new \Exception('Invalid image type. Only JPG, PNG, GIF, and WebP are allowed.');
        }

        if ($image['size'] > $maxSize) {
            throw new \Exception('Image size too large. Maximum size is 5MB.');
        }

        // Generate unique filename with user context
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], $filepath)) {
            throw new \Exception('Failed to upload image.');
        }

        return '/uploads/profiles/' . $filename;
    }
}