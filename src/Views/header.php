<header>
    <div class="header-container">
        <div class="logo-nav">
            <a class="home" href="/">
                <img class="logo" alt="GenomeAssistant Logo" src="<?php asset('/assets/img/blueLogo.svg'); ?>">
            </a>
            <nav class="navbar" aria-label="main navigation">
                <ul class="nav-options">
                    <li class="nav-option selected-option"><a class="nav-link selected-link" href="/public/">Browser</a></li>
                    <li class="nav-option"><a class="nav-link" href="files">Files</a></li>
                    <li class="nav-option"><a class="nav-link" href="helpDocs.php">Help & Docs</a></li>
                </ul>
            </nav>
        </div>
        <div class="profile-nav">
            <a href="#" class="notifications-icon" aria-label="Notifications">
                <?php
                $svgFileSystemPath = ROOT_PATH . '/public/assets/img/notifications.svg';

                if (file_exists($svgFileSystemPath)) {
                    echo file_get_contents($svgFileSystemPath);
                } else {
                    echo '';
                }
                ?>
            </a>
            <nav class="navbar" aria-label="user navigation">
                <ul class="nav-options">
                    <li class="nav-option"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-option"><a class="nav-link" href="landing.php">Log out</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
