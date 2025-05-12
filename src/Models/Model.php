<?php

namespace Tiboitel\Camagru\Models;

use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct(PDO $db = null)
    {
        $this->db = $db ?? new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
            getenv('DB_USER'),
            getenv('DB_PASS'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]  
        );
    }
}
?>
