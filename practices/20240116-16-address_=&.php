<pre>
<?php
$a = 10;
$b = &$a; #只在=設定給值的時候,才能用& 把$a位址設定給$b
$b = 5;

echo $a;

?>


</pre>