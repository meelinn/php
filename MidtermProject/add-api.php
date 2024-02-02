<?php
require __DIR__ . '/parts/pdo-connect.php';
$output = [
  'success' => false, #資料傳輸過來有沒有新增成功
  'postData' => $_POST,
  'error' => '',
  'code' => 0, #追蹤程式執行的編號

];


if (!empty($_POST)) //檢查欄位是不是空的=長度為0的欄位
{

  //TODO:檢查各個欄位的資料,有沒有符合規定
  //檢查姓名欄位
  if (strlen($_POST['name']) < 1) {
    $output['error'] = '請填寫姓名';
    $output['code'] = 300;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
  };

  if (strlen($_POST['shelter']) < 1) {
    $output['error'] = '請選擇收容所';
    $output['code'] = 300;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
  };

  $birthday = !empty($_POST['birthday']) ? date('Y-m-d', strtotime($_POST['birthday'])) : null; #不是必填的狀況
  if (!empty($_POST['birthday'])) { #!empty=不是空的
    $birthday = strtotime($_POST['birthday']);
    if ($birthday === false) {
      $output['error'] = '錯誤的日期';
      $output['code'] = 300;
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    } else {
      $birthday = date('Y-m-d', $birthday);
    }
  }

  // $mobile = filter_var($_POST['mobile'], FILTER_VALIDATE_REGEXP,);
  // if ($mobile === false) {
  //   $output['error'] = '請填寫正確的Email';
  //   $output['code'] = 300;
  //   echo json_encode($output, JSON_UNESCAPED_UNICODE);
  //   exit;
  // }

  $sql = "INSERT INTO `animal_info` (
    `animal_name`,
    `fk_animal_type_id`,
    `animal_age`,
    `fk_animal_gender_id`,
    `animal_birthday`,
    `fk_animal_color`,
    `fk_animal_photo_id`,
    `fk_shelter_id`,
    `animal_story`,
    `animal_qualities`,
    `animal_simple_narrative`,
    `fk_animal_state_id`,
    `fk_animal_medical_record_id`,
    `fk_animal_behavior_id`
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


  $stmt = $pdo->prepare($sql); //會做SQL的跳脫,所以不用+''//先prepare再execute,是一組的,可避免攻擊
  $stmt->execute([
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

  // password_hash($_POST['password'],PASSWORD_DEFAULT),//雜湊密碼加密方式
};

header('Content-Type: application/json'); #header檔頭標準格式
echo json_encode($output, JSON_UNESCAPED_UNICODE);#JSON_UNESCAPED_UNICODE字串不跳脫
#不做畫面呈現,純功能