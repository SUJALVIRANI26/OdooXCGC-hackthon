<?php
require_once __DIR__ . '/../config/database.php';

class Category {
    private $conn;
    private $table = 'categories';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            throw new Exception("Database connection failed");
        }
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY name";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function create($name, $description, $color = '#007bff') {
        try {
            if (empty($name)) {
                return ['success' => false, 'message' => 'Category name is required'];
            }

            $query = "INSERT INTO " . $this->table . " (name, description, color) VALUES (:name, :description, :color)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':color', $color);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Category created successfully'];
            }
            return ['success' => false, 'message' => 'Failed to create category'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function update($id, $name, $description, $color) {
        try {
            if (empty($id) || empty($name)) {
                return ['success' => false, 'message' => 'Category ID and name are required'];
            }

            $query = "UPDATE " . $this->table . " SET name = :name, description = :description, color = :color WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':color', $color);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Category updated successfully'];
            }
            return ['success' => false, 'message' => 'Failed to update category'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            if (empty($id)) {
                return ['success' => false, 'message' => 'Category ID is required'];
            }

            $query = "UPDATE " . $this->table . " SET is_active = 0 WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Category deleted successfully'];
            }
            return ['success' => false, 'message' => 'Failed to delete category'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
?>
