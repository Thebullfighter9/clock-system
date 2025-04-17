// config/database.php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $_ENV['DB_HOST'] ?? '127.0.0.1',
    $_ENV['DB_PORT'] ?? '3306',
    $_ENV['DB_NAME'] ?? 'clock_system'
);

return new PDO($dsn, $_ENV['DB_USER'] ?? 'root', $_ENV['DB_PASS'] ?? '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
