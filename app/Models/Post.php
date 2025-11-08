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

    public static function getAllWithUsersAndLikes(int $currentUserId): array {
        $stmt = self::connect()->prepare('
            SELECT p.*, 
                   u.name as user_name, 
                   u.email as user_email,
                   COUNT(pl.id) as like_count,
                   EXISTS(
                       SELECT 1 FROM post_likes 
                       WHERE post_id = p.id AND user_id = ?
                   ) as is_liked
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            LEFT JOIN post_likes pl ON p.id = pl.post_id
            GROUP BY p.id
            ORDER BY p.created_at DESC
        ');
        $stmt->execute([$currentUserId]);
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
            $stmt = self::connect()->prepare('UPDATE posts SET content = ?, image_path = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?');
            return $stmt->execute([$content, $imagePath, $postId, $userId]);
        } else {
            $stmt = self::connect()->prepare('UPDATE posts SET content = ?, image_path = NULL, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?');
            return $stmt->execute([$content, $postId, $userId]);
        }
    }

    // Like functionality methods
    public static function like(int $postId, int $userId): bool {
        $stmt = self::connect()->prepare('
            INSERT IGNORE INTO post_likes (post_id, user_id) 
            VALUES (?, ?)
        ');
        return $stmt->execute([$postId, $userId]);
    }

    public static function unlike(int $postId, int $userId): bool {
        $stmt = self::connect()->prepare('
            DELETE FROM post_likes 
            WHERE post_id = ? AND user_id = ?
        ');
        return $stmt->execute([$postId, $userId]);
    }

    public static function getLikesCount(int $postId): int {
        $stmt = self::connect()->prepare('
            SELECT COUNT(*) as like_count 
            FROM post_likes 
            WHERE post_id = ?
        ');
        $stmt->execute([$postId]);
        $result = $stmt->fetch();
        return (int)($result['like_count'] ?? 0);
    }

    public static function isLikedByUser(int $postId, int $userId): bool {
        $stmt = self::connect()->prepare('
            SELECT 1 
            FROM post_likes 
            WHERE post_id = ? AND user_id = ? 
            LIMIT 1
        ');
        $stmt->execute([$postId, $userId]);
        return (bool)$stmt->fetch();
    }
}