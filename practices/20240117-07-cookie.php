<?php
setcookie('my_cookie', 'my data', time() + 15); #設期限=當下時間time()+ 秒數15
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
    #未設定期限: 期限=工作階段(section),瀏覽該網域時才會存在
    ?? '07沒有設定my_cookie'; #可用??改善=不顯示未定義=!empty
  ?>
</body>

</html>