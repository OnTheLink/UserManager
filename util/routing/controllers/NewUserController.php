<?php

namespace UserManager\Util\Routing\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class NewUserController extends AdminController
{
    /**
     * @throws Exception
     */
    public function new(): void
    {
        $this->auth->authCookieLoggedInState();
        // Load view
        require self::VIEW_PATH . 'newuser.php';
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function saveNew(): void
    {
        $this->auth->authCookieLoggedInState();
        $dataObject = json_decode(file_get_contents('php://input'));

        $requiredFields = ['firstName', 'lastName', 'address', 'zip', 'phone', 'type'];
        $values = [];

        foreach ($requiredFields as $field) {
            $values[$field] = $dataObject->{$field} ?? null;
            if ($values[$field] === null) {
                $this->handleMissingFields($requiredFields, $values);
            }
        }

        $values['middleName'] = $dataObject->middleName ?? null;

        global $pdo;
        if ($this->userDataExists($pdo, $values)) {
            $this->respondWithError('User already exists');
        }

        $this->insertUser($pdo, $values);

        $this->respondWithSuccess('User created successfully');
    }

    public function edit(): void
    {}

    public function editAdmin(): void
    {}

    public function save(): void
    {}

    public function saveAdmin(): void
    {}
}
