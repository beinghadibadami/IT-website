<header class="header" id="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="index.php" class="logo">
                    <span class="logo-icon"><i class="fas fa-code"></i></span>
                    <span class="logo-text">Tech<span class="highlight">Vista</span></span>
                </a>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php?page=home" class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="index.php?page=services" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'services') ? 'active' : ''; ?>">Services</a></li>
                    <li><a href="index.php?page=about" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'about') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="index.php?page=contact" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'contact') ? 'active' : ''; ?>">Contact</a></li>
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
