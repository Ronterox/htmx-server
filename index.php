<?php

include 'view.php';

session_start();

$contact = [
    'name' => 'John Doe',
    'email' => 'jd@email.com'
];

$contacts = $_SESSION['contacts'] ?? [$contact];
view('index.html', 'all', compact('contacts'));
$_SESSION['contacts'] = $contacts;
