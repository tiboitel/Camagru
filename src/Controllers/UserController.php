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
            'title' => 'Register - Camagru',
            'old' => $_SESSION['old'] ?? []
        ]);
        unset($_SESSION['old']);
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

    public function showLoginForm()
    {
        if (!empty($_SESSION['user_id']))
        {
            $_SESSION['flash']['warning'] = 'You are already logged in.';
            header('Location: /');
            exit ;
        }

        View::render('user/login', [
            'title' => 'Login - Camagru',
            'old' => $_SESSION['old'] ?? []
        ]);
        unset($_SESSION['old']);
    }

    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $_SESSION['old'] = ['email' => $email];

        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['flash']['error'] = 'E-mail or password is incorrect or doesn\'t exist.';
            header('Location: /login');
            exit;
        }

        if (!$user['confirmed']) {
            $_SESSION['flash']['error'] = 'Please confirm your email before logging in.';
            header('Location: /login');
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['flash']['success'] = 'Logged in successfully.';
        header('Location: /');
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['flash']['success'] = 'You have been logged out.';
        header('Location: /');
        exit;
    }

    public function showForgotForm()
    {
        View::render('user/forgot', [
            'title' => 'Forgot Password - Camagru'
        ]);
    }

    public function sendResetEmail()
    {
        $email = trim($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['error'] = 'Please enter a valid email.';
            header('Location: /password/forgot');
            exit;
        }

        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $token  = bin2hex(random_bytes(32));
            $expiry = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

            $upd = $this->db->prepare('
                UPDATE users
                SET reset_token = :token, reset_token_expiry = :expiry
                WHERE id = :id
            ');
            $upd->execute([
                'token'  => $token,
                'expiry' => $expiry,
                'id'     => $user['id']
            ]);

            $link = 'http://' . $_SERVER['HTTP_HOST']
                  . '/password/reset?token=' . $token;

            mail(
                $email,
                'Camagru Password Reset',
                "Click here to reset your password:\n\n{$link}",
                'From: no-reply@camagru.local'
            );
        }

        // For security, always show same message
        $_SESSION['flash']['success'] = 'If that email exists, you’ll receive reset instructions.';
        header('Location: /login');
        exit;
    }

    public function showResetForm()
    {
        $token = $_GET['token'] ?? '';
        View::render('user/reset', [
            'title' => 'Reset Password - Camagru',
            'token' => htmlspecialchars($token)
        ]);
    }

    public function resetPassword()
    {
        $token    = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$token || strlen($password) < 6) {
            $_SESSION['flash']['error'] = 'Invalid token or password too short.';
            header("Location: /password/reset?token={$token}");
            exit;
        }

        $stmt = $this->db->prepare('
            SELECT id, reset_token_expiry
            FROM users
            WHERE reset_token = :token
        ');
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || new DateTime() > new DateTime($user['reset_token_expiry'])) {
            $_SESSION['flash']['error'] = 'Token expired or invalid.';
            header('Location: /password/forgot');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $upd  = $this->db->prepare('
            UPDATE users
            SET password_hash = :hash, reset_token = NULL, reset_token_expiry = NULL
            WHERE id = :id
        ');
        $upd->execute(['hash' => $hash, 'id' => $user['id']]);

        $_SESSION['flash']['success'] = 'Password updated — please log in.';
        header('Location: /login');
        exit;
    }

    public function showProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        // Fetch user data
        $stmt = $this->db->prepare('SELECT username, email, notify_on_comment FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch user images
        # $imgs = $this->db->prepare('SELECT id, url, created_at FROM images WHERE user_id = :id ORDER BY created_at DESC');
        # $imgs->execute(['id' => $userId]);
        # $images = $imgs->fetchAll(PDO::FETCH_ASSOC);
        $images = [];

        View::render('user/profile', [
            'title'   => 'Your Profile - Camagru',
            'user'    => $user,
            'images'  => $images
        ]);
    }

    public function updateProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $notif    = isset($_POST['notify']) ? 1 : 0;

        // Basic validation omitted for brevity...

        $upd = $this->db->prepare('
            UPDATE users
            SET username = :username, email = :email, notify_on_comment = :notif
            WHERE id = :id
        ');
        $upd->execute([
            'username' => $username,
            'email'    => $email,
            'notif'    => $notif,
            'id'       => $userId
        ]);

        if (!empty($_POST['password'])) {
            $pw = $_POST['password'];
            if (strlen($pw) >= 6) {
                $hash = password_hash($pw, PASSWORD_DEFAULT);
                $this->db->prepare('UPDATE users SET password_hash = :h WHERE id = :id')
                         ->execute(['h' => $hash, 'id' => $userId]);
            }
        }

        $_SESSION['flash']['success'] = 'Profile updated.';
        header('Location: /profile');
        exit;
    }
}

