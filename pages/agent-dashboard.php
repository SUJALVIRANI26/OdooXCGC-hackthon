<?php
// Agent and Admin access
if (!in_array($_SESSION['user']['role'], ['agent', 'admin'])) {
    header('Location: index.php?page=dashboard');
    exit();
}

$ticket = new Ticket();
$user_obj = new User();

// Get agent-specific stats
$all_stats = $ticket->getTicketStats(null, 'agent');
$assigned_tickets = $ticket->getTickets(null, 'agent', ['assigned_agent_id' => $_SESSION['user_id']]);
$recent_tickets = $ticket->getTickets(null, 'agent', ['order' => 'DESC']);
$recent_tickets = array_slice($recent_tickets, 0, 8);

// Get my assigned tickets count
$my_assigned_count = count($assigned_tickets);
$my_open_assigned = count(array_filter($assigned_tickets, function($t) { return $t['status'] === 'open'; }));
$my_in_progress = count(array_filter($assigned_tickets, function($t) { return $t['status'] === 'in_progress'; }));
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">
                    <i class="fas fa-headset me-2 text-info"></i>Agent Dashboard
                </h1>
                <p class="text-muted mb-0">Manage and resolve customer tickets efficiently</p>
            </div>
            <div class="agent-actions">
                <a href="index.php?page=tickets&assigned_agent_id=<?= $_SESSION['user_id'] ?>" class="btn btn-outline-primary me-2">
                    <i class="fas fa-tasks me-1"></i>My Tickets
                </a>
                <a href="index.php?page=create-ticket" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>New Ticket
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Agent Performance Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $my_assigned_count ?></h4>
                        <p class="mb-0">Assigned to Me</p>
                        <small class="opacity-75">Total assigned</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x opacity-75"></i>
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
                        <h4 class="mb-0"><?= $my_open_assigned ?></h4>
                        <p class="mb-0">Open & Assigned</p>
                        <small class="opacity-75">Needs attention</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= $my_in_progress ?></h4>
                        <p class="mb-0">In Progress</p>
                        <small class="opacity-75">Working on</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spinner fa-2x opacity-75"></i>
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
                        <h4 class="mb-0"><?= $all_stats['total'] ?></h4>
                        <p class="mb-0">All Tickets</p>
                        <small class="opacity-75">System wide</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Priority Tickets and Recent Activity -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-fire me-2"></i>Priority Tickets
                </h5>
                <div class="btn-group btn-group-sm">
                    <a href="index.php?page=tickets&priority=urgent" class="btn btn-outline-danger">Urgent</a>
                    <a href="index.php?page=tickets&priority=high" class="btn btn-outline-warning">High</a>
                    <a href="index.php?page=tickets&status=open" class="btn btn-outline-primary">Open</a>
                </div>
            </div>
            <div class="card-body">
                <?php 
                $priority_tickets = array_filter($recent_tickets, function($t) { 
                    return in_array($t['priority'], ['urgent', 'high']) && $t['status'] !== 'closed'; 
                });
                $priority_tickets = array_slice($priority_tickets, 0, 5);
                ?>
                
                <?php if (empty($priority_tickets)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-muted">No high priority tickets at the moment!</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>User</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($priority_tickets as $ticket): ?>
                                <tr class="<?= $ticket['priority'] === 'urgent' ? 'table-danger' : 'table-warning' ?>">
                                    <td><strong>#<?= $ticket['id'] ?></strong></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $ticket['id'] ?>" class="text-decoration-none">
                                            <?= htmlspecialchars(substr($ticket['title'], 0, 30)) ?><?= strlen($ticket['title']) > 30 ? '...' : '' ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($ticket['user_name']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= getPriorityColor($ticket['priority']) ?>">
                                            <i class="fas fa-exclamation-triangle me-1"></i><?= ucfirst($ticket['priority']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= getStatusColor($ticket['status']) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, g:i A', strtotime($ticket['created_at'])) ?></td>
                                    <td>
                                        <a href="index.php?page=ticket-detail&id=<?= $ticket['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-arrow-right"></i>
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
                    <i class="fas fa-chart-pie me-2"></i>My Workload
                </h5>
            </div>
            <div class="card-body">
                <div class="workload-stats">
                    <div class="workload-item">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-warning"><i class="fas fa-clock me-2"></i>Open</span>
                            <span class="badge bg-warning"><?= $my_open_assigned ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: <?= $my_assigned_count > 0 ? ($my_open_assigned / $my_assigned_count) * 100 : 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="workload-item">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary"><i class="fas fa-cog me-2"></i>In Progress</span>
                            <span class="badge bg-primary"><?= $my_in_progress ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: <?= $my_assigned_count > 0 ? ($my_in_progress / $my_assigned_count) * 100 : 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <?php 
                    $my_resolved = count(array_filter($assigned_tickets, function($t) { return $t['status'] === 'resolved'; }));
                    ?>
                    <div class="workload-item">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-success"><i class="fas fa-check me-2"></i>Resolved</span>
                            <span class="badge bg-success"><?= $my_resolved ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: <?= $my_assigned_count > 0 ? ($my_resolved / $my_assigned_count) * 100 : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h6 class="mb-3">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="index.php?page=tickets&status=open&assigned_agent_id=" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-hand-paper me-1"></i>Claim Unassigned
                    </a>
                    <a href="index.php?page=tickets&assigned_agent_id=<?= $_SESSION['user_id'] ?>&status=in_progress" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-tasks me-1"></i>Continue Working
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent All Tickets -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Recent Tickets
                </h5>
                <a href="index.php?page=tickets" class="btn btn-sm btn-outline-primary">View All Tickets</a>
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
                                    <th>Assigned</th>
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
                                    <td>
                                        <?php if ($ticket['agent_name']): ?>
                                            <span class="text-success">
                                                <i class="fas fa-user-check me-1"></i><?= htmlspecialchars($ticket['agent_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-user-times me-1"></i>Unassigned
                                            </span>
                                        <?php endif; ?>
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

.workload-item {
    margin-bottom: 1rem;
}

.agent-actions .btn {
    border-radius: 25px;
}

.table-danger {
    --bs-table-accent-bg: rgba(220, 53, 69, 0.1);
}

.table-warning {
    --bs-table-accent-bg: rgba(255, 193, 7, 0.1);
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
