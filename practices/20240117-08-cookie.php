<?php
setcookie('my_cookie', 'my data');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?= $_COOKIE['my_cookie'] #第一次會跳waring 
    #可至網頁檢查>應用程式(Application)>cookie查看
    #未設定期限: 期限=工作階段(section),執行視窗時
    ?? '08沒有設定my_cookie'; #可用??改善=不顯示未定義=!empty
  ?>
</body>

</html>