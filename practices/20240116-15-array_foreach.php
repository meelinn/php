<pre>
<?php
$ar = array(
  100,
  'name' => 'Shin',
  'age' => 28,
  200
);

#foreach (陣列變數 as Key變數=>Value變數)
foreach ($ar as $a) {
  echo "$a \n";
};
echo  "<hr>";

foreach ($ar as $value) {
  echo "$value\n";
};
echo  "<hr>";

// $v=$value , $k=$key
foreach ($ar as $k => $v) {
  echo "$k : $v \n";
};

?>


</pre>