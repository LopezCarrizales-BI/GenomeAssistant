<header>
    <div class="header-container">
        <button class="hamburger" id="hamburger-btn" aria-label="Menu">
            <?php echo Icon::get('burger-menu'); ?>
        </button>

        <a class="home-logo" href="<?php echo (isset($isAdmin) && $isAdmin) ? asset('/admin/dashboard') : asset('/home'); ?>">
            <img class="logo" alt="GenomeAssistant Logo" src="<?php echo asset('/assets/img/whiteLogo.svg'); ?>">
        </a>

        <div class="nav-menu" id="nav-menu">
            <div class="nav-header-mobile">
                <span class="menu-title">Menu</span>
                <button class="close-menu" id="close-menu-btn">&times;</button>
            </div>

            <nav class="navbar" aria-label="main navigation">
                <ul class="nav-options">
                    <?php if (isset($isAdmin) && $isAdmin): ?>
                        <li class="nav-option"><a class="nav-link" href="<?php echo asset('/dashboard'); ?>">Dashboard</a></li>
                        <li class="nav-option"><a class="nav-link" href="<?php echo asset('/users'); ?>">Users Management</a></li>
                    <?php else: ?>
                        <li class="nav-option"><a class="nav-link" href="<?php echo asset('/home'); ?>">Browser</a></li>
                        <li class="nav-option"><a class="nav-link" href="<?php echo asset('/files'); ?>">Files</a></li>
                        <li class="nav-option"><a class="nav-link" href="<?php echo asset('/help'); ?>">Help & Docs</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <nav class="navbar user-nav" aria-label="user navigation">
                <a href="#" class="notifications-icon desktop-bell" aria-label="Notifications">
                    <?php echo Icon::get('notifications'); ?>
                </a>

                <ul class="nav-options">
                    <li class="nav-option"><a class="nav-link" href="<?php echo asset('/profile'); ?>">Profile</a></li>
                    <li class="nav-option"><a class="nav-link" href="<?php echo asset('/logout'); ?>">Log out</a></li>
                </ul>
            </nav>
        </div>

        <div class="header-actions mobile-bell">
            <a href="#" class="notifications-icon" aria-label="Notifications">
                <?php echo Icon::get('notifications'); ?>
            </a>
        </div>

        <div class="overlay" id="overlay"></div>
    </div>
</header>