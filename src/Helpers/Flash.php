<?php

namespace Tiboitel\Camagru\Helpers;

class Flash
{
    const INFO = 'info';
    const SUCCESS = 'success';
    const WARNING= 'warning';
    const ERROR = 'error';

    public static function set(string $type, string $message): void
    {
        if (!in_array($type, [self::INFO, self::SUCCESS, self::WARNING, self ::ERROR]))
            throw new \InvalidArgumentException("Invalid flash type: {type}");
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }

    public static function get(): array
    {
        $flashes = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flashes;
    }

    public static function has(): bool
    {
        return !empty($_SESSION['flash']);
    }
}
?>
