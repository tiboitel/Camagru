<?php
$pdo = new PDO(
    'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS')
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = file_get_contents(__DIR__ . '/migrate.sql');
$pdo->exec($sql);

echo "Migration completed.\n";

