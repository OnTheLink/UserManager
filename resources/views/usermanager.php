<!--suppress HtmlUnknownTarget -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/../components/FaviconMeta.php'; ?>
    <title><?= siteTitle ?> - Users</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/usermanager.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/popup.css">
    <link rel="stylesheet" href="<?= resourceURL ?>/css/notification.css">
</head>
<body>
<div class="header">
    <h1>Welcome</h1>
</div>

<div class="user-manager">
    <div class="um-top">
        <h2><?= siteTitle ?></h2>
        <button class="secondary-button" onclick="navigate('new')">Create New User</button>
    </div>

    <table class="um-table">
        <tr>
            <th>Target ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Zip</th>
            <th>Phone</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php
        global $pdo;

        // Placeholder code for fetching users from the database using PDO
        try {
            $query = "SELECT * FROM user LEFT JOIN user_types ON user.type = user_types.typeID"; // Replace with the actual query
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='userID'>" . $row['userID'] . "</td>";
                echo "<td class='firstName'>" . $row['voornaam'] . "</td>";
                echo "<td class='middleName'>" . $row['tussenvoegsel'] . "</td>";
                echo "<td class='lastName'>" . $row['achternaam'] . "</td>";
                echo "<td class='address'>" . $row['adres'] . "</td>";
                echo "<td class='zip'>" . $row['postcode'] . "</td>";
                echo "<td class='phone'>" . $row['telefoon'] . "</td>";
                echo "<td class='type'>" . $row['type'] . "</td>";
                echo "<td>";
                echo "<button class='warning-button um-btn' onclick='edit(this)'>Edit</button>";
                echo "<button class='danger-button' onclick='remove(this)'>Terminate</button>";
                echo "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </table>
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
