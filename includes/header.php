<header class="header" id="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="index.php" class="logo">
                    <span class="logo-icon"><i class="fas fa-code"></i></span>
                    <span class="logo-text">Divine<span class="highlight"> SyncServe</span></span>
                </a>

                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php?page=home"
                            class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>">Home</a>
                    </li>
                    <li><a href="index.php?page=services"
                            class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'services') ? 'active' : ''; ?>">Services</a>
                    </li>
                    <li><a href="index.php?page=templates"
                            class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == 'templates' || $_GET['page'] == 'template_details')) ? 'active' : ''; ?>">Templates</a>
                    </li>
                    <li><a href="index.php?page=about"
                            class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'about') ? 'active' : ''; ?>">About</a>
                    </li>
                    <li><a href="index.php?page=contact"
                            class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'contact') ? 'active' : ''; ?>">Contact</a>
                    </li>
                    <li>
                        <?php $currentUser = function_exists('auth_current_user') ? auth_current_user() : null; ?>
                        <?php if ($currentUser): ?>
                            <a href="index.php?page=account" class="nav-link">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo htmlspecialchars($currentUser['full_name']); ?>
                            </a>
                        <?php else: ?>
                            <a href="index.php?page=login"
                                class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'login') ? 'active' : ''; ?>">
                                Login
                            </a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a href="index.php?page=cart"
                            class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'cart') ? 'active' : ''; ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if (function_exists('getCartCount') && getCartCount() > 0): ?>
                                <span class="badge bg-danger rounded-pill"
                                    style="font-size: 0.7rem; vertical-align: top;"><?php echo getCartCount(); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>

                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>
</header>