<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'quickdesk';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // First try to connect without database to create it if it doesn't exist
            $pdo = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database if it doesn't exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
            
            // Now connect to the specific database
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Check if tables exist, if not create them
            $this->createTablesIfNotExist();
            
        } catch(PDOException $exception) {
            die("Connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
    
    private function createTablesIfNotExist() {
        try {
            // Check if users table exists
            $stmt = $this->conn->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() == 0) {
                $this->createTables();
            }
        } catch(PDOException $e) {
            // If there's an error, try to create tables anyway
            $this->createTables();
        }
    }
    
    private function createTables() {
        $sql = "
        -- Users table
        CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            role ENUM('user', 'agent', 'admin') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            is_active BOOLEAN DEFAULT TRUE
        );

        -- Categories table
        CREATE TABLE IF NOT EXISTS categories (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            color VARCHAR(7) DEFAULT '#007bff',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            is_active BOOLEAN DEFAULT TRUE
        );

        -- Tickets table
        CREATE TABLE IF NOT EXISTS tickets (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            status ENUM('open', 'in_progress', 'resolved', 'closed') DEFAULT 'open',
            priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
            category_id INT,
            user_id INT NOT NULL,
            assigned_agent_id INT NULL,
            attachment_path VARCHAR(500) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            resolved_at TIMESTAMP NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id),
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (assigned_agent_id) REFERENCES users(id)
        );

        -- Ticket comments table
        CREATE TABLE IF NOT EXISTS ticket_comments (
            id INT PRIMARY KEY AUTO_INCREMENT,
            ticket_id INT NOT NULL,
            user_id INT NOT NULL,
            comment TEXT NOT NULL,
            is_internal BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );

        -- Ticket status history
        CREATE TABLE IF NOT EXISTS ticket_status_history (
            id INT PRIMARY KEY AUTO_INCREMENT,
            ticket_id INT NOT NULL,
            old_status VARCHAR(20),
            new_status VARCHAR(20) NOT NULL,
            changed_by INT NOT NULL,
            changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            notes TEXT,
            FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
            FOREIGN KEY (changed_by) REFERENCES users(id)
        );

        -- Notifications table
        CREATE TABLE IF NOT EXISTS notifications (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            ticket_id INT NOT NULL,
            message TEXT NOT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE
        );
        ";
        
        // Execute the SQL to create tables
        $this->conn->exec($sql);
        
        // Insert default data
        $this->insertDefaultData();
    }
    
    private function insertDefaultData() {
        try {
            // Check if admin user exists
            $stmt = $this->conn->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                // Insert default users
                $password = password_hash('password123', PASSWORD_DEFAULT);
                
                $users_sql = "INSERT INTO users (username, email, password, full_name, role) VALUES 
                    ('admin', 'admin@quickdesk.com', ?, 'System Administrator', 'admin'),
                    ('agent', 'agent@quickdesk.com', ?, 'Support Agent', 'agent'),
                    ('user', 'user@quickdesk.com', ?, 'John Doe', 'user')";
                
                $stmt = $this->conn->prepare($users_sql);
                $stmt->execute([$password, $password, $password]);
            }
            
            // Check if categories exist
            $stmt = $this->conn->query("SELECT COUNT(*) as count FROM categories");
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                // Insert default categories
                $categories_sql = "INSERT INTO categories (name, description, color) VALUES 
                    ('Technical Support', 'Technical issues and troubleshooting', '#dc3545'),
                    ('Account Issues', 'Account related problems', '#28a745'),
                    ('Billing', 'Billing and payment issues', '#ffc107'),
                    ('Feature Request', 'New feature requests', '#17a2b8'),
                    ('Bug Report', 'Software bugs and issues', '#fd7e14'),
                    ('General Inquiry', 'General questions and inquiries', '#6c757d')";
                
                $this->conn->exec($categories_sql);
            }
            
        } catch(PDOException $e) {
            // Log error but don't stop execution
            error_log("Error inserting default data: " . $e->getMessage());
        }
    }
}
?>
