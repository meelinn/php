<?php
require __DIR__ . '/parts/pdo-connect.php';
header('Content-Type: application/json');
$output = [
  'success' => false, #資料傳輸過來有沒有新增成功
  'postData' => $_POST,
  'code' => 0, #追蹤程式執行的編號
];
if (empty($_POST['email']) or empty($_POST['password'])) {
  #欄位資料不足=空的
  $output['code'] = 400;
} else {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $sql = "SELECT * FROM manager WHERE email=?"; //明碼用法 AND password=?,AND password=md5(?)?
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $row = $stmt->fetch();
  if (empty($row)) {
    #帳號是錯誤的
    $output['code'] = 410;
  } else {
    #帳號是正確的
    $output['success'] = password_verify($password, $row["password"]);
    $output['code'] = $output['success'] ? 200 : 420; #420密碼錯誤
    // 明碼用法:$output["success"] = true;

    if ($output['success']) {
      $_SESSION['admin'] = [
        'sid' => $row['sid'],
        'email' => $email,
        'nickname' => $row['nickname'],
      ];
    }
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
