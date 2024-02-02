<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'Pass1Mii!3wOrd';
$db_name = 'midterm_project';


$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_options = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];
try {
  $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
  $pdo->query("USE midterm_project");
} catch (PDOException $ex) {
  echo 'Connection failed: ' . $ex->getMessage();
  exit;
};

if (!isset($_SESSION)) {
  #如果之前沒有啟動SESSION的功能(會去設定http的檔頭) #重複啟動會waring
  session_start();
};
