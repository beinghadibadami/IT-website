<?php
$errors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['login_old'] ?? [];
$email = $old['email'] ?? '';
unset($_SESSION['login_errors'], $_SESSION['login_old']);
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-card">
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-subtitle">Login to continue to Divine SyncServe</p>

            <?php if (isset($errors['general'])): ?>
                <div class="alert alert-danger mb-3"><?php echo htmlspecialchars($errors['general']); ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?php echo htmlspecialchars($email); ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <small class="text-danger"><?php echo htmlspecialchars($errors['email']); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-dark w-100 btn-lg mb-3">Login</button>

                <p class="auth-switch">Don't have an account?
                    <a href="index.php?page=signup">Create one</a>
                </p>
            </form>
        </div>
    </div>
</div>
