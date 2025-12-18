<?php
$user = auth_current_user();
$errors = $_SESSION['update_errors'] ?? [];
unset($_SESSION['update_errors']);
?>

<div class="page-hero">
    <div class="container">
        <h1 class="page-title">My Account</h1>
        <p class="page-subtitle">Manage your profile and settings</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-danger mb-4 rounded-3 border-0 shadow-sm">
                            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $errors['general']; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-5">
                        <div class="mb-3 mb-md-0">
                            <h2 class="h3 fw-bold mb-2">My Profile</h2>
                            <p class="text-muted mb-0">Manage your account information and preferences</p>
                        </div>
                        <span
                            class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill fw-semibold border border-primary-subtle">
                            <i class="fas fa-crown me-1"></i> Member
                        </span>
                    </div>

                    <form action="index.php?page=account&action=update_profile" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        class="form-label text-dark fw-bold mb-2 small text-uppercase tracking-wide">Full
                                        Name</label>
                                    <input type="text" name="full_name"
                                        class="form-control form-control-lg bg-light border-0 shadow-sm ps-3"
                                        style="border-radius: 12px; font-size: 0.95rem; padding: 1rem;"
                                        value="<?php echo htmlspecialchars($user['full_name']); ?>"
                                        placeholder="Enter your full name">
                                    <?php if (isset($errors['full_name'])): ?>
                                        <div class="text-danger small mt-2 d-flex align-items-center"><i
                                                class="fas fa-exclamation-triangle me-1"></i>
                                            <?php echo $errors['full_name']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        class="form-label text-dark fw-bold mb-2 small text-uppercase tracking-wide">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="form-control form-control-lg bg-light border-0 shadow-sm ps-3"
                                        style="border-radius: 12px; font-size: 0.95rem; padding: 1rem;"
                                        value="<?php echo htmlspecialchars($user['email']); ?>"
                                        placeholder="name@example.com">
                                    <?php if (isset($errors['email'])): ?>
                                        <div class="text-danger small mt-2 d-flex align-items-center"><i
                                                class="fas fa-exclamation-triangle me-1"></i>
                                            <?php echo $errors['email']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        class="form-label text-dark fw-bold mb-2 small text-uppercase tracking-wide">Username</label>
                                    <div class="position-relative">
                                        <input type="text" name="username"
                                            class="form-control form-control-lg bg-light border-0 shadow-sm ps-3"
                                            style="border-radius: 12px; font-size: 0.95rem; padding: 1rem;"
                                            value="<?php echo htmlspecialchars($user['username']); ?>"
                                            placeholder="username">
                                    </div>
                                    <?php if (isset($errors['username'])): ?>
                                        <div class="text-danger small mt-2 d-flex align-items-center"><i
                                                class="fas fa-exclamation-triangle me-1"></i>
                                            <?php echo $errors['username']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        class="form-label text-dark fw-bold mb-2 small text-uppercase tracking-wide">Phone
                                        Number</label>
                                    <input type="tel" name="phone"
                                        class="form-control form-control-lg bg-light border-0 shadow-sm ps-3"
                                        style="border-radius: 12px; font-size: 0.95rem; padding: 1rem;"
                                        value="<?php echo htmlspecialchars($user['phone']); ?>"
                                        placeholder="1234567890">
                                    <?php if (isset($errors['phone'])): ?>
                                        <div class="text-danger small mt-2 d-flex align-items-center"><i
                                                class="fas fa-exclamation-triangle me-1"></i>
                                            <?php echo $errors['phone']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit"
                                        class="btn btn-primary px-5 py-3 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center hover-up"
                                        style="border-radius: 12px; min-width: 180px;">
                                        <i class="fas fa-save me-2"></i> Save Changes
                                    </button>
                                    <a href="index.php?page=account&action=logout"
                                        class="btn btn-outline-danger px-5 py-3 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center hover-up"
                                        style="border-radius: 12px; min-width: 150px;">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <style>
                    /* Scoped styles for the account page inputs */
                    .form-control:focus {
                        background-color: #fff !important;
                        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
                        border: 1px solid var(--primary) !important;
                        color: #1e293b;
                    }

                    .tracking-wide {
                        letter-spacing: 0.5px;
                    }

                    .hover-up {
                        transition: all 0.3s ease;
                    }

                    .hover-up:hover {
                        transform: translateY(-2px);
                    }

                    .bg-primary-subtle {
                        background-color: rgba(99, 102, 241, 0.1) !important;
                        color: var(--primary) !important;
                    }

                    .border-primary-subtle {
                        border-color: rgba(99, 102, 241, 0.2) !important;
                    }
                </style>
            </div>
        </div>
    </div>
</div>