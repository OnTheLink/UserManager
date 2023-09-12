<!--suppress HtmlUnknownTarget -->
<?php
// Check if an admin user already exists
global $pdo;

// Use prepared PDO statement
$stmt = $pdo->prepare("SELECT COUNT(*) FROM admin");
$stmt->execute();

// Find out how many rows are in the table
$rowAmount = $stmt->fetchColumn();

$adminLimit = $_ENV["ADMIN_LIMIT"];

$adminLimitReached = $rowAmount >= $adminLimit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DevLore User Manager</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/register.css">
</head>
<body>
<div class="register-container">
    <h1>Register</h1>
    <?php if ($adminLimitReached): ?>
        <div class="message-container">
            <p>
                There is already an admin user registered.
                <br>
                Please log in <a href="./login">here</a>.
                <br><br>
                You will be redirected automatically in
                <span class="countdown_seconds">5</span>
                <span class="countdown_word">seconds</span><span class="countdown_dots">.</span>
            </p>
        </div>

        <script src="<?= resourceURL ?>/js/countdown.js"></script>
        <script>
            countdownRedirect(5, "./login");
        </script>
    <?php else: ?>
        <form action="./verifyRegister" method="POST">
            <div class="input-container">
                <label for="firstname">First Name*</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div class="input-container">
                <label for="middlename">Middle Name (optional)</label>
                <input type="text" id="middlename" name="middlename">
            </div>
            <div class="input-container">
                <label for="lastname">Last Name*</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <div class="input-container">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="./login">Login here</a></p>
    <?php endif; ?>
</div>
</body>
</html>
