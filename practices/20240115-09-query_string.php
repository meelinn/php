<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP
  #echo $_GET['age']; #沒有給age數值,會顯示錯誤

  #應該要先判斷有無參數再輸出
  $age = isset($_GET['age']) ? $_GET['age'] : 0;
  #若無設定就給預設值0
  echo $age . '<br>';

  #intval=輸出的是整數
  $age = isset($_GET['age']) ? intval($_GET['age']) : 0;
  echo $age;

  ?>

</body>

</html>