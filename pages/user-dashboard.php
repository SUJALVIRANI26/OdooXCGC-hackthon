<?php
// Regular user dashboard
$ticket = new Ticket();
$stats = $ticket->getTicketStats($_SESSION['user_id'], $_SESSION['user']['role']);
$recent_tickets = $ticket->getTickets($_SESSION['user_id'], $_SESSION['user']['role'], ['order' => 'DESC']);
$recent_tickets = array_slice($recent_tickets, 0, 5);

// Get urgent tickets for user
$urgent_tickets = $ticket->getTickets($_SESSION['user_id'], $_SESSION['user']['role'], ['priority' => 'urgent', 'status' => 'open']);
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">
                    <i class="fas fa-user me-2 text-primary"></i>My Dashboard
                </h1>
                <p class="text-muted mb-0">Welcome back, <?= htmlspecialchars($_SESSION['user']['full_name']) ?>!</p>
            </div>
            <div class="user-actions">
                <a href="index.php?page=create-ticket" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Ticket
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $stats['total'] ?></h4>
                        <p class="mb-0">My Tickets</p>
                        <small class="opacity-75">Total submitted</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $stats['open'] ?></h4>
                        <p class="mb-0">Open</p>
                        <small class="opacity-75">Awaiting response</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $stats['in_progress'] ?></h4>
                        <p class="mb-0">In Progress</p>
                        <small class="opacity-75">Being worked on</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cog fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $stats['resolved'] ?></h4>
                        <p class="mb-0">Resolved</p>
                        <small class="opacity-75">Successfully closed</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Tickets Alert -->
<?php if (!empty($urgent_tickets)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">Urgent Tickets Require Attention!</h5>
                    <p class="mb-0">You have <?= count($urgent_tickets) ?> urgent ticket(s) that need immediate attention.</p>
                </div>
                <div class="ms-auto">
                    <a href="index.php?page=tickets&priority=urgent" class="btn btn-outline-danger">
                        View Urgent Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Main Content Row -->
<div class="row">
    <div class="col-lg-8">
        <!-- Recent Tickets -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>My Recent Tickets
                </h5>
                <a href="index.php?page=tickets" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recent_tickets)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-ticket-alt fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted">No tickets yet</h5>
                        <p class="text-muted mb-4">You haven't created any support tickets yet.</p>
                        <a href="index.php?page=create-ticket" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Your First Ticket
                        </a>
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
                                    <td>
                                        <span class="badge" style="background-color: <?= $ticket['category_color'] ?>; color: white;">
                                            <?= htmlspecialchars($ticket['category_name']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, Y g:i A', strtotime($ticket['created_at'])) ?></td>
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
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=create-ticket" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Ticket
                    </a>
                    <a href="index.php?page=tickets" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>View All My Tickets
                    </a>
                    <a href="index.php?page=tickets&status=open" class="btn btn-outline-warning">
                        <i class="fas fa-clock me-2"></i>View Open Tickets
                    </a>
                    <a href="index.php?page=profile" class="btn btn-outline-info">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Help & Support -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle me-2"></i>Help & Support
                </h5>
            </div>
            <div class="card-body">
                <div class="help-item mb-3">
                    <h6><i class="fas fa-lightbulb text-warning me-2"></i>Tips for Better Support</h6>
                    <ul class="list-unstyled small text-muted">
                        <li>• Be specific in your ticket title</li>
                        <li>• Include detailed descriptions</li>
                        <li>• Attach relevant screenshots</li>
                        <li>• Choose appropriate priority level</li>
                    </ul>
                </div>
                
                <div class="help-item">
                    <h6><i class="fas fa-clock text-info me-2"></i>Response Times</h6>
                    <ul class="list-unstyled small text-muted">
                        <li>• Urgent: Within 1 hour</li>
                        <li>• High: Within 4 hours</li>
                        <li>• Medium: Within 24 hours</li>
                        <li>• Low: Within 48 hours</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Account Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Account Information
                </h5>
            </div>
            <div class="card-body">
                <div class="account-info">
                    <div class="info-item mb-2">
                        <strong>Name:</strong> <?= htmlspecialchars($_SESSION['user']['full_name']) ?>
                    </div>
                    <div class="info-item mb-2">
                        <strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?>
                    </div>
                    <div class="info-item mb-2">
                        <strong>Role:</strong> 
                        <span class="badge bg-primary"><?= ucfirst($_SESSION['user']['role']) ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Member Since:</strong> 
                        <small class="text-muted">Account created</small>
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

.help-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.help-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-item {
    padding: 0.25rem 0;
}

.user-actions .btn {
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
