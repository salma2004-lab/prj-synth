<?php

$host     = 'localhost';
$dbname   = 'elbaraka';
$username = 'root';
$password = '';

$pdo = new mysqli($host, $username, $password, $dbname);

if ($pdo->connect_error) {
    die("Connection failed: " . $pdo->connect_error);
}
