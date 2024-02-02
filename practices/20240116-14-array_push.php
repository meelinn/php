<pre>
<?php
$ar = []; #非必要,只是說明ar為陣列
for ($i = 1; $i < 42; $i++) {
  $ar[] = $i; //array push
}
echo $ar[2];
echo "<hr>";

print_r($ar);
echo "<hr>";

echo implode(",", $ar); #implode()=把陣列串接成字串
echo "<hr>";

$ar2 = explode('r', 'string', 100); #explode()把字串切成陣列
print_r($ar2);
echo "<hr>";

shuffle($ar); #亂數排序,執行順序由上到下,不會影響到上面的(跟consolog不一樣)
echo implode(",", $ar);


?>


</pre>