<!--suppress HtmlUnknownTarget -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= siteTitle ?> - Edit</title>
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
        <h2>User Manager - Edit</h2>
        <button class="secondary-button" onclick="navigate('admin')">Go back</button>
    </div>

    <?php
    // Get user data from the database
    $id = $_GET['id']; // Replace with the actual GET request

    global $pdo;
    $query = "SELECT * FROM user WHERE userID = $id"; // Replace with the actual query
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set variables
    $userID = $row['userID'];
    $firstName = $row['voornaam'];
    $middleName = $row['tussenvoegsel'];
    $lastName = $row['achternaam'];
    $address = $row['adres'];
    $zip = $row['postcode'];
    $phone = $row['telefoon'];
    $type = $row['type'];
    ?>

    <form method="POST" id="saveUserForm"> <!-- Replace with your actual update user script -->
        <!-- Hidden field to store the user ID -->
        <input type="hidden" name="userID" id="userID" value="<?= $userID ?>"> <!-- Replace with the actual user ID from the GET request -->

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?= $firstName ?>" placeholder="Enter First Name" required>

        <label for="middleName">Middle Name:</label>
        <input type="text" id="middleName" name="middleName" value="<?= $middleName ?>" placeholder="Enter Middle Name">

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?= $lastName ?>" placeholder="Enter Last Name" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?= $address ?>" placeholder="Enter Address" required>

        <label for="zip">Zip:</label>
        <input type="text" id="zip" name="zip" value="<?= $zip ?>" placeholder="Enter Zip" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?= $phone ?>" placeholder="Enter Phone" required>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <?php
            // Get all available types from the database
            $query = "SELECT * FROM `user_types`";
            $stmt = $pdo->query($query);
            while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row2['typeID'] == $type) {
                    echo "<option value='" . $row2['typeID'] . "' selected>" . $row2['type'] . "</option>";
                    continue;
                }

                echo "<option value='" . $row2['typeID'] . "'>" . $row2['type'] . "</option>";
            }
            ?>
        </select>

        <hr>

        <div class="terminate-popup-buttons">
            <button type="button" class="button-success" onclick="save()">Save Changes</button>
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
