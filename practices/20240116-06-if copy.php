<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<!-- 以上也都是echo -->

<body>

  <!-- 傳統php寫法 -->
  <?php
  $age = isset($_GET['age']) ? intval($_GET['age']) : 0;
  if ($age >= 18) {
  ?>
    <!-- 沒有被php標籤包起來的都等於echo -->
    echo "<h2>歡迎光臨</h2>
    <img src="https://i.natgeofe.com/n/548467d8-c5f1-4551-9f58-6817a8d2c45e/NationalGeographic_2572187_2x3.jpg" width="300">;
  <?php
  } else {
  ?>
    echo "<h2>請勿進入</h2>
    <img src="https://www.purina.co.uk/sites/default/files/2023-03/Hero%20Pedigree%20Cats.jpg" width="300">;
  <?php
  }
  ?>

</body>

</html>