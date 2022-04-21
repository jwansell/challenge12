<?php

if (loggedIn()) {
    header('Location: /');
    return;
}

$title = "Register Page";
$slot = file_get_contents( __DIR__ . '/html/register.html');

require __DIR__ . '/base.php';