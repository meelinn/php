<?php
$ar = [
  'name' => '小明',
  'age' => '30',
  'data' => 'abc/def',
  'data2' => [2, 4, 6],
];

# header()=設定回應的標頭
# Content-Type:appli=MIME Type
# 預設的Content-Type:text/heml(html格式)
header('Content-Type:application/json');

echo json_encode($ar, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
#JSON_UNESCAPED_UNICODE 中文字不跳脫
#JSON_UNESCAPED_SLASHES 符號/不跳脫

#echo第二次不顯示=因為一個合法JSON文件只會有一個物件,echo兩次=兩個合在一起的JSON=不合法=不顯示
echo json_encode($ar, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
