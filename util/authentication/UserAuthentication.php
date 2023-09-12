<?php

namespace UserManager\Util\authentication;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use UserManager\Util\Validators\AuthValidator;
use DateTime;

class UserAuthentication
{
    private readonly AuthValidator $validator;

    public function __Construct()
    {
        $this->validator = new AuthValidator();
    }

    public function authLogin(): bool
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!$this->validator->validateLoginData((string)$email, (string)$password)) {
            return false;
        }

        $user = $this->fetchUserByEmail($email);

        if (!$user) {
            return false;
        }

        if (!$this->verifyPassword((string)$password, $user)) {
            return false;
        }

        $this->generateLoginToken($email);

        return true;
    }

    public function authRegister(): bool
    {
        global $pdo;

        $firstName = $_POST['firstname'] ?? NULL;
        $middleName = $_POST['middlename'] ?? NULL;
        $lastName = $_POST['lastname'] ?? NULL;
        $email = $_POST['email'] ?? NULL;
        $password = $_POST['password'] ?? NULL;

        if (!$this->validator->validateRegisterData($firstName, $lastName, $email, $password)) {
            return false;
        }

        $user = $this->fetchUserByEmail($email);

        if ($user) {
            return false;
        }

        // Check if the limit of admin users has been reached
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin");
        $stmt->execute();

        // Find out how many rows are in the table
        $rowAmount = $stmt->fetchColumn();

        $adminLimit = $_ENV["ADMIN_LIMIT"];
        $adminLimitReached = $rowAmount >= $adminLimit;

        if ($adminLimitReached) {
            return false;
        }

        $passwordHash = $this->hashPassword($password);

        if ($this->insertUser($firstName, $middleName, $lastName, $email, $passwordHash)) {
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function authCookieLoggedInState(): void
    {
        $sessionCookie = $_SESSION['loggedInCookie'] ?? null;
        $sessionEmail = $_SESSION['loggedInEmail'] ?? null;

        if (!$this->validator->validateCookieData((string)$sessionEmail, (string)$sessionCookie)) {
            $this->redirectToLogin();
        }

        $user = $this->fetchUserByCookie($sessionCookie, $sessionEmail);

        if (!$user) {
            $this->redirectToLogin();
        }

        $this->checkCookieExpiration($user);
    }

    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function insertUser($firstName, $middleName, $lastName, $email, $password): bool
    {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO `admin` (`firstname`, `middlename`, `lastname`, `email`, `password`) VALUES (:firstname, :middlename, :lastname, :email, :password)');
        $stmt->execute(['firstname' => $firstName, 'middlename' => $middleName, 'lastname' => $lastName, 'email' => $email, 'password' => $password]);

        return $stmt->rowCount() > 0;
    }

    /**
     * @throws Exception
     */
    public function generateLoginToken($email): void
    {
        global $pdo;
        $randomString = bin2hex(random_bytes(64));
        $_SESSION['loggedInCookie'] = $randomString;
        $_SESSION['loggedInEmail'] = $email;

        $stmt = $pdo->prepare('UPDATE `admin` SET `loggedInCookie` = :cookie WHERE `email` = :email');
        $stmt->execute(['cookie' => $randomString, 'email' => $email]);
    }

    public function verifyPassword(string $password, array $user): bool
    {
        if (password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    public function fetchUserByEmail($email)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM `admin` WHERE `email` = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($stmt->errorInfo()[0] !== '00000') {
            $_SESSION['PDO_ERR'] = $stmt->errorInfo()[2];
            return false;
        }

        return $user ?: false;
    }

    public function fetchUserByCookie($sessionCookie, $sessionEmail)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT `last_login`, `updated_at`, `created_at` FROM `admin` WHERE `loggedInCookie` = :cookie AND `email` = :email');
        $stmt->execute(['cookie' => $sessionCookie, 'email' => $sessionEmail]);
        $user = $stmt->fetch();

        if ($stmt->errorInfo()[0] !== '00000') {
            $_SESSION['PDO_ERR'] = $stmt->errorInfo()[2];
            $this->redirectToLogin();
        }

        return $user ?: false;
    }

    public function deleteCookie($sessionCookie, $sessionEmail): void
    {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE `admin` SET `loggedInCookie` = NULL WHERE `loggedInCookie` = :cookie AND `email` = :email');
        $stmt->execute(['cookie' => $sessionCookie, 'email' => $sessionEmail]);
    }

    public function correctData($lastLogin, $updated, $created, $sessionEmail): void
    {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE `admin` SET `last_login` = :last_login, `updated_at` = :updated_at, `created_at` = :created_at WHERE `email` = :email');
        $stmt->execute(['last_login' => $lastLogin, 'updated_at' => $updated, 'created_at' => $created, 'email' => $sessionEmail]);
    }

    public function clearSession(): void
    {
        unset($_SESSION['loggedInCookie']);
        unset($_SESSION['loggedInEmail']);
        session_destroy();
    }

    public function logoutUser(): void
    {
        $sessionCookie = $_SESSION['loggedInCookie'] ?? null;
        $sessionEmail = $_SESSION['loggedInEmail'] ?? null;

        $this->deleteCookie($sessionCookie, $sessionEmail);
        $this->clearSession();
    }

    #[NoReturn] private function redirectToLogin(): void
    {
        header('Location: ' . baseURL . '/login');
        exit;
    }

    /**
     * @throws Exception
     */
    private function checkCookieExpiration($user): void
    {
        $lastLogin = $user['last_login'];
        $updated = $user['updated_at'];
        $created = $user['created_at'];
        $sessionEmail = $_SESSION['loggedInEmail'];
        $sessionCookie = $_SESSION['loggedInCookie'];

        $lastLoginDateTime = new DateTime($lastLogin);
        $currentDateTime = new DateTime();

        $interval = $currentDateTime->diff($lastLoginDateTime);
        $minutesPassed = $interval->i + $interval->h * 60 + $interval->d * 1440;

        if ($minutesPassed > 30) {
            $this->deleteCookie($sessionCookie, $sessionEmail);
            $this->correctData($lastLogin, $updated, $created, $sessionEmail);
            $this->clearSession();
            $this->redirectToLogin();
        }
    }
}