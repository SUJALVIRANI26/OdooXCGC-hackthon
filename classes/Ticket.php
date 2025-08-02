<?php
require_once __DIR__ . '/../config/database.php';

class Ticket {
    private $conn;
    private $table = 'tickets';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if ($this->conn === null) {
            throw new Exception("Database connection failed");
        }
    }

    public function create($title, $description, $category_id, $user_id, $priority = 'medium', $attachment_path = null) {
        try {
            // Validate input
            if (empty($title) || empty($description) || empty($category_id) || empty($user_id)) {
                return ['success' => false, 'message' => 'Title, description, category, and user are required'];
            }

            $query = "INSERT INTO " . $this->table . " (title, description, category_id, user_id, priority, attachment_path) 
                     VALUES (:title, :description, :category_id, :user_id, :priority, :attachment_path)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':attachment_path', $attachment_path);

            if ($stmt->execute()) {
                $ticket_id = $this->conn->lastInsertId();
                $this->addStatusHistory($ticket_id, null, 'open', $user_id, 'Ticket created');
                return ['success' => true, 'ticket_id' => $ticket_id, 'message' => 'Ticket created successfully'];
            }
            return ['success' => false, 'message' => 'Failed to create ticket'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getTickets($user_id = null, $role = 'user', $filters = []) {
        try {
            $where_conditions = [];
            $params = [];

            // Base query
            $query = "SELECT t.*, c.name as category_name, c.color as category_color, 
                            u.full_name as user_name, a.full_name as agent_name
                     FROM " . $this->table . " t
                     LEFT JOIN categories c ON t.category_id = c.id
                     LEFT JOIN users u ON t.user_id = u.id
                     LEFT JOIN users a ON t.assigned_agent_id = a.id";

            // Role-based filtering
            if ($role === 'user' && $user_id) {
                $where_conditions[] = "t.user_id = :user_id";
                $params[':user_id'] = $user_id;
            }

            // Apply filters
            if (!empty($filters['status'])) {
                $where_conditions[] = "t.status = :status";
                $params[':status'] = $filters['status'];
            }

            if (!empty($filters['category'])) {
                $where_conditions[] = "t.category_id = :category_id";
                $params[':category_id'] = $filters['category'];
            }

            if (!empty($filters['priority'])) {
                $where_conditions[] = "t.priority = :priority";
                $params[':priority'] = $filters['priority'];
            }

            if (!empty($filters['search'])) {
                $where_conditions[] = "(t.title LIKE :search OR t.description LIKE :search)";
                $params[':search'] = '%' . $filters['search'] . '%';
            }

            // Add WHERE clause if conditions exist
            if (!empty($where_conditions)) {
                $query .= " WHERE " . implode(' AND ', $where_conditions);
            }

            // Sorting
            $sort_by = $filters['sort'] ?? 'created_at';
            $sort_order = $filters['order'] ?? 'DESC';
            $query .= " ORDER BY t.$sort_by $sort_order";

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error fetching tickets: " . $e->getMessage());
            return [];
        }
    }

    public function getTicketById($id, $user_id = null, $role = 'user') {
        try {
            $query = "SELECT t.*, c.name as category_name, c.color as category_color, 
                            u.full_name as user_name, u.email as user_email,
                            a.full_name as agent_name
                     FROM " . $this->table . " t
                     LEFT JOIN categories c ON t.category_id = c.id
                     LEFT JOIN users u ON t.user_id = u.id
                     LEFT JOIN users a ON t.assigned_agent_id = a.id
                     WHERE t.id = :id";

            $params = [':id' => $id];

            // Users can only view their own tickets
            if ($role === 'user' && $user_id) {
                $query .= " AND t.user_id = :user_id";
                $params[':user_id'] = $user_id;
            }

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Error fetching ticket: " . $e->getMessage());
            return null;
        }
    }

    public function updateStatus($ticket_id, $new_status, $user_id, $notes = '') {
        try {
            // Get current status
            $current_ticket = $this->getTicketById($ticket_id);
            if (!$current_ticket) {
                return ['success' => false, 'message' => 'Ticket not found'];
            }

            $old_status = $current_ticket['status'];

            // Update ticket status
            $query = "UPDATE " . $this->table . " SET status = :status, updated_at = CURRENT_TIMESTAMP";
            if ($new_status === 'resolved') {
                $query .= ", resolved_at = CURRENT_TIMESTAMP";
            }
            $query .= " WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $new_status);
            $stmt->bindParam(':id', $ticket_id);

            if ($stmt->execute()) {
                // Add to status history
                $this->addStatusHistory($ticket_id, $old_status, $new_status, $user_id, $notes);
                return ['success' => true, 'message' => 'Status updated successfully'];
            }
            return ['success' => false, 'message' => 'Failed to update status'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function assignAgent($ticket_id, $agent_id, $user_id) {
        try {
            $query = "UPDATE " . $this->table . " SET assigned_agent_id = :agent_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':agent_id', $agent_id);
            $stmt->bindParam(':id', $ticket_id);

            if ($stmt->execute()) {
                $this->addStatusHistory($ticket_id, null, null, $user_id, "Ticket assigned to agent");
                return ['success' => true, 'message' => 'Agent assigned successfully'];
            }
            return ['success' => false, 'message' => 'Failed to assign agent'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    private function addStatusHistory($ticket_id, $old_status, $new_status, $user_id, $notes = '') {
        try {
            $query = "INSERT INTO ticket_status_history (ticket_id, old_status, new_status, changed_by, notes) 
                     VALUES (:ticket_id, :old_status, :new_status, :changed_by, :notes)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->bindParam(':old_status', $old_status);
            $stmt->bindParam(':new_status', $new_status);
            $stmt->bindParam(':changed_by', $user_id);
            $stmt->bindParam(':notes', $notes);
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding status history: " . $e->getMessage());
        }
    }

    public function getStatusHistory($ticket_id) {
        try {
            $query = "SELECT h.*, u.full_name as changed_by_name 
                     FROM ticket_status_history h
                     LEFT JOIN users u ON h.changed_by = u.id
                     WHERE h.ticket_id = :ticket_id
                     ORDER BY h.changed_at ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getTicketStats($user_id = null, $role = 'user') {
        try {
            $where_clause = '';
            $params = [];

            if ($role === 'user' && $user_id) {
                $where_clause = 'WHERE user_id = :user_id';
                $params[':user_id'] = $user_id;
            }

            $query = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open,
                        SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                        SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
                        SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed
                     FROM " . $this->table . " $where_clause";

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            return ['total' => 0, 'open' => 0, 'in_progress' => 0, 'resolved' => 0, 'closed' => 0];
        }
    }
}
?>
