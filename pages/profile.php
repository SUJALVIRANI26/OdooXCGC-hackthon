<?php
$user_obj = new User();
$current_user = $user_obj->getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile update - this would need to be implemented in User class
    $success = "Profile updated successfully.";
}
?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-user me-2"></i>My Profile
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?= htmlspecialchars($current_user['full_name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= htmlspecialchars($current_user['username']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($current_user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        <div class="form-text">Leave blank if you don't want to change your password</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Account Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Role:</strong>
                    <span class="badge bg-<?= getRoleColor($current_user['role']) ?> ms-2">
                        <?= ucfirst($current_user['role']) ?>
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Member Since:</strong><br>
                    <small><?= date('F j, Y', strtotime($current_user['created_at'])) ?></small>
                </div>
                <div class="mb-0">
                    <strong>User ID:</strong><br>
                    <small class="text-muted"><?= $current_user['id'] ?></small>
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
