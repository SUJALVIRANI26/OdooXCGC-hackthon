<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickDesk - Simple Help Desk Solution</title>
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
  <i class="fas fa-headset me-2"></i>             
     <span class="fw-bold">QuickDesk</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="features.php">Features</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">
                            Simple Help Desk
                            <span class="text-primary">Made Easy</span>
                        </h1>
                        <p class="hero-description">
                            Streamline your customer support with our intuitive help desk system. 
                            Create, track, and resolve tickets effortlessly.
                        </p>
                        
                        <div class="hero-buttons">
                            <a href="index.php?page=register" class="btn btn-primary btn-lg me-3 rounded-pill">
                                Start Free Trial
                            </a>
                            <a href="features.php" class="btn btn-outline-primary btn-lg rounded-pill">
                                Learn More
                            </a>
                        </div>
                        
                        <!-- Demo Access -->
                        <div class="demo-section mt-4">
                            <p class="small text-muted mb-3">Try a quick demo:</p>
                            <div class="demo-buttons">
                                <a href="index.php?demo=admin" class="btn btn-sm btn-light me-2 mb-2">
                                    <i class="fas fa-crown text-danger me-1"></i>Admin
                                </a>
                                <a href="index.php?demo=agent" class="btn btn-sm btn-light me-2 mb-2">
                                    <i class="fas fa-headset text-warning me-1"></i>Agent
                                </a>
                                <a href="index.php?demo=user" class="btn btn-sm btn-light mb-2">
                                    <i class="fas fa-user text-primary me-1"></i>User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Why Choose QuickDesk?</h2>
                <p class="text-muted">Everything you need for excellent customer support</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon bg-primary mb-3">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h5>Easy Ticketing</h5>
                        <p class="text-muted">Create and manage support tickets with just a few clicks</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon bg-success mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Team Collaboration</h5>
                        <p class="text-muted">Work together with your team to resolve issues faster</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon bg-info mb-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5>Track Progress</h5>
                        <p class="text-muted">Monitor ticket status and team performance easily</p>
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
                    <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
                    <p class="text-muted mb-4">Join thousands using QuickDesk for better customer support</p>
                    <a href="index.php?page=register" class="btn btn-primary btn-lg rounded-pill px-5">
                        Start Free Today
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
