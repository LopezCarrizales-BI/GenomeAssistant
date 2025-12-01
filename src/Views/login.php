<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GenomeAssistant | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="Login page for GenomeAssistant">

    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'tokens.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'login.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome to GenomeAssistant</h2>
            <p>Please sign in to your account</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #fee2e2; color: #ef4444; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo asset('/auth/login'); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required aria-label="Email address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required aria-label="Password">
            </div>
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember-me" id="remember-me">
                    Remember me
                </label>
                <div class="forgot-password">
                    <a href="password" aria-label="Forgot your password?">Forgot password?</a>
                </div>
            </div>
            <button type="submit" class="login-button">Sign in</button>
        </form>

        <div class="signup-link">
            New to GenomeAssistant? <br>
            <a href="<?php echo asset('/create-account'); ?>" aria-label="Sign up">Create an account</a>
        </div>
    </div>
</body>

</html>