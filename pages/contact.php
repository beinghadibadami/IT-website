<?php
$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdo = getDbConnection();
            if ($pdo) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $phone, $message]);
                    $success = true;
                } catch (PDOException $e) {
                    error_log("Contact form error: " . $e->getMessage());
                    $error = "An error occurred. Please try again.";
                }
            } else {
                $error = "Database connection failed. Please try again.";
            }
        } else {
            $error = "Please enter a valid email address.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title">Get In Touch</h1>
        <p class="page-subtitle">We'd love to hear from you. Let's start a conversation.</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info" data-aos="fade-right">
                <h2>Contact Information</h2>
                <p class="contact-intro">Have a question or ready to start your project? Reach out to us and we'll get back to you within 24 hours.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Office Address</h4>
                            <p>7th Floor 708 Aakruti Complex, Nr Stadium Navrangpura, Ahmedabad<br>Gujarat 380009, India</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Phone Number</h4>
                            <p>+91 8866636848<br>Mon-Fri, 9AM-6PM IST</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email Address</h4>
                            <p>info.divinesyncserv@gmail.com</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-connect">
                    <h4>Connect With Us</h4>
                    <div class="social-links">
                        <a href="https://facebook.com/divinesyncserve" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/divinesyncserve" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="https://linkedin.com/company/divinesyncserve" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://instagram.com/divinesyncserve" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-wrapper" data-aos="fade-left">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Thank you for contacting us! We'll get back to you soon.
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form id="contactForm" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required placeholder='Enter your full name'>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required placeholder='Enter your email address'>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="number" id="phone" name="phone" pattern="[0-9]" maxlength="10" placeholder='Enter your phone number'>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" rows="6" required placeholder='Enter your message here'></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
