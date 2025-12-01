<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenomeAssistant - Genomic Data Simplified</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'tokens.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'landing.css'); ?>">
</head>

<body>
    <div class="background-glows">
        <div class="glow glow-1"></div>
        <div class="glow glow-2"></div>
    </div>

    <div class="landing-container">

        <header class="landing-header">
            <div class="brand">
                <img class="brand-img" src="<?php echo asset('/assets/img/whiteLogo.svg'); ?>">
            </div>
            <nav class="landing-nav">
                <a href="<?php echo asset('/login'); ?>" class="nav-link">Log In</a>
                <a href="<?php echo asset('/create-account'); ?>" class="btn-nav">Sign Up</a>
            </nav>
        </header>

        <main class="hero-section">
            <div class="hero-content">
                <div class="badge-pill">
                    <span class="dot"></span> v1.0 Now Available
                </div>
                <h1 class="hero-title">
                    Unlock the Power of <br>
                    <span class="text-gradient">Genomic Data</span>
                </h1>
                <p class="hero-subtitle">
                    Streamline your SNP research with real-time access to NCBI & Ensembl databases.
                    Organize, analyze, and export genomic findings in seconds.
                </p>
                <div class="hero-actions">
                    <a href="<?php echo asset('/create-account'); ?>" class="btn-primary">
                        Get Started Free
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="<?php echo asset('/login'); ?>" class="btn-secondary">
                        Live Demo
                    </a>
                </div>

                <div class="trust-badges">
                    <span>Powered by</span>
                    <div class="partners">
                        <span class="partner">NCBI</span>
                        <span class="divider">•</span>
                        <span class="partner">Ensembl</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="app-card-mockup">
                    <div class="mockup-header">
                        <div class="dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <div class="search-fake">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <span>rs7528419</span>
                        </div>
                    </div>
                    <div class="mockup-body">
                        <div class="data-row">
                            <div class="data-label">Variant ID</div>
                            <div class="data-value highlight">rs7528419</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">Gene</div>
                            <div class="data-value">CELSR2</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">Position</div>
                            <div class="data-value">Chr 1:109274570</div>
                        </div>
                        <div class="graph-placeholder">
                            <div class="bar" style="height: 40%"></div>
                            <div class="bar" style="height: 70%"></div>
                            <div class="bar active" style="height: 100%"></div>
                            <div class="bar" style="height: 50%"></div>
                            <div class="bar" style="height: 80%"></div>
                        </div>
                    </div>
                    <div class="float-card">
                        <div class="icon-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="float-text">
                            <strong>Export Ready</strong>
                            <span>.CSV Generated</span>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="landing-footer">
            <p>&copy; <?php echo date('Y'); ?> GenomeAssistant. Scientific Research Tool.</p>
        </footer>
    </div>

</body>

</html>