<?php

namespace UserManager\lang;

class ErrorMessages
{
    public static array $errorMessages = [
        'success' => [
            'create' => 'User successfully created',
            'edit' => 'User successfully edited',
            'edit_admin' => 'Administrator successfully edited',
            'terminate' => 'User successfully terminated',
            'register' => 'User successfully registered',
            'login' => 'User successfully logged in',
            'logout' => 'User successfully logged out'
        ],

        'error' => [
            'create' => 'Failed to create user',
            'edit' => 'Failed to edit user',
            'edit_admin' => 'Failed to edit administrator',
            'terminate' => 'Failed to terminate user',
            'register' => 'Failed to register user',
            'login' => 'Failed to log in user',
            'logout' => 'Failed to log out user',
            'cancel' => 'Operation cancelled by user',
        ]
    ];

    public function showMessage(string $type, string $trigger): void
    {
        $message = self::$errorMessages[$type][$trigger] ?? 'An unknown error occurred';
        echo '<script>showMessage("' . $type . '", "' . $message . '")</script>';
    }
}

$errorMessages = new ErrorMessages();

if (isset($_GET['success'])) {
    $errorMessages->showMessage("success", $_GET['success']);
}

if (isset($_GET['error'])) {
    $errorMessages->showMessage("error", $_GET['error']);
}
