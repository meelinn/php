<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo '我的網站' ?>常數</title>
</head>

<body>

  <?php

  echo 12 + 34;
  echo '<br>';
  echo __DIR__ . '<br>';  #當前檔案所在目錄
  # . 表示字串的串接 
  # + 只做數值相加,不做字串串接

  echo __FILE__ . '<br>'; #當前檔案所在的位置(包含檔案)

  echo __LINE__ . '<br>'; #目前第幾行
  echo true . '<br>';
  ?>

</body>

</html>