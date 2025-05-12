<?php
namespace Tiboitel\Camagru\Models;

use PDO;

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findByConfirmationToken(string $token): ?array
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE confirmation_token = :token');
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('
            INSERT INTO users (username, email, password_hash, confirmation_token) 
            VALUES (:username, :email, :password_hash, :confirmation_token)
        ');

        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'confirmation_token' => $data['confirmation_token'],
        ]);
    }

    public function confirm(int $userId): bool
    {
        $stmt = $this->db->prepare('
            UPDATE users SET confirmed = 1, confirmation_token = NULL WHERE id = :id
        ');
        return $stmt->execute(['id' => $userId]);
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetch();
    }

    public function usernameExists(string $username): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return (bool) $stmt->fetch();
    }

    public function setResetToken(int $userId, string $token, string $expiry): bool
    {
        $stmt = $this->db->prepare('
            UPDATE users
            SET reset_token = :token, reset_token_expires_at = :expiry
            WHERE id = :id
        ');
        return $stmt->execute([
            'token' => $token,
            'expiry' => $expiry,
            'id' => $userId
        ]);
    }

    public function findByResetToken(string $token): ?array
    {
        $stmt = $this->db->prepare('
            SELECT id, reset_token_expires_at FROM users WHERE reset_token = :token
        ');
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updatePassword(int $userId, string $hash): bool
    {
        $stmt = $this->db->prepare('
            UPDATE users
            SET password_hash = :hash, reset_token = NULL, reset_token_expires_at = NULL
            WHERE id = :id
        ');
        return $stmt->execute(['hash' => $hash, 'id' => $userId]);
    }

    public function updateProfile(int $id, string $username, string $email, int $notify): bool
    {
        $stmt = $this->db->prepare('
            UPDATE users
            SET username = :username, email = :email, notify_on_comment = :notify
            WHERE id = :id
        ');
        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'notify'   => $notify,
            'id'       => $id
        ]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT username, email, notify_on_comment FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

