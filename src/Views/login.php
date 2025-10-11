<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>GenomeAsistant | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="Página para iniciar sesión en GenomeAsistant">
    <link rel="stylesheet" href="<?php asset('assets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php asset('assets/css/login.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <div class="main-container-content">
            <div class="main-container-title">
                <h3>Welcome to GenomeAsistant</h3>
            </div>
            <div class="main-container-tutorial">
                <p><a href="./">How to use GenomeAsistant</a></p>
            </div>
            <div class="main-container-form">
                <form>
                    <div class="form-group">
                        <label for="femail">Email:</label>
                        <input type="email" id="femail" name="femail" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group password-group">
                        <label for="fpassword">Password:</label>
                        <input type="password" id="fpassword" name="fpassword" placeholder="Enter your password" required>
                        <a href="./" class="forgot-link">Forgot password</a>
                    </div>

                    <button type="submit">Sign in</button>
                </form>
            </div>
            <div class="main-container-sing_up">
                <p>New user?</p>
                <a href="./">Register now to GenomeAsistant</a>
            </div>
            <div class="main-container-policy">
                <h6>By creating this account, you agree to our Privacy <a href="./">Policy</a></h6>
            </div>
        </div>
    </div>
</body>

</html>