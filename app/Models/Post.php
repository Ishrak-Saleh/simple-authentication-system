<?php
namespace app\Models;

use PDO;

class Post {
    private static function connect(): PDO {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $db = getenv('DB_NAME') ?: 'authboard';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function create(int $userId, string $content, ?string $imagePath = null): int {
        $stmt = self::connect()->prepare('INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $content, $imagePath]);
        return (int)self::connect()->lastInsertId();
    }

    public static function getAllWithUsers(): array {
        $stmt = self::connect()->prepare('
            SELECT p.*, u.name as user_name, u.email as user_email 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findByUserId(int $userId): array {
        $stmt = self::connect()->prepare('
            SELECT p.*, u.name as user_name 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.user_id = ? 
            ORDER BY p.created_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function delete(int $postId, int $userId): bool {
    $stmt = self::connect()->prepare('DELETE FROM posts WHERE id = ? AND user_id = ?');
    return $stmt->execute([$postId, $userId]);
    }

    public static function findById(int $postId): ?array {
        $stmt = self::connect()->prepare('SELECT * FROM posts WHERE id = ? LIMIT 1');
        $stmt->execute([$postId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public static function update(int $postId, int $userId, string $content, ?string $imagePath = null): bool {
        if ($imagePath !== null) {
            // If we have an image path (including empty string), update both content and image_path
            $stmt = self::connect()->prepare('UPDATE posts SET content = ?, image_path = ? WHERE id = ? AND user_id = ?');
            return $stmt->execute([$content, $imagePath, $postId, $userId]);
        } else {
            // If imagePath is null, set image_path to NULL in database
            $stmt = self::connect()->prepare('UPDATE posts SET content = ?, image_path = NULL WHERE id = ? AND user_id = ?');
            return $stmt->execute([$content, $postId, $userId]);
        }
    }
}