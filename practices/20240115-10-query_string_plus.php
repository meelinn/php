<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP
  #sleep(10); #模擬網路狀況不好延遲時

  $a = isset($_GET['a']) ? intval($_GET['a']) : 0;
  $b = isset($_GET['b']) ? intval($_GET['b']) : 0;
  echo $a + $b;
  ?>

</body>

</html>