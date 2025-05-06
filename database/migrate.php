<?php
$pdo = new PDO(
    'mysql:host=db;dbname=camagru','root', 'root'
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = file_get_contents(__DIR__ . '/migrate.sql');
// Destroy the users table if it's already exists.
$pdo->exec('DROP TABLE IF EXISTS users;');
$pdo->exec($sql);

echo "Migration completed.\n";

