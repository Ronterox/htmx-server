<?php

include 'view.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = compact('name', 'email');
    array_push($_SESSION['contacts'], $contact);

    $contacts = $_SESSION['contacts'];
    view('index.html', 'contacts', compact('contacts'));
}
