<!--suppress HtmlUnknownTarget -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DevLore User Manager</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Login</h1>

    <?php include_once __DIR__ . '../../components/LoginErrors.php' ?>

    <form action="./verifyLogin" method="POST">
        <div class="input-container">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-container">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="./register">Register here</a></p>
    <p><i style="color:#61dafb;" class="fas fa-arrow-left"></i> <a href="./">Return to homepage</a></p>
</div>
</body>
</html>
