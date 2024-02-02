<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'Pass1Mii!3wOrd'; #password
$db_name = 'project';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_opctions = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];
