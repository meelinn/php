<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP
  $b = 5 && 7;
  $c = 5 && 0;
  echo $b; #'1'
  echo '<br>';
  echo $c; #''空字串,原始碼無顯示
  echo '<br>';
  #true會被轉換成'1'
  #false會被轉換成'' 空字串

  var_dump($b);
  echo '<br>';
  var_dump($c);
  #var_dump() 用來查看變數的類型和值

  ?>

</body>

</html>