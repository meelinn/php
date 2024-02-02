<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP

  $a = 12;
  $b = "34";
  $c = "abc";

  echo $a + $b;
  echo '<br>';
  echo $a + $c; #發生錯誤,+只做數值相加

  ?>

</body>

</html>