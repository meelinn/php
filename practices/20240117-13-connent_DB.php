<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'Pass1Mii!3wOrd'; #password
$db_name = 'project';
# $db_port='3307'; #不是3307的時候要設定

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

#$dsn = "mysql:host={$db_host};dbname={$db_name};port=3307;charset=utf8mb4";#不是3307的時候要設定


#設定 ATTR_
#$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); #用關聯式陣列改寫:
$pdo_opctions = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
  $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_opctions);

  $stmt = $pdo->query("SELECT*FROM address_book ORDER BY sid DESC LIMIT 10,10");
  #ORDER BY sid DESC降冪排列
  #LIMIT 3=前三筆,LIMIT 10,10 索引值,最多拿X筆

  $rows = $stmt->fetchAll();
  #$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); #用關聯式陣列
  #預設fetchAll()=BOTH
  #PDO::FETCH_NUM 

  echo json_encode($rows);
} catch (PDOException $ex) {
}
