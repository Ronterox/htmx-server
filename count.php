<?php

include 'view.php';

session_start();

$_SESSION['counter'] = $_SESSION['counter'] + 1;

view('index.html', 'count', ['count' => $_SESSION['counter']]);
