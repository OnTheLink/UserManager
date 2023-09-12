<?php
namespace UserManager;
require __DIR__ . '/vendor/autoload.php';

use Dotenv;
use PDO;
use PDOException;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$PHP_ERROR_REPORTING = $_ENV['PHP_ERROR_REPORTING'];
$PHP_DISPLAY_ERRORS = $_ENV['PHP_DISPLAY_ERRORS'];
error_reporting($PHP_ERROR_REPORTING);
ini_set('display_errors', $PHP_DISPLAY_ERRORS);

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Set timezone
date_default_timezone_set($_ENV['TIMEZONE']);

// DB Connection successful, set some variables
$baseURL = $_ENV['BASE_URL'];

define("siteTitle", $_ENV['SITE_TITLE']);
define("baseURL", $baseURL);
define("resourceURL", $baseURL . "/resources");
require __DIR__ . '/util/autoload.php';
