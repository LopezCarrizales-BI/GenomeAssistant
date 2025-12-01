<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account | GenomeAssistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'tokens.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'login.css'); ?>">
</head>

<body>
    <div class="login-container" style="max-width: 450px;">
        <div class="login-header">
            <h2>Create Account</h2>
            <p>Join GenomeAssistant today</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #fee2e2; color: #ef4444; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center;">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo asset('/auth/register'); ?>" method="POST">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label for="institution">Institution / Organization</label>
                <input type="text" id="institution" name="institution" placeholder="University of ...">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="john@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Create a password">
            </div>

            <button type="submit" class="login-button">Sign Up</button>
        </form>

        <div class="signup-link">
            Already have an account? <br>
            <a href="<?php echo asset('/login'); ?>">Sign in here</a>
        </div>
    </div>
</body>

</html>