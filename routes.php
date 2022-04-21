<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

require_once __DIR__ . '/bootstrap.php';

class Response
{

    public $body = null;
    public $status = 200;

    public function __construct($body, $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function respond()
    {
        http_response_code($this->status);
        if ($this->body != null) {
            $string = json_encode($this->body);
            echo $string;
        }
    }
}

if (!function_exists('response')) {
    function response($data = null, $status = 200)
    {
        return new Response($data, $status);
    }
}


// Here we define all our routes
$router = new RouteCollector();

/**
 * Here we define all our API routes
 */
session_start();
$router->any('/api/logout', function () {
    session_destroy();
    header('Location: /');
});


$router->get('/api/messages', function () {
    if (!loggedIn()) {
        header('Location: /');
        return 200;
    }
    global $connection;
    $result = $connection->query('SELECT * FROM contacts ORDER BY id DESC LIMIT 10');
    $messages = $result->fetchAll();
    return response(['data' => $messages]);
});

$router->post('/api/contact', function () {
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        return response([
            'error' => true,
            'messages' => 'Missing inputs'
        ], 400);
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response([
            'error' => true,
            'messages' => 'Email address is invalid'
        ], 400);
    }
    // Now we add the message
    global $connection;
    $statement = $connection->prepare('INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
    $result = $statement->execute([
        $name,
        $email,
        $message,
    ]);
    if ($result) {
        return response([
            'success' => true
        ]);
    }
    else {
        return response([
            'error' => true,
            'messages' => 'Cannot add new message'
        ], 500);
    }
});

$router->post('/api/login', function () {
    if (loggedIn()) {
        header('Location: /home');
        return 200;
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return response([
            'error' => true,
            'messages' => 'missing username or password'
        ], 400);
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    global $connection;
    $result = $connection->query("SELECT username FROM users WHERE username='$username' AND password='$password'");
    if (!$result->rowCount() == 1) {
        return response([
            'error' => true,
            'messages' => 'No matching user'
        ], 404);
    }
    $user = $result->fetch();
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_logged_in'] = true;
    $_SESSION['logged_in_at'] = date('H:i, d/m/Y');
    return response([
            'error' => false,
        ], 200);
});

$router->post('/api/register', function () {
    if (loggedIn()) {
        header('Location: /home');
        return 200;
    }
    if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['confirm'])) {
        return response([
            'error' => true,
            'messages' => 'Missing inputs'
        ], 400);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $confirmPassword = $_POST['confirm'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response([
            'error' => true,
            'messages' => 'Email address is invalid'
        ], 400);
    }
    if ($password != $confirmPassword) {
        return response([
            'error' => true,
            'messages' => 'The passwords do not match'
        ], 400);
    }
    global $connection;
    $duplicateCheck = $connection->query("SELECT id FROM users WHERE username LIKE '$username' OR email LIKE '$email'");
    if ($duplicateCheck->rowCount() > 0) {
        return response([
            'error' => true,
            'messages' => 'You appear to already have an account please try to login instead'
        ], 400);
    }
    $prepare = $connection->prepare('INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
    $insert = $prepare->execute([
        $username,
        $password,
        $email
    ]);
    if ($insert) {
        return response([
            'success' => true
        ]);
    }
    return response([
        'error' => true,
        'messages' => 'failed to add new user'
    ], 500);
});

/**
 * Here we define all our web routes
 */
$router->get('/', function () {
    if (loggedIn()) {
        require __DIR__ . '/src/views/messages.php';
    } else {
        header('Location: /login');
    }
    return 200;
});

$router->get('/home', function () {
    header('Location: /');
});

$router->get('/login', function () {
    require __DIR__ . '/src/views/login.php';
    return 200;
});

$router->get('/register', function () {
    require __DIR__ . '/src/views/register.php';
    return 200;
});

$router->get('/logout', function () {
    header('Location: /api/logout');
});

$router->get('/messages', function () {
    require __DIR__ . '/src/views/messages.php';
    return 200;
});

$router->get('/contact', function () {
    require __DIR__ . '/src/views/contact.php';
    return 200;
});

// Here we use the dispatcher to get match the routes etc
$dispatcher = new Dispatcher($router->getData());

// Dispatch using the request uri and method
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (is_integer($response)) { // Means that we are already responding with the correct view or file
    return;
} else {
    return $response->respond();
}