<?php
$ticket = new Ticket();
$category = new Category();
$categories = $category->getAll();

// Get filters from URL
$filters = [
    'status' => $_GET['status'] ?? '',
    'category' => $_GET['category'] ?? '',
    'priority' => $_GET['priority'] ?? '',
    'search' => $_GET['search'] ?? '',
    'sort' => $_GET['sort'] ?? 'created_at',
    'order' => $_GET['order'] ?? 'DESC'
];

$tickets = $ticket->getTickets($_SESSION['user_id'], $_SESSION['user']['role'], $filters);
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-ticket-alt me-2"></i>
                <?= $_SESSION['user']['role'] === 'user' ? 'My Tickets' : 'All Tickets' ?>
            </h1>
            <a href="index.php?page=create-ticket" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>New Ticket
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <input type="hidden" name="page" value="tickets">
                    
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?= htmlspecialchars($filters['search']) ?>" placeholder="Search tickets...">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="open" <?= $filters['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="in_progress" <?= $filters['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $filters['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                            <option value="closed" <?= $filters['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $filters['category'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="">All Priorities</option>
                            <option value="low" <?= $filters['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="medium" <?= $filters['priority'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="high" <?= $filters['priority'] === 'high' ? 'selected' : '' ?>>High</option>
                            <option value="urgent" <?= $filters['priority'] === 'urgent' ? 'selected' : '' ?>>Urgent</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="created_at" <?= $filters['sort'] === 'created_at' ? 'selected' : '' ?>>Created Date</option>
                            <option value="updated_at" <?= $filters['sort'] === 'updated_at' ? 'selected' : '' ?>>Updated Date</option>
                            <option value="title" <?= $filters['sort'] === 'title' ? 'selected' : '' ?>>Title</option>
                            <option value="priority" <?= $filters['sort'] === 'priority' ? 'selected' : '' ?>>Priority</option>
                        </select>
                    </div>
                    
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="index.php?page=tickets" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tickets List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    Tickets (<?= count($tickets) ?>)
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($tickets)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tickets found</h5>
                        <p class="text-muted">Try adjusting your filters or create a new ticket.</p>
                        <a href="index.php?page=create-ticket" class="btn btn-primary">Create New Ticket</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Category</th>
                                    <?php if ($_SESSION['user']['role'] !== 'user'): ?>
                                        <th>User</th>
                                    <?php endif; ?>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tickets as $tkt): ?>
                                <tr>
                                    <td><strong>#<?= $tkt['id'] ?></strong></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $tkt['id'] ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($tkt['title']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= getStatusColor($tkt['status']) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $tkt['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= getPriorityColor($tkt['priority']) ?>">
                                            <?= ucfirst($tkt['priority']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: <?= $tkt['category_color'] ?>; color: white;">
                                            <?= htmlspecialchars($tkt['category_name']) ?>
                                        </span>
                                    </td>
                                    <?php if ($_SESSION['user']['role'] !== 'user'): ?>
                                        <td><?= htmlspecialchars($tkt['user_name']) ?></td>
                                    <?php endif; ?>
                                    <td><?= date('M j, Y g:i A', strtotime($tkt['created_at'])) ?></td>
                                    <td><?= date('M j, Y g:i A', strtotime($tkt['updated_at'])) ?></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $tkt['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
function getStatusColor($status) {
    switch ($status) {
        case 'open': return 'warning';
        case 'in_progress': return 'info';
        case 'resolved': return 'success';
        case 'closed': return 'secondary';
        default: return 'secondary';
    }
}

function getPriorityColor($priority) {
    switch ($priority) {
        case 'low': return 'success';
        case 'medium': return 'warning';
        case 'high': return 'danger';
        case 'urgent': return 'dark';
        default: return 'secondary';
    }
}
?>
