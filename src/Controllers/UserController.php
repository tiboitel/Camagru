<?php
namespace Tiboitel\Camagru\Controllers;

use Tiboitel\Camagru\Models\User;
use Tiboitel\Camagru\Helpers\View;
use Tiboitel\Camagru\Helpers\Mail;
use Tiboitel\Camagru\Helpers\Flash;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Simple validations
            if ($password !== $confirmPassword) {
                Flash::set(FLASH::WARNING, 'Passwords do not match.');
                return View::render('user/register');
            }

            if ($this->userModel->emailExists($email)) {
                Flash::set(FLASH::ERROR, 'Email already exists.');
                return View::render('user/register');
            }

            if ($this->userModel->usernameExists($username)) {
                Flash::set(FLASH::ERROR, 'Username already exists.');
                return View::render('user/register');
            }

            $token = bin2hex(random_bytes(16));
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $success = $this->userModel->create([
                'username' => $username,
                'email' => $email,
                'password_hash' => $hash,
                'confirmation_token' => $token,
            ]);

            if ($success) {
                Mail::sendRegistrationEmail([
                    'username' => $username,
                    'email' => $email,
                    'confirmation_token' => $token
                ]);

                Flash::set(Flash::SUCCESS, 'Account created. Check your email.');
                header('Location: /login');
                exit;
            }

            Flash::set(Flash::ERROR, 'Registration failed.');
        }

        View::render('user/register',
            [
                'title' => 'Register'
            ]);
    }

    public function confirm()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) {
            http_response_code(400);
            return View::render('errors/404');
        }

        $user = $this->userModel->findByConfirmationToken($token);
        if (!$user) {
            Flash::set(Flash::ERROR, 'Invalid or expired token.');
            return View::render('user/login');
        }

        $this->userModel->confirm($user['id']);
        Flash::set(Flash::ERROR, 'Account confirmed. You can now login.');
        header('Location: /login');
        exit;
    }

    public function login()
    {
        if (!empty($_SESSION['user_id']))
        {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {

                $_SESSION['user_id'] = $user['id'];
                Flash::set(Flash::SUCCESS, 'Welcome' . $user['username'] , '!');
                header('Location: /');
                exit;
            }

            Flash::set(Flash::ERROR, 'Invalid credentials.');
        }
        View::render('user/login',
            [
                'title' => 'Login'
            ]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function profile()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $notify = isset($_POST['notify']) ? 1 : 0;

            $this->userModel->updateProfile($userId, $username, $email, $notify);
            Flash::set(Flash::SUCCESS, 'Profile updated.');
            header('Location: /profile');
            exit;
        }

        View::render('user/profile', 
            [
                'title' => 'Profile',
                'user' => $user
            ]);
    }

    public function forgot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $user = $this->userModel->findByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(16));
                $expiry = date('Y-m-d H:i:s', time() + 3600);
                $this->userModel->setResetToken($user['id'], $token, $expiry);
                Mail::sendPasswordResetEmail($user, $token);
            }
            Flash::set(Flash::SUCCESS, 'If the email exists, a reset link has been sent.');
        }

        View::render('user/forgot');
    }

    public function reset()
    {
        $token = $_GET['token'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            if ($password !== $confirm) {
                Flash::set(Flash::ERROR, 'Passwords do not match.');
                return View::render('user/reset');
            }

            $token = $_POST['token'] ?? null;
            $user = $this->userModel->findByResetToken($token);

            if (!$user || strtotime($user['reset_token_expires_at']) < time()) {
                Flash::set(Flash::ERROR, 'Invalid or expired token');
                return View::render('user/reset');
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->updatePassword($user['id'], $hash);
            Flash::set(Flash::SUCCESS, 'Password updated. You can now log in.');
            header('Location: /login');
            exit;
        }

        if (!$token) {
            http_response_code(400);
            return View::render('errors/404');
        }

        View::render('user/reset', ['token' => $token]);
    }
}

