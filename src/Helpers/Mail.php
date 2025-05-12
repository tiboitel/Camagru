<?php

namespace Tiboitel\Camagru\Helpers;

class Mail
{
    private static string $from = 'no-reply@camagru.local';
    private static string $fromName = 'Camagru';

    public static function send(string $to, string $subject, string $body): bool
    {
        $headers = [
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=UTF-8",
            "From: " . self::$fromName . " <" . self::$from . ">"
        ];

        return mail($to, $subject, $body, implode("\r\n", $headers));
    }

    public static function sendRegistrationEmail(array $user): bool
    {
        $confirmUrl = self::generateUrl('/confirm?token=' . urlencode($user['confirmation_token']));
        $subject = 'Confirm your registration';
        $body = self::wrapHtml("
            <h2>Welcome to Camagru, {$user['username']}!</h2>
            <p>To activate your account, please click the link below:</p>
            <p><a href='{$confirmUrl}'>Confirm my account</a></p>
        ");

        return self::send($user['email'], $subject, $body);
    }

    public static function sendPasswordResetEmail(array $user, string $token): bool
    {
        $resetUrl = self::generateUrl('/reset?token=' . urlencode($token));
        $subject = 'Reset your Camagru password';
        $body = self::wrapHtml("
            <h2>Password Reset Request</h2>
            <p>Hello {$user['username']},</p>
            <p>To reset your password, click the link below:</p>
            <p><a href='{$resetUrl}'>Reset my password</a></p>
            <p>This link will expire in 1 hour.</p>
        ");

        return self::send($user['email'], $subject, $body);
    }

    private static function generateUrl(string $path): string
    {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return "{$protocol}://{$host}{$path}";
    }

    private static function wrapHtml(string $content): string
    {
        return "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    a { color: #2d6cdf; }
                </style>
            </head>
            <body>
                {$content}
            </body>
            </html>";
    }
}

