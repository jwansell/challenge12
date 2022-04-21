<?php

require_once __DIR__ . '/vendor/autoload.php';


if (!function_exists('env')) {
    /**
     * Return the environment variable requested in a helper function
     *
     * @param string $name
     * @return string|null
     */
    function env($name = '', $default = null)
    {
        if (isset($_ENV[$name])) {
            return $_ENV[$name];
        }
        return $default;
    }
}

// Now we need to bootstrap our env

// Load the .env file using the Package we downloaded
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Get the environment folder
$username = env('DB_USER');
$servername = env('DB_HOST');
$password = env('DB_PASS');
$database = env('DB_DATABASE');
// Now that we have loaded the env we need to grab our PDO connection
$connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
// set the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);