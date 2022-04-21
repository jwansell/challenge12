<?php

// Ignore if assets
if (strpos($_SERVER['REQUEST_URI'], '.js') ||
    strpos($_SERVER['REQUEST_URI'], '.css') ||
    strpos($_SERVER['REQUEST_URI'], '/images') ||
    strpos($_SERVER['REQUEST_URI'], '/favicon.ico')) {
    return false;
}
// Let's create the router for now so, we know what to serve
if(!function_exists('loggedIn')) {
    function loggedIn() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
        }
        throw new Exception('Session is not started');
    }
}

require_once(__DIR__ . '/routes.php');