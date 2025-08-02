<?php
require_once 'config/config.php';

// Handle demo logins
if (isset($_GET['demo'])) {
    $demo_credentials = [
        'admin' => ['username' => 'admin', 'password' => 'password123'],
        'agent' => ['username' => 'agent', 'password' => 'password123'],
        'user' => ['username' => 'user', 'password' => 'password123']
    ];
    
    if (isset($demo_credentials[$_GET['demo']])) {
        $user = new User();
        $result = $user->login($demo_credentials[$_GET['demo']]['username'], $demo_credentials[$_GET['demo']]['password']);
        
        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['user'] = $result['user'];
            header('Location: index.php?page=dashboard');
            exit();
        }
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        return $_SESSION['user'];
    }
    return null;
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php?page=login');
        exit();
    }
}

// Get current page
$page = $_GET['page'] ?? 'dashboard';
$user = getCurrentUser();

// If not logged in and trying to access protected pages, redirect to login
if (!isLoggedIn() && !in_array($page, ['login', 'register'])) {
    $page = 'login';
}

// If logged in and trying to access login/register, redirect to dashboard
if (isLoggedIn() && in_array($page, ['login', 'register'])) {
    $page = 'dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickDesk - Help Desk System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php if (isLoggedIn()): ?>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-headset me-2"></i>QuickDesk
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>" href="index.php?page=dashboard">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'tickets' ? 'active' : '' ?>" href="index.php?page=tickets">
                                <i class="fas fa-ticket-alt me-1"></i>Tickets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'create-ticket' ? 'active' : '' ?>" href="index.php?page=create-ticket">
                                <i class="fas fa-plus me-1"></i>New Ticket
                            </a>
                        </li>
                        <?php if ($user['role'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i>Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?page=users">
                                    <i class="fas fa-users me-2"></i>Users
                                </a></li>
                                <li><a class="dropdown-item" href="index.php?page=categories">
                                    <i class="fas fa-tags me-2"></i>Categories
                                </a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($user['full_name']) ?>
                                <span class="badge bg-light text-primary ms-1"><?= ucfirst($user['role']) ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?page=profile">
                                    <i class="fas fa-user-edit me-2"></i>Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="home.php">
                                    <i class="fas fa-home me-2"></i>Home Page
                                </a></li>
                                <li><a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid mt-4">
            <?php
            switch ($page) {
                case 'dashboard':
                    // Route to appropriate dashboard based on user role
                    if ($user['role'] === 'admin') {
                        include 'pages/admin-dashboard.php';
                    } elseif ($user['role'] === 'agent') {
                        include 'pages/agent-dashboard.php';
                    } else {
                        include 'pages/user-dashboard.php';
                    }
                    break;
                case 'tickets':
                    include 'pages/tickets.php';
                    break;
                case 'create-ticket':
                    include 'pages/create-ticket.php';
                    break;
                case 'ticket-detail':
                    include 'pages/ticket-detail.php';
                    break;
                case 'users':
                    if ($user['role'] === 'admin') {
                        include 'pages/users.php';
                    } else {
                        echo '<div class="alert alert-danger">Access denied.</div>';
                    }
                    break;
                case 'categories':
                    if ($user['role'] === 'admin') {
                        include 'pages/categories.php';
                    } else {
                        echo '<div class="alert alert-danger">Access denied.</div>';
                    }
                    break;
                case 'profile':
                    include 'pages/profile.php';
                    break;
                default:
                    // Default to appropriate dashboard
                    if ($user['role'] === 'admin') {
                        include 'pages/admin-dashboard.php';
                    } elseif ($user['role'] === 'agent') {
                        include 'pages/agent-dashboard.php';
                    } else {
                        include 'pages/user-dashboard.php';
                    }
            }
            ?>
        </div>
    <?php else: ?>
        <!-- Login/Register Pages -->
        <div class="login-container">
            <?php
            if ($page === 'register') {
                include 'pages/register.php';
            } else {
                include 'pages/login.php';
            }
            ?>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
