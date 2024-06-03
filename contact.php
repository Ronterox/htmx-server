<?php

include 'view.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = compact('name', 'email');

    if (!isset($_SESSION['contacts'])) {
        $_SESSION['contacts'] = [];
    }

    array_push($_SESSION['contacts'], $contact);
    view('index.html', 'oob-contact', $contact);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    session_unset();
    session_destroy();
    view('index.html', 'all');
}
