<?php
$ticket_id = $_GET['id'] ?? 0;
$ticket_obj = new Ticket();
$comment_obj = new Comment();
$user_obj = new User();

$ticket = $ticket_obj->getTicketById($ticket_id, $_SESSION['user_id'], $_SESSION['user']['role']);

if (!$ticket) {
    echo '<div class="alert alert-danger">Ticket not found or access denied.</div>';
    return;
}

$comments = $comment_obj->getComments($ticket_id, $_SESSION['user']['role']);
$status_history = $ticket_obj->getStatusHistory($ticket_id);
$agents = $user_obj->getAgents();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_comment'])) {
        $result = $comment_obj->addComment(
            $ticket_id,
            $_SESSION['user_id'],
            $_POST['comment'],
            isset($_POST['is_internal']) ? 1 : 0
        );
        if ($result['success']) {
            header("Location: index.php?page=ticket-detail&id=$ticket_id");
            exit();
        } else {
            $error = $result['message'];
        }
    } elseif (isset($_POST['update_status']) && ($_SESSION['user']['role'] === 'agent' || $_SESSION['user']['role'] === 'admin')) {
        $result = $ticket_obj->updateStatus($ticket_id, $_POST['status'], $_SESSION['user_id'], $_POST['notes'] ?? '');
        if ($result['success']) {
            header("Location: index.php?page=ticket-detail&id=$ticket_id");
            exit();
        } else {
            $error = $result['message'];
        }
    } elseif (isset($_POST['assign_agent']) && ($_SESSION['user']['role'] === 'agent' || $_SESSION['user']['role'] === 'admin')) {
        $result = $ticket_obj->assignAgent($ticket_id, $_POST['agent_id'], $_SESSION['user_id']);
        if ($result['success']) {
            header("Location: index.php?page=ticket-detail&id=$ticket_id");
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-ticket-alt me-2"></i>Ticket #<?= $ticket['id'] ?>
            </h1>
            <a href="index.php?page=tickets" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Tickets
            </a>
        </div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <!-- Ticket Details -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars($ticket['title']) ?></h5>
                        <small class="text-muted">
                            Created by <?= htmlspecialchars($ticket['user_name']) ?> on 
                            <?= date('M j, Y g:i A', strtotime($ticket['created_at'])) ?>
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?= getStatusColor($ticket['status']) ?> me-2">
                            <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                        </span>
                        <span class="badge bg-<?= getPriorityColor($ticket['priority']) ?>">
                            <?= ucfirst($ticket['priority']) ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Category:</strong>
                    <span class="badge ms-2" style="background-color: <?= $ticket['category_color'] ?>; color: white;">
                        <?= htmlspecialchars($ticket['category_name']) ?>
                    </span>
                </div>
                
                <?php if ($ticket['assigned_agent_id']): ?>
                <div class="mb-3">
                    <strong>Assigned Agent:</strong> <?= htmlspecialchars($ticket['agent_name']) ?>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <strong>Description:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        <?= nl2br(htmlspecialchars($ticket['description'])) ?>
                    </div>
                </div>

                <?php if ($ticket['attachment_path']): ?>
                <div class="mb-3">
                    <strong>Attachment:</strong>
                    <a href="<?= $ticket['attachment_path'] ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                        <i class="fas fa-download me-1"></i>Download
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Comments (<?= count($comments) ?>)
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($comments)): ?>
                    <p class="text-muted text-center py-3">No comments yet.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment <?= $comment['is_internal'] ? 'internal' : '' ?> mb-3">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($comment['user_name']) ?></strong>
                            <span class="badge bg-secondary ms-2"><?= ucfirst($comment['user_role']) ?></span>
                            <?php if ($comment['is_internal']): ?>
                                <span class="badge bg-warning ms-1">Internal</span>
                            <?php endif; ?>
                            <small class="text-muted ms-2">
                                <?= date('M j, Y g:i A', strtotime($comment['created_at'])) ?>
                            </small>
                        </div>
                        <div class="comment-body">
                            <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Add Comment Form -->
                <hr>
                <form method="POST">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Add Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    
                    <?php if ($_SESSION['user']['role'] === 'agent' || $_SESSION['user']['role'] === 'admin'): ?>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_internal" name="is_internal">
                        <label class="form-check-label" for="is_internal">
                            Internal comment (not visible to user)
                        </label>
                    </div>
                    <?php endif; ?>
                    
                    <button type="submit" name="add_comment" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i>Add Comment
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Ticket Actions -->
        <?php if ($_SESSION['user']['role'] === 'agent' || $_SESSION['user']['role'] === 'admin'): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Ticket Actions</h6>
            </div>
            <div class="card-body">
                <!-- Update Status -->
                <form method="POST" class="mb-3">
                    <label for="status" class="form-label">Update Status</label>
                    <select class="form-select mb-2" id="status" name="status">
                        <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                        <option value="in_progress" <?= $ticket['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="resolved" <?= $ticket['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                    <input type="text" class="form-control mb-2" name="notes" placeholder="Status change notes (optional)">
                    <button type="submit" name="update_status" class="btn btn-sm btn-primary w-100">
                        Update Status
                    </button>
                </form>

                <!-- Assign Agent -->
                <form method="POST">
                    <label for="agent_id" class="form-label">Assign Agent</label>
                    <select class="form-select mb-2" id="agent_id" name="agent_id">
                        <option value="">Unassigned</option>
                        <?php foreach ($agents as $agent): ?>
                            <option value="<?= $agent['id'] ?>" <?= $ticket['assigned_agent_id'] == $agent['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($agent['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="assign_agent" class="btn btn-sm btn-secondary w-100">
                        Assign Agent
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Ticket Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Ticket Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Created:</strong><br>
                    <small><?= date('M j, Y g:i A', strtotime($ticket['created_at'])) ?></small>
                </div>
                <div class="mb-2">
                    <strong>Last Updated:</strong><br>
                    <small><?= date('M j, Y g:i A', strtotime($ticket['updated_at'])) ?></small>
                </div>
                <?php if ($ticket['resolved_at']): ?>
                <div class="mb-2">
                    <strong>Resolved:</strong><br>
                    <small><?= date('M j, Y g:i A', strtotime($ticket['resolved_at'])) ?></small>
                </div>
                <?php endif; ?>
                <div class="mb-2">
                    <strong>User:</strong><br>
                    <small><?= htmlspecialchars($ticket['user_name']) ?></small><br>
                    <small class="text-muted"><?= htmlspecialchars($ticket['user_email']) ?></small>
                </div>
            </div>
        </div>

        <!-- Status History -->
        <?php if (!empty($status_history)): ?>
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Status History</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php foreach ($status_history as $history): ?>
                    <div class="timeline-item">
                        <div class="mb-1">
                            <?php if ($history['old_status'] && $history['new_status']): ?>
                                <strong>Status changed</strong> from 
                                <span class="badge bg-secondary"><?= ucfirst(str_replace('_', ' ', $history['old_status'])) ?></span>
                                to 
                                <span class="badge bg-primary"><?= ucfirst(str_replace('_', ' ', $history['new_status'])) ?></span>
                            <?php else: ?>
                                <strong><?= htmlspecialchars($history['notes']) ?></strong>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">
                            by <?= htmlspecialchars($history['changed_by_name']) ?> on 
                            <?= date('M j, Y g:i A', strtotime($history['changed_at'])) ?>
                        </small>
                        <?php if ($history['notes'] && $history['old_status']): ?>
                            <div class="mt-1">
                                <small><?= htmlspecialchars($history['notes']) ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
