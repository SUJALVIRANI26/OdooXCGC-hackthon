<?php
// Admin only access
if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=dashboard');
    exit();
}

$ticket = new Ticket();
$user_obj = new User();
$category = new Category();

// Get comprehensive stats
$all_stats = $ticket->getTicketStats(null, 'admin');
$users = $user_obj->getAllUsers();
$categories = $category->getAll();
$recent_tickets = $ticket->getTickets(null, 'admin', ['order' => 'DESC']);
$recent_tickets = array_slice($recent_tickets, 0, 10);

// Get user role distribution
$user_roles = [];
foreach ($users as $user) {
    $user_roles[$user['role']] = ($user_roles[$user['role']] ?? 0) + 1;
}
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">
                    <i class="fas fa-crown me-2 text-warning"></i>Administrator Dashboard
                </h1>
                <p class="text-muted mb-0">Complete system overview and management</p>
            </div>
            <div class="admin-actions">
                <a href="index.php?page=users" class="btn btn-outline-primary me-2">
                    <i class="fas fa-users me-1"></i>Manage Users
                </a>
                <a href="index.php?page=categories" class="btn btn-outline-success">
                    <i class="fas fa-tags me-1"></i>Manage Categories
                </a>
            </div>
        </div>
    </div>
</div>

<!-- System Overview Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $all_stats['total'] ?></h4>
                        <p class="mb-0">Total Tickets</p>
                        <small class="opacity-75">All time</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $all_stats['open'] ?></h4>
                        <p class="mb-0">Open Tickets</p>
                        <small class="opacity-75">Needs attention</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count($users) ?></h4>
                        <p class="mb-0">Total Users</p>
                        <small class="opacity-75">System wide</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count($categories) ?></h4>
                        <p class="mb-0">Categories</p>
                        <small class="opacity-75">Active categories</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tags fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics Row -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Ticket Status Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="stat-item">
                            <div class="stat-number text-warning"><?= $all_stats['open'] ?></div>
                            <div class="stat-label">Open</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-warning" style="width: <?= $all_stats['total'] > 0 ? ($all_stats['open'] / $all_stats['total']) * 100 : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <div class="stat-number text-info"><?= $all_stats['in_progress'] ?></div>
                            <div class="stat-label">In Progress</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-info" style="width: <?= $all_stats['total'] > 0 ? ($all_stats['in_progress'] / $all_stats['total']) * 100 : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <div class="stat-number text-success"><?= $all_stats['resolved'] ?></div>
                            <div class="stat-label">Resolved</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: <?= $all_stats['total'] > 0 ? ($all_stats['resolved'] / $all_stats['total']) * 100 : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <div class="stat-number text-secondary"><?= $all_stats['closed'] ?></div>
                            <div class="stat-label">Closed</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-secondary" style="width: <?= $all_stats['total'] > 0 ? ($all_stats['closed'] / $all_stats['total']) * 100 : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-friends me-2"></i>User Distribution
                </h5>
            </div>
            <div class="card-body">
                <div class="user-stats">
                    <div class="user-stat-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-crown text-danger me-2"></i>Admins</span>
                            <span class="badge bg-danger"><?= $user_roles['admin'] ?? 0 ?></span>
                        </div>
                    </div>
                    <div class="user-stat-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-headset text-warning me-2"></i>Agents</span>
                            <span class="badge bg-warning"><?= $user_roles['agent'] ?? 0 ?></span>
                        </div>
                    </div>
                    <div class="user-stat-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-user text-primary me-2"></i>Users</span>
                            <span class="badge bg-primary"><?= $user_roles['user'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and Quick Actions -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Recent Tickets
                </h5>
                <a href="index.php?page=tickets" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recent_tickets)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No tickets found</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_tickets as $ticket): ?>
                                <tr>
                                    <td><strong>#<?= $ticket['id'] ?></strong></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $ticket['id'] ?>" class="text-decoration-none">
                                            <?= htmlspecialchars(substr($ticket['title'], 0, 40)) ?><?= strlen($ticket['title']) > 40 ? '...' : '' ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($ticket['user_name']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= getStatusColor($ticket['status']) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= getPriorityColor($ticket['priority']) ?>">
                                            <?= ucfirst($ticket['priority']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, g:i A', strtotime($ticket['created_at'])) ?></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $ticket['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
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
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tools me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=users" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </a>
                    <a href="index.php?page=categories" class="btn btn-outline-success">
                        <i class="fas fa-tag me-2"></i>Add Category
                    </a>
                    <a href="index.php?page=create-ticket" class="btn btn-outline-info">
                        <i class="fas fa-ticket-alt me-2"></i>Create Ticket
                    </a>
                    <a href="index.php?page=tickets&status=open" class="btn btn-outline-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>View Open Tickets
                    </a>
                </div>
                
                <hr>
                
                <h6 class="mb-3">System Status</h6>
                <div class="system-status">
                    <div class="status-item">
                        <span class="status-indicator bg-success"></span>
                        <span>Database: Online</span>
                    </div>
                    <div class="status-item">
                        <span class="status-indicator bg-success"></span>
                        <span>System: Operational</span>
                    </div>
                    <div class="status-item">
                        <span class="status-indicator bg-warning"></span>
                        <span>Pending Updates: <?= $all_stats['open'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-item {
    padding: 1rem 0;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.user-stat-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.user-stat-item:last-child {
    border-bottom: none;
}

.system-status .status-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 0.5rem;
}

.admin-actions .btn {
    border-radius: 25px;
}
</style>

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
