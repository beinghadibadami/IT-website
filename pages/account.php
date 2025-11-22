<?php
$user = auth_current_user();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-3">My Account</h1>
                    <p class="text-muted mb-4">Manage your profile and sessions.</p>

                    <?php if ($user): ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Full Name</span>
                                <span class="fw-semibold"><?php echo htmlspecialchars($user['full_name']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Email</span>
                                <span class="fw-semibold"><?php echo htmlspecialchars($user['email']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Username</span>
                                <span class="fw-semibold"><?php echo htmlspecialchars($user['username']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Phone</span>
                                <span class="fw-semibold"><?php echo htmlspecialchars($user['phone']); ?></span>
                            </div>
                        </div>

                        <a href="index.php?page=account&action=logout" class="btn btn-dark w-100 rounded-3 fw-bold">Logout</a>
                    <?php else: ?>
                        <p class="text-muted">You are not logged in.</p>
                        <a href="index.php?page=login" class="btn btn-dark rounded-3">Go to Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
