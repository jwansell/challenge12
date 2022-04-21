<?php

$loggedIn = loggedIn();

$navHtml = "<ul class='main-nav-list'>";
if ($loggedIn) { // Only when the user is logged in
    $navHtml .= "
        <li class='main-nav-list-item'><a href='/logout'>Logout</a></li>
        <li class='main-nav-list-item'><a href='/messages'>View Messages</a></li>
    ";
} else {
    $navHtml .= "<li class='main-nav-list-item'><a href='/login'>Login</a></li>";
    $navHtml .= "<li class='main-nav-list-item'><a href='/register'>Register</a></li>";
}
// Here we put all other's
$navHtml .= "<li class='main-nav-list-item'><a href='/contact'>Contact Us</a></li>";
$navHtml .= "</ul>";

echo $navHtml;