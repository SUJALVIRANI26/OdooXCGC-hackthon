<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - QuickDesk</title>
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
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">Contact</a>
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
                    <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
                    <p class="lead text-muted">Get in touch with our team</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="contact-form">
                        <h3 class="mb-4">Send us a message</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="company" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="company">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-select" id="subject" required>
                                        <option value="">Choose a subject</option>
                                        <option value="sales">Sales Inquiry</option>
                                        <option value="support">Technical Support</option>
                                        <option value="billing">Billing Question</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h3 class="mb-4">Get in touch</h3>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon bg-primary mb-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5>Email</h5>
                            <p class="text-muted">support@quickdesk.com</p>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon bg-success mb-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5>Phone</h5>
                            <p class="text-muted">+1 (555) 123-4567</p>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon bg-info mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5>Address</h5>
                            <p class="text-muted">
                                B 75 sidhdharth Street<br>
                                Surat 100<br>
                                395006
                            </p>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon bg-warning mb-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5>Business Hours</h5>
                            <p class="text-muted">
                                Monday - Friday: 9:00 AM - 6:00 PM PST<br>
                                Saturday - Sunday: Closed
                            </p>
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
                    <h2 class="fw-bold">Quick Answers</h2>
                    <p class="text-muted">Find answers to common questions</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="faq-item">
                                <h6>How quickly do you respond?</h6>
                                <p class="text-muted small">We typically respond to all inquiries within 24 hours during business days.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item">
                                <h6>Do you offer phone support?</h6>
                                <p class="text-muted small">Yes, phone support is available for Pro and Enterprise customers.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item">
                                <h6>Can I schedule a demo?</h6>
                                <p class="text-muted small">Contact our sales team to schedule a personalized demo.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item">
                                <h6>Is there a free trial?</h6>
                                <p class="text-muted small">Yes, we offer a 14-day free trial for all paid plans.</p>
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
