<pre>
<?php

#索引式陣列
$ar1 = array(1, 2, 3, 4, 5, 6);
$ar2 = [1, 2, 3, 4, 5, 6];

print_r($ar1);
// print_r=查看陣列
var_dump($ar2);


#關聯式陣列=key,value
$ar3 = array(
  #=>胖箭頭,->瘦箭頭
  'name' => 'Shin',
  'age' => 28
);

$ar4 = [
  'name' => 'Shin',
  'age' => 28,
];
print_r($ar4);

$ar5 = array(
  100,
  'name' => 'Shin',
  'age' => 28,
  200
);
print_r($ar5);
echo $ar5['name'] . "<br>";
echo $ar5[0] . "<br>";
echo count($ar5); #4個元素

?>

</pre>