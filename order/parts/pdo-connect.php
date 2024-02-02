<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'Pass1Mii!3wOrd';
$db_name = 'midterm_project';

# $db_port = 3307;

$dsn = "mysql:host={$db_host};dbname={$db_name};port=3306;charset=utf8mb4";

$pdo_options = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

if (!isset($_SESSION)) {
  session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['searchField']) && isset($_GET['searchTerm'])) {
  $_SESSION['searchField'] = $_GET['searchField'];
  $_SESSION['searchTerm'] = $_GET['searchTerm'];
}
$searchField = $_SESSION['searchField'] ?? null;
$searchTerm = $_SESSION['searchTerm'] ?? null;
