<?php

include 'view.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['counter'] = $_SESSION['counter'] + 1;
}

view('index.html', 'count', ['count' => $_SESSION['counter']]);
