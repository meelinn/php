<?php $str = '>"<';
header('Content-Type: text/plain');
echo htmlentities($str);
