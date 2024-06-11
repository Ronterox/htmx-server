<?php

require 'view.php';

session_start();

$contact = [
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'jd@email.com'
];

$contacts = $_SESSION['contacts'] ?? [$contact['id'] => $contact];

view('index.html', 'all', compact('contacts'));

$_SESSION['contacts'] = $contacts;
$_SESSION['id'] ??= $contact['id'];
