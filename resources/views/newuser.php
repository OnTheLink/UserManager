<!--suppress HtmlUnknownTarget -->
<!DOCTYPE html>
<html lang="">
<head>
    <title><?= siteTitle ?> - New user</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/usermanager.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/popup.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/notification.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/edit.css">
</head>
<body>
<div class="header">
    <h1>New user</h1>
</div>

<div class="user-manager">
    <div class="um-top">
        <h2>User Manager - New user</h2>
        <button class="secondary-button" onclick="navigate('admin')">Go back</button>
    </div>

    <form method="POST" id="newUserForm"> <!-- Replace with your actual update user script -->
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>

        <label for="middleName">Middle Name:</label>
        <input type="text" id="middleName" name="middleName" placeholder="Enter Middle Name">

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter Address" required>

        <label for="zip">Zip:</label>
        <input type="text" id="zip" name="zip" placeholder="Enter Zip" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter Phone" required>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <?php
            global $pdo;
            // Get all available types from the database
            $query = "SELECT * FROM `user_types`";
            $stmt = $pdo->query($query);
            while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row2['typeID'] . "'>" . $row2['type'] . "</option>";
            }
            ?>
        </select>

        <hr>

        <div class="terminate-popup-buttons">
            <button type="button" class="button-success" onclick="createUser()">Create user</button>
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
