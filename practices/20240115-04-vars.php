<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP

  $age = 10; #設定值給變數
  #$2=1;#不可以是數字開頭
  $name = 'David';
  echo $age . '<br>';

  #isset()判斷變數有沒有設定
  isset($name);
  echo $name;
  echo '<br>';

  #改寫為if else
  if (isset($name)) {
    echo $name;
  } else {
    echo 'noname';
  };

  echo '<br>';

  #改寫為三元運算子
  echo isset($name) ? $name : 'noname';

  ?>

</body>

</html>