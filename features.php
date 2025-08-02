<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - QuickDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/home.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-headset text-primary me-2"></i>
                <span class="fw-bold">QuickDesk</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="features.php">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pricing.php">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <a class="nav-link me-2" href="index.php?page=login">Login</a>
                    <a class="btn btn-primary rounded-pill px-4" href="index.php?page=register">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Powerful Features</h1>
                    <p class="lead text-muted">Everything you need to provide excellent customer support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-primary mb-3">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h5 class="mb-3">Ticket Management</h5>
                        <p class="text-muted">Create, assign, and track support tickets with ease. Organize by priority, category, and status.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Priority levels</li>
                            <li><i class="fas fa-check text-success me-2"></i>Custom categories</li>
                            <li><i class="fas fa-check text-success me-2"></i>Status tracking</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-success mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="mb-3">Team Collaboration</h5>
                        <p class="text-muted">Work together efficiently with role-based access and real-time updates.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Role management</li>
                            <li><i class="fas fa-check text-success me-2"></i>Agent assignment</li>
                            <li><i class="fas fa-check text-success me-2"></i>Internal notes</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-info mb-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="mb-3">Analytics & Reports</h5>
                        <p class="text-muted">Track performance with detailed analytics and reporting features.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Performance metrics</li>
                            <li><i class="fas fa-check text-success me-2"></i>Response times</li>
                            <li><i class="fas fa-check text-success me-2"></i>Resolution rates</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-warning mb-3">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="mb-3">Communication</h5>
                        <p class="text-muted">Keep conversations organized with threaded comments and notifications.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Threaded comments</li>
                            <li><i class="fas fa-check text-success me-2"></i>Email notifications</li>
                            <li><i class="fas fa-check text-success me-2"></i>File attachments</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-danger mb-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5 class="mb-3">Search & Filter</h5>
                        <p class="text-muted">Find tickets quickly with powerful search and filtering options.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Advanced search</li>
                            <li><i class="fas fa-check text-success me-2"></i>Multiple filters</li>
                            <li><i class="fas fa-check text-success me-2"></i>Saved searches</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-secondary mb-3">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h5 class="mb-3">Customization</h5>
                        <p class="text-muted">Customize the system to match your workflow and branding needs.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Custom fields</li>
                            <li><i class="fas fa-check text-success me-2"></i>Workflow rules</li>
                            <li><i class="fas fa-check text-success me-2"></i>Brand customization</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-3">Ready to Try These Features?</h2>
                    <p class="text-muted mb-4">Start your free trial and experience all features</p>
                    <a href="index.php?page=register" class="btn btn-primary btn-lg rounded-pill px-5">
                        Start Free Trial
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-headset me-2"></i>
                        <span class="fw-bold">QuickDesk</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="features.php" class="text-white-50 me-3">Features</a>
                        <a href="pricing.php" class="text-white-50 me-3">Pricing</a>
                        <a href="about.php" class="text-white-50 me-3">About</a>
                        <a href="contact.php" class="text-white-50">Contact</a>
                    </div>
                    <small class="text-muted d-block mt-2">© <?= date('Y') ?> QuickDesk. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
