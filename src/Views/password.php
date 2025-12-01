<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>GenomeAssistant | Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="GenomeAssistant login page">

    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'tokens.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'login.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'password.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="forgot-container">
        <div class="forgot-card">

            <div class="forgot-header">
                <h1 class="forgot-title">Forgot Password?</h1>
                <p class="forgot-subtitle">
                    Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>

            <form class="forgot-form" action="/password-reset" method="POST">

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="e.g. alexander@example.com" required>
                </div>

                <button type="submit" class="btn-submit">Send Reset Link</button>

            </form>

            <div class="forgot-footer">
                <a href="login" class="link-back">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to Sign in
                </a>
            </div>

        </div>
    </div>
</body>

</html>