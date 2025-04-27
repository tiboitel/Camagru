<?php
$pdo = new PDO(
    'mysql:host=db;dbname=camagru','root', 'root'
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = file_get_contents(__DIR__ . '/migrate.sql');
$pdo->exec($sql);

echo "Migration completed.\n";

