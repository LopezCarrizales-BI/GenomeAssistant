<div class="error-container">
    <div class="error-content">
        <div class="error-illustration">
            <?php echo Icon::get('404'); ?>
        </div>

        <h1 class="error-code">404</h1>
        <h2 class="error-title">Sequence Not Found</h2>
        <p class="error-message">
            We couldn't locate the genomic data or page you are looking for.
            It might have been moved, deleted, or never existed in our reference assembly.
        </p>

        <div class="error-actions">
            <a href="<?php echo asset('/home'); ?>" class="btn-primary">
                <?php echo Icon::get('home'); ?>
                Go to Homepage
            </a>

            <a href="<?php echo asset('/help'); ?>" class="btn-secondary">
                <?php echo Icon::get('help'); ?>
                Help Center
            </a>
        </div>
    </div>
</div>