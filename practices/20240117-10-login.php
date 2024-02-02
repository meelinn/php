<?php
#如果有多個用戶,將用戶放入陣列
$users = [
  #雜湊表格
  'shin' => [ #'shin'=帳號
    'password' => '2345',
    'nickname' => '小新',
  ],
  'ming' => [
    'password' => '3456',
    'nickname' => '大明',
  ],
];


if (isset($_POST['account'])) {
  #如果account欄位有資料,表示表單有送出
  #$formSend = true;

  $account_post = $_POST['account'];
  $password_post = $_POST['password'] ?? ''; #??=!isset

  # Login概念: 把account的資料當作key放到$users裡面,有資料符合=有設定
  if (isset($users[$account_post])) {
    #帳號正確:檢查key,如果帳號存在=正確
    $user = $users[$account_post];
    if ($password_post === $user['password']) {
      #密碼正確:直接比對密碼是否一致,不能用isset,isset=檢查是否存在
      $_SESSION['user'] = [
        'account' => $account_post,
        'nickname' => $user['nickname'],
      ];
    } else {
      #密碼錯誤
    }
  } else {
    #帳號錯誤
  }
};


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php if (!isset($_SESSION['user']) and isset($_POST['account'])) : ?>
    <!-- isset($formSend = true)); #要做到不填寫資料不送出,要用JS? -->
    <div style="color: red;">帳號或密碼錯誤</div>
  <?php endif; ?>

  <?php if (isset($_SESSION['user'])) : ?>
    <h2><?= $_SESSION['user']['nickname'] ?> 泥好</h2>
    <div><a href="20240117-11-logout.php">登出</a></div>
  <?php else : ?>

    <form action="" method="post" enctype="multipart/form-data">
      <!-- enctype
    1. application/x-www-form-urlencoded 使用編碼過的form data
  2. multipart/form-data 這種才可以上傳檔案-->
      <input type="text" name="account" placeholder="請輸入帳號" value="<?= $_POST['account'] ?? '' ?>">
      <input type="password" name="password" placeholder="請輸入密碼" value="<?= htmlentities($_POST['password'] ?? '') ?>">
      <!-- htmlentities=特殊字符跳脫function -->
      <button>登入</button>
    </form>
  <?php endif; ?>

</body>

</html>