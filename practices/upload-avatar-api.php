<?php
$output = [
  'success' => false
];

#檔案篩選,決定副檔名
#mime-Type => .副檔名
$exts = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
  'image/webp' => '.webp',
];

$f = sha1(uniqid() . rand()); #隨機主檔名 #sha1=40個字元,16進位

#先確定有上傳的欄位
if (!empty($_FILES) and !empty($_FILES['avatar'])) {

  $output['code'] = 100; #上傳過程出錯.無上傳檔案
  #再確定上傳過程有無出錯
  if ($_FILES['avatar']['error'] === 0) {

    $output['code'] = 200; #類型條件不符合
    #判斷類型是否符合我們的條件
    if (!empty($exts[$_FILES['avatar']['type']])) {

      $output['code'] = 300; #上傳成功
      #依照mime-type決定副檔名
      $ext = $exts[$_FILES['avatar']['type']]; #副檔名

      #__DIR__最後拿到的資料夾#'/../imgs/' 最後沒+/就會變成檔名
      $filename = __DIR__ . '/../imgs/' . $f . $ext;
      $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $filename);
      $output['success'] = $result;
      $output['filename'] = $f . $ext;
    }
  }
};

header(`Content-Type:application/json`);
echo json_encode($output);

#多檔案上傳:用foreach抓name