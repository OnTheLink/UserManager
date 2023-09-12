<?php

namespace UserManager\Util\Routing\Controllers;
use JetBrains\PhpStorm\NoReturn;
use UserManager\Util\Authentication\UserAuthentication;

class LoginController
{
    private readonly UserAuthentication $auth;
    const VIEW_PATH = __DIR__ . '/../../../resources/views/';

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function index(): void
    {
        require self::VIEW_PATH . 'login.php';
    }

    public function register(): void
    {
        require self::VIEW_PATH . 'register.php';
    }

    public function logout(): void
    {
        $this->auth->logoutUser();
        header('Location: ' . baseURL . '/login');
    }

    public function verifyLogin(): void
    {
        if ($this->auth->authLogin()) {
            $this->redirectTo('/admin');
        } else {
            $this->setLoginError();
            $this->redirectTo('/login');
        }
    }

    public function verifyRegister(): void
    {
        if ($this->auth->authRegister()) {
            $this->redirectTo('/login');
        } else {
            $this->redirectTo('/register');
        }
    }

    #[NoReturn] private function redirectTo(string $path): void
    {
        header('Location: ' . $_ENV['BASE_URL'] . $path);
        exit;
    }

    private function setLoginError(): void
    {
        $_SESSION['LOGIN_ERR'] = true;
    }
}
