<?php
require __DIR__ . '/parts/pdo-connect.php';
$output = [
  'success' => false, #資料傳輸過來有沒有新增成功
  'postData' => $_POST,
  'error' => '資料沒有修改',
  'code' => 0, #追蹤程式執行的編號
];

// echo json_encode($output, JSON_UNESCAPED_UNICODE);
// exit;

if (!empty($_POST && !empty($_POST['sid']))) //檢查欄位是不是空的=長度為0的欄位
{
  //TODO:檢查各個欄位的資料,有沒有符合規定
  //檢查姓名欄位
  // if (strlen($_POST['name']) < 2) {
  //   $output['error'] = '請填寫正確的姓名';
  //   $output['code'] = 300;
  //   echo json_encode($output, JSON_UNESCAPED_UNICODE);
  //   exit;
  // };

  // $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  // if ($email === false) {
  //   #$email = ''; #不是必填的狀況,但設定不能給空值
  //   #必填的狀況:
  //   $output['error'] = '請填寫正確的Email';
  //   $output['code'] = 300;
  //   echo json_encode($output, JSON_UNESCAPED_UNICODE);
  //   exit;
  // }

  // $birthday = null; #不是必填的狀況
  // if (!empty($_POST['birthday'])) { #!empty=不是空的
  //   $birthday = strtotime($_POST['birthday']);
  //   if ($birthday === false) {
  //     #不是合法的日期字串
  //     $birthday = null;
  //   } else {
  //     $birthday = date('Y-m-d', $birthday);
  //   }
  // }

  // $mobile = filter_var($_POST['mobile'], FILTER_VALIDATE_REGEXP,);
  // if ($mobile === false) {
  //   $output['error'] = '請填寫正確的Email';
  //   $output['code'] = 300;
  //   echo json_encode($output, JSON_UNESCAPED_UNICODE);
  //   exit;
  // }


  //UPDATE語法
  $sql = "UPDATE `animal_info` SET `animal_id`='?',`animal_name`=?,`fk_animal_type_id`=?,`animal_age`=?,`fk_animal_gender_id`=?,`animal_birthday`=?,`fk_animal_color`=?,`fk_animal_photo_id`=?,`fk_shelter_id`=?,`animal_story`=?,`animal_qualities`=?,`animal_simple_narrative`=?',`fk_animal_state_id`=?,`fk_animal_medical_record_id`=?,`fk_animal_behavior_id`=? `animal_id`=?"; //edit的上方的隱藏欄位


  $stmt = $pdo->prepare($sql);
  $stmt->execute([ //會做SQL的跳脫,所以不用+''//先prepare再execute,是一組的,可避免攻擊
    $_POST['name'],
    $_POST['type'],
    $_POST['age'],
    $_POST['gender'],
    $birthday,
    $_POST['color'],
    $_POST['photo'],
    $_POST['shelter'],
    $_POST['story'],
    $_POST['qualities'],
    $_POST['narrative'],
    $_POST['state'],
    $_POST['medical'],
    $_POST['behavior']
  ]);

  /*原本的VALUES 
    ('%s','%s','%s','%s','%s', NOW())"有可能被攻擊
    須改寫成$pdo->query($_POST['name']),
    */

  //%s第一格name={$_POST.name}//NOW()取得當下時間

  //PDOStatement
  //$stmt = $pdo->query($sql);
  $output['code'] = 200;
  $output['success'] = boolval($stmt->rowCount()); //取得資料筆數//資料沒有修改會拿到0,有修才會拿到1
}

$backTo = 'list.php';
//HTTP_REFERER=網頁檢查>network>header>REFERER
if (!empty($_SERVER['HTTP_REFERER'])) {
  $backTo = $_SERVER['HTTP_REFERER'];
}

header('Content-Type: application/json' . $backTo); #header檔頭標準格式
echo json_encode($output, JSON_UNESCAPED_UNICODE);#JSON_UNESCAPED_UNICODE字串不跳脫
#不做畫面呈現,純功能