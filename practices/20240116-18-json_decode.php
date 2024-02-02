<pre>
  <?php
  $str = '{"name":"小明","age":"25"}';
  $ar = json_decode($str);
  $ar_true = json_decode($str, true); #true=表示轉換為關聯式陣列,無設定=拿到php物件

  # php -> = js. = 的

  var_dump($ar);
  echo "$ar->name";
  echo $ar[0]; #undefind
  echo "<hr>";
  var_dump($ar_true);

  ?>
</pre>