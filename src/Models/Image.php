<?php
namespace Tiboitel\Camagru\Models;

use PDO;

class User extends Model
{
    public function paginate(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare(
            "SELECT SQL_CALC_FOUND_ROWS * FROM Images ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalStmt = $this->db->query("SELECT FOUND_ROWS() as total");
        $total = (int)$totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

        return ['data' => $data, 'total' => $total];
    }

    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS count FROM images");
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM Images WHERE id = :id");
        $stmt->execute(['id'] => $id);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return $image ?: null;
    }

    public function findByUser(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM images WHERE user_id = :user_id');
        $stmt->execute(['user_id'] => $userId);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
?>
