<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP
  $b = 5 and 7;
  $c = (5 and 7);

  echo $b; #5
  echo '<br>';
  var_dump($b); #int(5)
  echo '<br>';

  echo $c;
  echo '<br>'; #1
  var_dump($c); #bool(true)


  ?>

</body>

</html>