<?php
// database/reset_users.php
$pdo = new PDO('mysql:host=db;dbname=camagru', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('TRUNCATE TABLE users');
echo "✅ users table truncated.\n";

