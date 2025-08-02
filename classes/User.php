<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            throw new Exception("Database connection failed");
        }
    }

    public function register($username, $email, $password, $full_name, $role = 'user') {
        try {
            // Validate input
            if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
                return ['success' => false, 'message' => 'All fields are required'];
            }

            // Check if user already exists
            $query = "SELECT id FROM " . $this->table . " WHERE username = :username OR email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Username or email already exists'];
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $query = "INSERT INTO " . $this->table . " (username, email, password, full_name, role) 
                     VALUES (:username, :email, :password, :full_name, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'User registered successfully'];
            }
            return ['success' => false, 'message' => 'Registration failed'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function login($username, $password) {
        try {
            // Validate input
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Username and password are required'];
            }

            $query = "SELECT id, username, email, password, full_name, role FROM " . $this->table . " 
                     WHERE (username = :username OR email = :username) AND is_active = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password'])) {
                    unset($user['password']);
                    return ['success' => true, 'user' => $user];
                }
            }
            return ['success' => false, 'message' => 'Invalid username or password'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Login error: ' . $e->getMessage()];
        }
    }

    public function getUserById($id) {
        try {
            $query = "SELECT id, username, email, full_name, role, created_at FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAllUsers() {
        try {
            $query = "SELECT id, username, email, full_name, role, created_at, is_active FROM " . $this->table . " ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAgents() {
        try {
            $query = "SELECT id, username, full_name FROM " . $this->table . " WHERE role IN ('agent', 'admin') AND is_active = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function updateUser($id, $data) {
        try {
            $fields = [];
            $params = [':id' => $id];
            
            if (isset($data['full_name'])) {
                $fields[] = "full_name = :full_name";
                $params[':full_name'] = $data['full_name'];
            }
            
            if (isset($data['email'])) {
                $fields[] = "email = :email";
                $params[':email'] = $data['email'];
            }
            
            if (isset($data['role'])) {
                $fields[] = "role = :role";
                $params[':role'] = $data['role'];
            }
            
            if (isset($data['is_active'])) {
                $fields[] = "is_active = :is_active";
                $params[':is_active'] = $data['is_active'];
            }
            
            if (empty($fields)) {
                return ['success' => false, 'message' => 'No fields to update'];
            }
            
            $query = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            
            if ($stmt->execute($params)) {
                return ['success' => true, 'message' => 'User updated successfully'];
            }
            return ['success' => false, 'message' => 'Failed to update user'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
?>
