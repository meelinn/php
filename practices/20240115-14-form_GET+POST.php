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
  <h2>GET</h2>
  <pre><?php
        #if如果 !NOT empty=空的 =>如果不是空的才會顯示
        if (!empty($_GET)) var_dump($_GET);
        ?></pre>

  <h2>POST</h2>
  <pre><?php
        if (!empty($_POST)) var_dump($_POST);
        ?></pre>

  <!-- action只有填參數=在此PHP上,方法為POST,可以同時進行 -->
  <form action="?name=Peter&age=30" method="post">
    <label for="username">USERNAME</label>
    <input type="text" id="username" name="a" placeholder="帳號">
    <label for="password">PASSWORD</label>
    <input type="text" id="password" name="b" placeholder="密碼">
    <!-- <button>送出</button> form裡的預設button為submit
    <button type="button">button送出</button> type="button"則為一般按鈕-->
    <input type="submit" value="送出">
  </form>

  <script></script>

</body>

</html>