<?php
namespace Tiboitel\Camagru\Controllers;

use Tiboitel\Camagru\Helpers\View;
use PDO;

class UserController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
            getenv('DB_USER'),
            getenv('DB_PASS')
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function showRegisterForm()
    {
        View::render('user/register', [
            'title' => 'Register - Camagru'
        ]);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$username || !$email || !$password) {
                http_response_code(400);
                echo "All fields are required.";
                return;
            }

            // Input validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email.";
                return;
            }

            if (strlen($password) < 6) {
                echo "Password must be at least 6 characters.";
                return;
            }

            // Check if username or email exists
            $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email OR username = :username');
            $stmt->execute(['email' => $email, 'username' => $username]);
            if ($stmt->fetch()) {
                echo "Username or email already taken.";
                return;
            }

            // Insert new user
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $confirmationToken = bin2hex(random_bytes(32));

            $stmt = $this->db->prepare('
                INSERT INTO users (username, email, password_hash, confirmation_token) 
                VALUES (:username, :email, :password_hash, :confirmation_token)
            ');

            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password_hash' => $passwordHash,
                'confirmation_token' => $confirmationToken,
            ]);

            // Send confirmation email (simple mail for now)
            $confirmUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/confirm?token=' . $confirmationToken;

            $to      = $email;
            $subject = 'Testing Camagru';
            $message =  'Click to confirm: ' . $confirmUrl;
            $headers = 'From: jules.boitelle@gmail.com' . "\r\n" .
                        'Reply-To: camagru.project@gmail.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo "✅ Mail sent!";
            } else {
                echo "❌ Mail failed.";
            }

            echo "Registration successful. Please check your email.";
        }
    }

    public function confirmAccount()
    {
        $token = $_GET['token'] ?? '';

        if (!$token) {
            http_response_code(400);
            echo "Missing confirmation token.";
            return ;
        }

        $stmt = $this->db->prepare('SELECT id FROM users WHERE confirmation_token = :token');
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(400);
            echo "Invalid or experied confirmation token";
            return ;
        }

        $updateStmt = $this->db->prepare('
            UPDATE users
            SET confirmed = 1, confirmation_token = NULL
            WHERE id = :id
        ');

        $updateStmt->execute(['id' => $user['id']]);

        echo "Account succesfully confirmed. You can now log in.";
    }
}

