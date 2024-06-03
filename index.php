<?php

include 'view.php';

session_start();

$contact = [
    'name' => 'John Doe',
    'email' => 'jd@email.com'
];

view('index.html', 'all', ['contacts' => [$contact]]);
