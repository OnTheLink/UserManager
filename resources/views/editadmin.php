<!--suppress HtmlUnknownTarget -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/../components/FaviconMeta.php'; ?>
    <title><?= siteTitle ?> - Edit administrator</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/usermanager.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/popup.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/notification.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/edit.css">
</head>
<body>
<div class="header">
    <h1>Edit user</h1>
</div>

<div class="user-manager">
    <div class="um-top">
        <h2>User Manager - Edit administrator</h2>
        <button class="secondary-button" onclick="navigate('admin')">Go back</button>
    </div>

    <?php
    // Get user data from the database from the email $_SESSION['loggedInEmail']
    global $pdo;
    $sessionEmail = $_SESSION['loggedInEmail'];

    $query = "SELECT * FROM admin WHERE `email` = '$sessionEmail'"; // Replace with the actual query
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set variables
    $adminID = $row['adminID'];
    $firstName = $row['firstname'];
    $middleName = $row['middlename'];
    $lastName = $row['lastname'];
    $username = $row['username'];
    ?>

    <form method="POST" id="saveAdminForm"> <!-- Replace with your actual update user script -->
        <!-- Hidden field to store the admin ID -->
        <input type="hidden" name="adminID" id="adminID" value="<?= $adminID ?>"> <!-- Replace with the actual user ID from the GET request -->

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?= $firstName ?>" placeholder="Enter First Name" required>

        <label for="middleName">Middle Name:</label>
        <input type="text" id="middleName" name="middleName" value="<?= $middleName ?>" placeholder="Enter Middle Name">

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?= $lastName ?>" placeholder="Enter Last Name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $sessionEmail ?>" placeholder="Enter Email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= $username ?>" placeholder="Enter Username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password">

        <label for="password2">Confirm Password:</label>
        <input type="password" id="password2" name="password2" placeholder="Enter Password">
        <hr>

        <div class="terminate-popup-buttons">
            <button type="button" class="button-success" onclick="saveAdmin()">Save Changes</button>
            <button type="button" class="button-danger" onclick="navigate('admin_cancel')">Cancel</button>
        </div>
    </form>
</div>

<?php include_once resourceURL . "/components/FooterBar.php" ?>

<!-- Load Popups -->
<?php include_once resourceURL . "/components/TerminatePopup.php" ?>
<?php include_once resourceURL . "/components/NotificationResponse.php" ?>

<!-- Load additional JS -->
<script src="<?= resourceURL ?>/js/usermanager.js"></script>
<script src="<?= resourceURL ?>/js/popup.js"></script>
<script src="<?= resourceURL ?>/js/notification.js"></script>
</body>
</html>
