<?php
require __DIR__ . '/parts/admin-required.php'; #沒登入不能操作
require __DIR__ . '/parts/pdo-connect.php';


$sid = isset($_GET['animal_id']) ? intval($_GET['animal_id']) : 0;


// 綜合刪除
if (!empty($_GET['animal_id'])) {
  // 用explode將字串拆分
  $selectedSids = explode(',', $_GET['animal_id']);

  // 預處理
  $sql = "DELETE FROM `animal_info` WHERE `animal_id` IN (";

  // 为每个 sid 添加占位符
  $placeholders = implode(',', array_fill(0, count($selectedSids), '?'));

  $sql .= $placeholders . ")";
  $stmt = $pdo->prepare($sql);

  // 綁定執行
  foreach ($selectedSids as $index => $sid) {
    $stmt->bindValue($index + 1, $sid, PDO::PARAM_INT);
  }

  $stmt->execute();
}



$backTo = 'list.php';
//HTTP_REFERER=網頁檢查>network>header>REFERER
if (!empty($_SERVER['HTTP_REFERER'])) {
  $backTo = $_SERVER['HTTP_REFERER'];
}


header('Location: ' . $backTo);
