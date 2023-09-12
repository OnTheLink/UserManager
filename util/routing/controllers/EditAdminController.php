<?php

namespace UserManager\Util\Routing\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class EditAdminController extends AdminController
{
    /**
     * @throws Exception
     */
    public function editAdmin(): void
    {
        $this->auth->authCookieLoggedInState();
        // Load view
        require self::VIEW_PATH . 'editadmin.php';
    }

    /**
     * @throws Exception
     * @throws Exception
     */
    #[NoReturn] public function saveAdmin(): void
    {
        $this->auth->authCookieLoggedInState();
        $dataObject = json_decode(file_get_contents('php://input'));

        $requiredFields = ['firstName', 'lastName', 'email', 'username', 'adminID'];
        $values = [];

        foreach ($requiredFields as $field) {
            $values[$field] = $dataObject->{$field} ?? null;
            if (empty($values[$field])) {
                $this->handleMissingFields($requiredFields, $values);
            }
        }

        $values['middleName'] = $dataObject->middleName ?? null;

        global $pdo;
        $row = $this->fetchAdminData($values['adminID']);

        if ($this->adminDataIsEqual($row, $values) && !isset($dataObject->password)) {
            $this->respondWithSuccess('Admin updated successfully');
        }

        $updatedWithPassword = false;
        if (isset($dataObject->password) && isset($dataObject->password2)) {
            if (!$this->passwordMatch($dataObject->password, $dataObject->password2)) {
                $this->respondWithError('Passwords do not match', ['password', 'password2']);
            }

            $passwordHash = $this->auth->hashPassword($dataObject->password2);
            if (password_verify($dataObject->password, $passwordHash)) {
                $values['password'] = $passwordHash;
                $updatedWithPassword = true;
            }
        }

        $this->updateAdmin($pdo, $values, $updatedWithPassword);

        $this->respondWithSuccess('Admin updated successfully');
    }

    public function edit(): void
    {}

    public function new(): void
    {}

    public function save(): void
    {}

    public function saveNew(): void
    {}
}
