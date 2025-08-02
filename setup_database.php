<?php
// Simple database setup script
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'quickdesk';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL server successfully.<br>";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
    echo "Database '$database' created successfully.<br>";
    
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database '$database' successfully.<br>";
    
    // Include the database class to create tables
    require_once 'config/database.php';
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "All tables created and default data inserted successfully!<br>";
        echo "<strong>Default Login Credentials:</strong><br>";
        echo "Admin: username = 'admin', password = 'password123'<br>";
        echo "Agent: username = 'agent', password = 'password123'<br>";
        echo "User: username = 'user', password = 'password123'<br>";
        echo "<br><a href='index.php'>Go to QuickDesk</a>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
