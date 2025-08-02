<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - QuickDesk</title>
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
                        <a class="nav-link active" href="pricing.php">Pricing</a>
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
                    <h1 class="display-4 fw-bold mb-3">Simple Pricing</h1>
                    <p class="lead text-muted">Choose the plan that's right for your team</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Free Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card h-100">
                        <div class="card-header text-center">
                            <h5 class="mb-0">Free</h5>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="amount">0</span>
                                <span class="period">/month</span>
                            </div>
                            <p class="text-muted">Perfect for getting started</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Up to 5 tickets/month</li>
                                <li><i class="fas fa-check text-success me-2"></i>1 agent</li>
                                <li><i class="fas fa-check text-success me-2"></i>Basic support</li>
                                <li><i class="fas fa-check text-success me-2"></i>Email notifications</li>
                                <li class="text-muted"><i class="fas fa-times me-2"></i>Advanced analytics</li>
                                <li class="text-muted"><i class="fas fa-times me-2"></i>Custom branding</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?page=register" class="btn btn-outline-primary w-100">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card featured h-100">
                        <div class="popular-badge">Most Popular</div>
                        <div class="card-header text-center">
                            <h5 class="mb-0">Pro</h5>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="amount">29</span>
                                <span class="period">/month</span>
                            </div>
                            <p class="text-muted">For growing teams</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Unlimited tickets</li>
                                <li><i class="fas fa-check text-success me-2"></i>Up to 10 agents</li>
                                <li><i class="fas fa-check text-success me-2"></i>Priority support</li>
                                <li><i class="fas fa-check text-success me-2"></i>Advanced analytics</li>
                                <li><i class="fas fa-check text-success me-2"></i>Custom categories</li>
                                <li><i class="fas fa-check text-success me-2"></i>File attachments</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?page=register" class="btn btn-primary w-100">Start Free Trial</a>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card h-100">
                        <div class="card-header text-center">
                            <h5 class="mb-0">Enterprise</h5>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="amount">99</span>
                                <span class="period">/month</span>
                            </div>
                            <p class="text-muted">For large organizations</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Unlimited everything</li>
                                <li><i class="fas fa-check text-success me-2"></i>Unlimited agents</li>
                                <li><i class="fas fa-check text-success me-2"></i>24/7 phone support</li>
                                <li><i class="fas fa-check text-success me-2"></i>Custom branding</li>
                                <li><i class="fas fa-check text-success me-2"></i>API access</li>
                                <li><i class="fas fa-check text-success me-2"></i>Dedicated manager</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="contact.php" class="btn btn-outline-primary w-100">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold">Frequently Asked Questions</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Can I change plans anytime?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Is there a free trial?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we offer a 14-day free trial for all paid plans. No credit card required.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We accept all major credit cards, PayPal, and bank transfers for enterprise plans.
                                </div>
                            </div>
                        </div>
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
