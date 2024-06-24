<?php

$port = '3306';
$server = 'localhost';
$base = 'travisscott';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$server;dbname=$base;port=$port;charset=UTF8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Connexion échouée : ' . $e->getMessage());
}