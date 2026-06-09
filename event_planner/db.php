<?php
/**
 * EliteEvents Secure Connection Engine
 * Utilizes PDO object instances rather than legacy MySQLi methods.
 */

$host    = 'localhost';
$db      = 'event_planner';
$user    = 'root'; // Default XAMPP username configuration
$pass    = '';     // Default XAMPP password configuration (blank)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // Instantiation of the primary data connection engine token
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Terminate process execution if connection configuration is wrong
     die("System Alert: Database connection failed securely -> " . $e->getMessage());
}
?>