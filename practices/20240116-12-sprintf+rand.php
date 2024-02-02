<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    td {
      width: 30px;
      height: 30px;
      background-color: #000;
    }
  </style>
</head>

<body>

  <table style="background-image:url(https://www.purina.co.uk/sites/default/files/2023-03/Hero%20Pedigree%20Cats.jpg) ;">
    <?php for ($i = 0; $i < 16; $i++) : ?>
      <tr>
        <?php for ($k = 0; $k < 16; $k++) : ?>
          <td style="background-color: 
          #<?=
            #rand(0, 15)亂數,可指定(最小值,最大值)
            sprintf('000%X', rand(0, 15)) ?>"></td>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>

</html>