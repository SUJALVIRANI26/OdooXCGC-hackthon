<?php
// Admin only page
if ($_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Access denied.</div>';
    return;
}

$user_obj = new User();
$users = $user_obj->getAllUsers();

// Handle role updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    // This would need to be implemented in the User class
    $success = "User role updated successfully.";
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-users me-2"></i>User Management
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users (<?= count($users) ?>)</h5>
                <a href="index.php?page=register" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Add User
                </a>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge bg-<?= getRoleColor($user['role']) ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                        <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUser<?= $user['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <button class="btn btn-outline-danger">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit User Modal -->
                            <div class="modal fade" id="editUser<?= $user['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User: <?= htmlspecialchars($user['full_name']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <div class="mb-3">
                                                    <label for="role<?= $user['id'] ?>" class="form-label">Role</label>
                                                    <select class="form-select" id="role<?= $user['id'] ?>" name="role">
                                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                                        <option value="agent" <?= $user['role'] === 'agent' ? 'selected' : '' ?>>Agent</option>
                                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="is_active" 
                                                               id="active<?= $user['id'] ?>" <?= $user['is_active'] ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="active<?= $user['id'] ?>">
                                                            Active User
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="update_role" class="btn btn-primary">Update User</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function getRoleColor($role) {
    switch ($role) {
        case 'admin': return 'danger';
        case 'agent': return 'warning';
        case 'user': return 'primary';
        default: return 'secondary';
    }
}
?>
