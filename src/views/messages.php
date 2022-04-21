<?php

if (!loggedIn()) {
    header('Location: /');
    return;
}

$title = "Message Page";
$slot = file_get_contents( __DIR__ . '/html/messages.html');

require __DIR__ . '/base.php';