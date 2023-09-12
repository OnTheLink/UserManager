<?php

namespace UserManager\Util\Routing\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class EditUserController extends AdminController
{
    /**
     * @throws Exception
     */
    public function edit(): void
    {
        $this->auth->authCookieLoggedInState();
        // Load view
        require self::VIEW_PATH . 'edituser.php';
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function save(): void
    {
        $this->auth->authCookieLoggedInState();
        $dataObject = json_decode(file_get_contents('php://input'));

        $requiredFields = ['firstName', 'lastName', 'address', 'zip', 'phone', 'type', 'userID'];
        $values = [];

        foreach ($requiredFields as $field) {
            $values[$field] = $dataObject->{$field} ?? null;
            if (empty($values[$field])) {
                $this->handleMissingFields($requiredFields, $values);
            }
        }

        $values['middleName'] = $dataObject->middleName ?? null;

        global $pdo;
        $row = $this->fetchUserData($values['userID']);

        if ($this->userDataIsEqual($row, $values)) {
            $this->respondWithSuccess('User updated successfully');
        }

        $this->updateUser($pdo, $values);

        $this->respondWithSuccess('User updated successfully');
    }

    public function editAdmin(): void
    {
        // TODO: Implement editAdmin() method.
    }

    public function new(): void
    {
        // TODO: Implement new() method.
    }

    public function saveAdmin(): void
    {
        // TODO: Implement saveAdmin() method.
    }

    public function saveNew(): void
    {
        // TODO: Implement saveNew() method.
    }
}
