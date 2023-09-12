<?php

namespace UserManager\Util\Routing\Controllers;
use Exception;
use PDO;
use JetBrains\PhpStorm\NoReturn;
use UserManager\Util\Logging\AppLog;
use UserManager\Util\Validators\AuthValidator;
use UserManager\Util\Authentication\UserAuthentication;

abstract class AdminController
{
    const VIEW_PATH = __DIR__ . '/../../../resources/views/';
    public AppLog $logger;
    protected readonly UserAuthentication $auth;

    public function __construct()
    {
        // Create logger
        $this->logger = new AppLog();

        // Create authentication
        $this->auth = new UserAuthentication();
    }

    /**
     * @throws Exception
     */
    public function index(): void
    {
        $this->auth->authCookieLoggedInState();
        // Load view
        require self::VIEW_PATH . 'usermanager.php';
    }

    // Abstract methods that will be implemented in subclasses
    abstract public function edit(): void;

    abstract public function editAdmin(): void;

    abstract public function new(): void;

    abstract public function save(): void;

    abstract public function saveAdmin(): void;

    abstract public function saveNew(): void;

    /**
     * @throws Exception
     */
    #[NoReturn] public function terminate(): void
    {
        $this->auth->authCookieLoggedInState();
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            $this->handleMissingFields(['id'], ['id' => $id]);
        }

        global $pdo;
        $deletedRows = $this->deleteUser($pdo, $id);

        if ($deletedRows > 0) {
            $this->respondWithSuccess('User terminated successfully');
        }

        $this->respondWithError('User not updated');
    }

    #[NoReturn] protected function handleMissingFields(array $fields, array $values): void
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Missing required fields', 'fields' => $fields, 'values' => array_values($values)]);

        $logMessage = 'Missing required fields, ';
        foreach ($fields as $field) {
            $logMessage .= "$field: $values[$field], ";
        }
        $logMessage = rtrim($logMessage, ', ');

        $this->logger->log('ERROR', $logMessage);

        exit;
    }

    protected function fetchUserData(string $userID): array
    {
        global $pdo;
        $query = "SELECT * FROM user WHERE userID = :userID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function userDataIsEqual(array $row, array $values): bool
    {
        $middleName = $values['middleName'] ?? null;
        return $row['voornaam'] === $values['firstName'] &&
            $row['tussenvoegsel'] === $middleName &&
            $row['achternaam'] === $values['lastName'] &&
            $row['adres'] === $values['address'] &&
            $row['postcode'] === $values['zip'] &&
            $row['telefoon'] === $values['phone'] &&
            $row['type'] === $values['type'];
    }

    protected function updateUser(PDO $pdo, array $values): void
    {
        $query = "UPDATE user SET voornaam = :firstName, tussenvoegsel = :middleName, achternaam = :lastName, adres = :address, postcode = :zip, telefoon = :phone, type = :type WHERE userID = :userID";
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    #[NoReturn] protected function respondWithSuccess(string $message): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $message]);
        exit;
    }

    protected function fetchAdminData(string $adminID): array
    {
        global $pdo;
        $query = "SELECT * FROM admin WHERE adminID = :adminID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':adminID', $adminID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function adminDataIsEqual(array $row, array $values): bool
    {
        $middleName = $values['middleName'] ?? null;

        return $row['firstname'] === $values['firstName'] &&
            $row['middlename'] === $middleName &&
            $row['lastname'] === $values['lastName'] &&
            $row['email'] === $values['email'] &&
            $row['username'] === $values['username'];
    }

    protected function passwordMatch(string $password, string $password2): bool
    {
        return $password === $password2;
    }

    protected function updateAdmin(PDO $pdo, array $values, bool $updatedWithPassword): void
    {
        $query = "UPDATE admin SET firstname = :firstName, middlename = :middleName, lastname = :lastName, email = :email, username = :username";
        if ($updatedWithPassword) {
            $query .= ", password = :password";
        }
        $query .= " WHERE adminID = :adminID";

        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    #[NoReturn] protected function respondWithError(string $message, array $fields = []): void
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $message, 'fields' => $fields]);
        exit;
    }

    protected function userDataExists(PDO $pdo, array $values): bool
    {
        $query = "SELECT * FROM user WHERE voornaam = :firstName AND tussenvoegsel = :middleName AND achternaam = :lastName AND adres = :address AND postcode = :zip AND telefoon = :phone AND type = :type";
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->rowCount() > 0;
    }

    protected function insertUser(PDO $pdo, array $values): void
    {
        $query = "INSERT INTO user (voornaam, tussenvoegsel, achternaam, adres, postcode, telefoon, type) VALUES (:firstName, :middleName, :lastName, :address, :zip, :phone, :type)";
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    private function deleteUser(PDO $pdo, string $id): int
    {
        $query = "DELETE FROM user WHERE userID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
