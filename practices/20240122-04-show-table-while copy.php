<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

</body>

</html><?php
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = 'Pass1Mii!3wOrd'; #password
        $db_name = 'project';
        # $db_port='3307'; #不是3307的時候要設定

        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

        #$dsn = "mysql:host={$db_host};dbname={$db_name};port=3307;charset=utf8mb4";#不是3307的時候要設定


        #$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); #用關聯式陣列改寫:
        $pdo_options = [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        try {

          $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_opctions);

          $stmt = $pdo->query("SELECT*FROM address_book ORDER BY sid DESC LIMIT 10,10");
          #ORDER BY sid DESC降冪排列
          #LIMIT 3=前三筆,LIMIT 10,10 索引值,最多拿X筆

        } catch (PDOException $ex) {
          echo $ex->getMessage();
        };

        ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">編號</th>
          <th scope="col">姓名</th>
          <th scope="col">信箱</th>
          <th scope="col">手機號碼</th>
          <th scope="col">生日</th>
          <th scope="col">地址</th>
        </tr>
      </thead>
      <tbody>
        <!-- $stmt指向第一筆 -->
        <?php while ($r = $stmt->fetch()) : ?>
          <tr>
            <td><?= $r['sid'] ?></td>
            <td><?= $r['name'] ?></td>
            <td><?= $r['email'] ?></td>
            <td><?= $r['mobile'] ?></td>
            <td><?= $r['birthday'] ?></td>
            <td><?= $r['address'] ?></td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </div>
  <script>
    throw new Error('測試');
  </script>

</body>

</html>