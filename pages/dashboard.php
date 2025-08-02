<?php
$ticket = new Ticket();
$stats = $ticket->getTicketStats($_SESSION['user_id'], $_SESSION['user']['role']);
$recent_tickets = $ticket->getTickets($_SESSION['user_id'], $_SESSION['user']['role'], ['order' => 'DESC']);
$recent_tickets = array_slice($recent_tickets, 0, 5); // Get only 5 recent tickets
?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            <small class="text-muted">Welcome back, <?= htmlspecialchars($_SESSION['user']['full_name']) ?></small>
        </h1>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['total'] ?></h4>
                        <p class="mb-0">Total Tickets</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['open'] ?></h4>
                        <p class="mb-0">Open Tickets</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['in_progress'] ?></h4>
                        <p class="mb-0">In Progress</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spinner fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['resolved'] ?></h4>
                        <p class="mb-0">Resolved</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="row">
    <div class="col-12">
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
                        <a href="index.php?page=create-ticket" class="btn btn-primary">Create Your First Ticket</a>
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
                                    <td>#<?= $ticket['id'] ?></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $ticket['id'] ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($ticket['title']) ?>
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
                                        <span class="badge" style="background-color: <?= $ticket['category_color'] ?>">
                                            <?= htmlspecialchars($ticket['category_name']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($ticket['created_at'])) ?></td>
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
