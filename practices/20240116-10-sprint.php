<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<!-- 以上也都是echo -->

<body>
  <table border="1">
    <?php for ($i = 2; $i <= 9; $i++) : ?>
      <tr>
        <?php for ($k = 1; $k <= 9; $k++) : ?>
          <!-- 挖三個坑再把變數擺進去 -->
          <td><?= printf('%s*%s=%s', $i, $k, $i * $k) ?></td>
          <!-- s=string -->
          <!-- <td><?= sprintf('%s*%s=%s', $i, $k, $i * $k) ?></td> -->
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>

  </table>

</body>

</html>