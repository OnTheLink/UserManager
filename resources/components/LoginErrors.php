<?php if (isset($_SESSION['PDO_ERR'])): ?>
    <div class="message-container">
        <p>
            An error has occurred while communicating with the database.
            <br>
            Please try again later.
            <br><br>
            ERROR: <?= $_SESSION['PDO_ERR'] ?>
        </p>
    </div>
<?php unset($_SESSION['PDO_ERR']); endif ?>

<?php if (isset($_SESSION['LOGIN_ERR'])): ?>
    <div class="message-container">
        <p>
            Incorrect email or password.
        </p>
    </div>
<?php unset($_SESSION['LOGIN_ERR']); endif ?>