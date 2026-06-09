<?php
// Configuration tokens matching the system setup
$host    = 'localhost';
$db_name = 'testdb'; // Matches the 'testdb' designation in your screenshot
$username = 'root';
$password = ''; 
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Attempt to instantiate the PDO database connection instance
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Outputs the verification text shown in Figure 4
    echo "<h3 style='color: green; font-family: sans-serif;'>Success!</h3>";
    echo "<p style='font-family: sans-serif; font-size: 14px;'>Connected to the <strong>{$db_name}</strong> database successfully via PDO.</p>";

} catch (PDOException $e) {
    // Catch errors cleanly if connection channel drops
    die("<span style='color: red;'>Connection Failed: </span>" . $e->getMessage());
}
?>