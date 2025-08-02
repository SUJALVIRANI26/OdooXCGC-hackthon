<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - QuickDesk</title>
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
                        <a class="nav-link" href="features.php">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pricing.php">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">About</a>
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
                    <h1 class="display-4 fw-bold mb-3">About QuickDesk</h1>
                    <p class="lead text-muted">Simplifying customer support for teams worldwide</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Our Mission</h2>
                    <p class="text-muted mb-4">
                        At QuickDesk, we believe that excellent customer support should be simple, efficient, and accessible to every business. 
                        Our mission is to provide teams with the tools they need to deliver outstanding customer experiences.
                    </p>
                    <p class="text-muted">
                        Founded in 2025, we've helped thousands of businesses streamline their support operations and improve customer satisfaction. 
                        Our intuitive platform makes it easy for teams of any size to manage tickets, collaborate effectively, and track their performance.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <div class="bg-primary rounded-3 p-5 text-center text-white">
                            <i class="fas fa-users fa-5x mb-3"></i>
                            <h3>10,000+</h3>
                            <p class="mb-0">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-primary mb-3 mx-auto">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h5>Fast & Reliable</h5>
                        <p class="text-muted">Built for speed and reliability, ensuring your team can work efficiently.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-success mb-3 mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5>Customer First</h5>
                        <p class="text-muted">Every feature is designed with your customers' experience in mind.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-info mb-3 mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Secure & Private</h5>
                        <p class="text-muted">Your data is protected with enterprise-grade security measures.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="stat-item">
                        <h2 class="fw-bold text-primary">10K+</h2>
                        <p class="text-muted">Active Users</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item">
                        <h2 class="fw-bold text-success">1M+</h2>
                        <p class="text-muted">Tickets Resolved</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item">
                        <h2 class="fw-bold text-info">99.9%</h2>
                        <p class="text-muted">Uptime</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item">
                        <h2 class="fw-bold text-warning">24/7</h2>
                        <p class="text-muted">Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold">Our Team</h2>
                    <p class="text-muted">Meet the people behind QuickDesk</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-avatar bg-primary mb-3 mx-auto">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Sujal Virani</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-avatar bg-success mb-3 mx-auto">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Harshid Savaliya</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-avatar bg-info mb-3 mx-auto">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Prince Vaghasiya</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-avatar bg-warning mb-3 mx-auto" >
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Dhaval Kanzariya</h5>
                    </div>
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
