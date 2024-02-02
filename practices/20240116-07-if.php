<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<!-- 以上也都是echo -->

<body>

  <?php
  $age = isset($_GET['age']) ? intval($_GET['age']) : 0;

  if ($age >= 18) :
  ?>
    <h2>歡迎光臨</h2>
    <img src="https://static01.nyt.com/images/2023/12/12/climate/12cli-cats/12cli-cats-videoSixteenByNineJumbo1600.jpg" width="300">
  <?php
  else :
  ?>
    <h2>長大後再來</h2>
    <img src="https://cdn.theatlantic.com/thumbor/B7U27JF25tScMZkCe5Pl9EqXjao=/0x131:2555x1568/960x540/media/img/mt/2017/06/shutterstock_319985324/original.jpg" width="300">
  <?php
  endif;
  ?>

</body>

</html>