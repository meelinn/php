<?php
header("content-Type:text/plain"); #設定檔頭(文件格式):純文字

# date_default_timezone_set("Asia/Taipei"); #設定時區
echo date("Y-m-d H:i:s"); #預設時區在柏林 #拿到的是當下時間戳記

# 改設定檔的方式:
# C:\xampp\php>php.ini 搜尋:timezone改成Asia/Taipei
# 存檔後,Apache重新開啟

echo "\n"; #因header設定為純文字,使用<br>不會換行

echo date("Y-m-d H:i:s", time() + 15 * 24 * 60 * 60); #+15天

echo "\n";

echo date("Y-m-d H:i:s", strtotime('2023-04-28')); #指定日期

echo "\n";

echo date("N D", strtotime('2023-04-28')); #星期
