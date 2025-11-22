<?php
$errors = $_SESSION['signup_errors'] ?? [];
$old = $_SESSION['signup_old'] ?? [];
$fullName = $old['full_name'] ?? '';
$email = $old['email'] ?? '';
$username = $old['username'] ?? '';
$phone = $old['phone'] ?? '';
unset($_SESSION['signup_errors'], $_SESSION['signup_old']);
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-card">
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Sign up to start exploring templates</p>

            <form method="POST" class="auth-form">
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control"
                        value="<?php echo htmlspecialchars($fullName); ?>" required>
                    <?php if (isset($errors['full_name'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['full_name']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?php echo htmlspecialchars($email); ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['email']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="<?php echo htmlspecialchars($username); ?>" required>
                    <?php if (isset($errors['username'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['username']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="number" id="phone" name="phone" class="form-control"
                        value="<?php echo htmlspecialchars($phone); ?>" required maxlength="10">
                    <?php if (isset($errors['phone'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['phone']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <?php if (isset($errors['password'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['password']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['confirm_password']); ?></small>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-dark w-100 btn-lg mb-3">Sign Up</button>

                <p class="auth-switch">Already have an account?
                    <a href="index.php?page=login">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>
