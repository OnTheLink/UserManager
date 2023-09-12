<?php

namespace UserManager\Util\Routing\Controllers;

class HomeController
{
    const VIEW_PATH = __DIR__ . '/../../../resources/views/';

    public function index(): void
    {
        require self::VIEW_PATH . 'home.php';
    }
}
