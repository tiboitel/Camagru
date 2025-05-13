<?php

namespace Tiboitel\Camagru\Models;

use PDO;

class Comment extends Model
{
    public function create(int $userId, int $imageId, string $content): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO comments (user_id, image_id, content) VALUES (:user_id, :image_id, :content)'
        );
        $tmt->execute([
            'user_id' => $userId,
            'image_id' => $imageId,
            'content' => $content
        ]);
    }

    public function findByImage(int $imageId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT c.*, u.username FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.image_id = :image_id
            ORDER BY c.created_at ASC'
        );
        $stmt->execute('image_id' => $imageId);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
