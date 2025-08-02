<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $result = $user->login($_POST['username'], $_POST['password']);
    
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['user'] = $result['user'];
        header('Location: index.php?page=dashboard');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                        <h2>QuickDesk</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?page=login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
                    </form>

                    <div class="text-center">
                        <p class="mb-0">Don't have an account? <a href="index.php?page=register">Sign up</a></p>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <strong>Demo Credentials:</strong><br>
                            Admin: admin / admin123<br>
                            Agent: agent / agent123<br>
                            User: user / user123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
