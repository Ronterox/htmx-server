<?php

include 'view.php';

session_start();

$counter = $_SESSION['counter'] ?? 0;

view('index.html', 'all', ['count' => $counter]);

$_SESSION['counter'] = $counter;
