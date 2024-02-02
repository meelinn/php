<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= /*簡寫成?= , 用簡寫後面一定不能空白 , 只寫一個echo就結束才可以簡寫*/ '我的網站' ?>常數</title>
</head>

<body>

  <?PHP

  $name = "David
  Lin";
  #換行只有影響HTML原始碼的格式

  #雙引號:如有變數內容,會帶入變數
  echo "Hello $name <br>";
  echo "Hello" . $name . "<br>"; #用接的方法,同上
  echo "Hello $name<br>";

  #單引號:單純顯示內容
  echo 'Hello $name <br>';

  #{}區隔變數與一般字串 
  echo "Hello $name3<br>"; #錯誤
  echo "Hello {$name}3<br>";

  echo "\"abc\nxyz\"--- \'==='<br>";
  echo '\'abc\nxyz\"--- \'===`<br>';

  ?>

</body>

</html>