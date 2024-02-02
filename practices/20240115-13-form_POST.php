<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>20240115-11-query_string_plus_form
  </title>
  <style>
    input {
      display: block;
      width: 150px;
    }
  </style>
</head>

<body>
  <pre>
  <?php
  if (!empty($_POST)) var_dump($_POST);
  ?>
</pre>

  <!-- action的php為GET動作,所以設定post抓不到值=0 -->
  <form action="" method="post">
    <label for="username">USERNAME</label>
    <input type="text" id="username" name="a" placeholder="帳號">
    <label for="password">PASSWORD</label>
    <input type="text" id="password" name="b" placeholder="密碼">
    <!-- <button>送出</button> form裡的預設button為submit
    <button type="button">button送出</button> type="button"則為一般按鈕-->
    <input type="submit" value="送出">
  </form>

</body>

</html>