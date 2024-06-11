<?php

require 'view.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = ++$_SESSION['id'];
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contact = compact('id', 'name', 'email');

    if (!isset($_SESSION['contacts'])) {
        $_SESSION['contacts'] = [];
    }

    $_SESSION['contacts'][$id] = $contact;
    view('index.html', 'oob-contact', $contact);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if ($_GET['id'] === 'all') {
        session_unset();
        session_destroy();
        view('index.html', 'all');
    } elseif (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (isset($id) && isset($_SESSION['contacts'][$id])) {
            unset($_SESSION['contacts'][$id]);
        } else {
            http_response_code(404);
        }
    }
}
