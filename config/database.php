<?php
declare(strict_types=1);

// Autoload dependencies (Composer)
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database configuration from .env
$host     = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port     = $_ENV['DB_PORT'] ?? '3306';
$dbName   = $_ENV['DB_NAME'] ?? 'clock_system';
$username = $_ENV['DB_USER'] ?? 'clock_user';
$password = $_ENV['DB_PASS'] ?? 'Yz3429k5$!Hz3492k5$!';
$charset  = 'utf8mb4';

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $host,
    $port,
    $dbName,
    $charset
);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    return new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Database Connection Failed: ' . $e->getMessage();
    exit;
}
