<?php
namespace UserManager\Util\Routing;
use Bramus\Router\Router;
use UserManager\Util\authentication\UserAuthentication;
use UserManager\Util\Routing\Controllers\EditAdminController;
use UserManager\Util\Routing\Controllers\EditUserController;
use UserManager\Util\Routing\Controllers\LoginController;
use UserManager\Util\Routing\Controllers\HomeController;
use UserManager\Util\Routing\Controllers\AdminController;
use UserManager\Util\Routing\Controllers\NewUserController;

$auth = new UserAuthentication();

// Create controllers
$LoginController = new LoginController($auth);
$HomeController = new HomeController();
$editUserController = new EditUserController();
$editAdminController = new EditAdminController();
$newUserController = new NewUserController();

// Create Router instance
$router = new Router();

// Define routes
$router->get('/', [$HomeController, 'index']);

$router->get('/login', [$LoginController, 'index']);
$router->get('/register', [$LoginController, 'register']);
$router->get('/logout', [$LoginController, 'logout']);
$router->post('/verifyLogin', [$LoginController, 'verifyLogin']);
$router->post('/verifyRegister', [$LoginController, 'verifyRegister']);

$router->get('/admin', [$editAdminController, 'index']);
$router->get('/admin/edit', [$editUserController, 'edit']);
$router->get('/admin/editAdmin', [$editAdminController, 'editAdmin']);
$router->get('/admin/new', [$newUserController, 'new']);
$router->post('/admin/edit/save', [$editUserController, 'save']);
$router->post('/admin/edit/saveAdmin', [$editAdminController, 'saveAdmin']);
$router->post('/admin/new/saveNew', [$newUserController, 'saveNew']);
$router->post('/admin/terminate', [$editUserController, 'terminate']);

// Initiate the router
$router->run();
