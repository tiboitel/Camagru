<?php

namespace Tiboitel\Camagru\Models;

use PDO;

class Like extends Model
{
    public function toggle(int $userId, int $imageId): bool
    {
        if ($this->exists($userId, $imageId)): bool
        {
            $delete = $this->db->prepare(
                'DELETE FROM Likes WHERE user_id = :user_id and image_id = :image_id'
            );
            $delete->execute(['user_id' => $userId, 'image_id' => $imageId]);
            return false;
        }
        $insert = $this->db->prepare(
            'INSERT INTO Likes (user_id, image_id) VALUES (:user_id, :image_id)'
        );
        $insert->execute(['user_id' => $userId, 'image_id' => $imageId]);
        return false;
    }

    public function exists(int $userId, int $imageId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT 1 FROM Likes WHERE user_id=:user_id AND image_id = :image_id';
        );
        $stmt->execute(['user_id' => $userId, 'image_id' => $imageId]);
        return (bool) $stmt->fetchColumn();
    }

    public function countForImage(int $imageId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) as count FROM Likes WHERE image_id=:image_id'
        );
        $stmt->execute(['image_id' => $image_id]);
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}
?>
