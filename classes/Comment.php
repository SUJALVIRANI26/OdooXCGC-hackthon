<?php
require_once __DIR__ . '/../config/database.php';

class Comment {
    private $conn;
    private $table = 'ticket_comments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            throw new Exception("Database connection failed");
        }
    }

    public function addComment($ticket_id, $user_id, $comment, $is_internal = false) {
        try {
            if (empty($ticket_id) || empty($user_id) || empty($comment)) {
                return ['success' => false, 'message' => 'All fields are required'];
            }

            $query = "INSERT INTO " . $this->table . " (ticket_id, user_id, comment, is_internal) 
                     VALUES (:ticket_id, :user_id, :comment, :is_internal)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':is_internal', $is_internal, PDO::PARAM_BOOL);

            if ($stmt->execute()) {
                // Update ticket's updated_at timestamp
                $update_query = "UPDATE tickets SET updated_at = CURRENT_TIMESTAMP WHERE id = :ticket_id";
                $update_stmt = $this->conn->prepare($update_query);
                $update_stmt->bindParam(':ticket_id', $ticket_id);
                $update_stmt->execute();

                return ['success' => true, 'message' => 'Comment added successfully'];
            }
            return ['success' => false, 'message' => 'Failed to add comment'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getComments($ticket_id, $user_role = 'user') {
        try {
            $query = "SELECT c.*, u.full_name as user_name, u.role as user_role
                     FROM " . $this->table . " c
                     LEFT JOIN users u ON c.user_id = u.id
                     WHERE c.ticket_id = :ticket_id";

            // Hide internal comments from regular users
            if ($user_role === 'user') {
                $query .= " AND c.is_internal = 0";
            }

            $query .= " ORDER BY c.created_at ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
