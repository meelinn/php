<?php
require __DIR__ . '/parts/admin-required.php'; #沒登入不能操作
require __DIR__ . '/parts/pdo-connect.php';

# 檢查是否有提供 animal_id
if (!isset($_GET['animal_id']) || !is_numeric($_GET['animal_id'])) {
  echo 'Invalid animal_id';
   exit;
 }


$animal_id = $_GET['animal_id'];


# 查詢指定 animal_id 的動物資訊
$sql = "SELECT *
FROM animal_info
JOIN animal_state ON animal_info.fk_animal_state_id = animal_state.animal_state_id
JOIN animal_photo ON animal_info.fk_animal_photo_id = animal_photo.animal_photo_id
JOIN shelter_info ON animal_info.fk_shelter_id = shelter_info.shelter_id
JOIN animal_medical_record ON animal_info.fk_animal_medical_record_id = animal_medical_record.animal_medical_record_id
JOIN animal_behavior ON animal_info.fk_animal_behavior_id = animal_behavior.animal_behavior_id
JOIN animal_type ON animal_info.fk_animal_type_id = animal_type.animal_type_id
JOIN animal_gender ON animal_info.fk_animal_gender_id = animal_gender.animal_gender_id
JOIN animal_color ON animal_info.fk_animal_color = animal_color.animal_color_id
JOIN animalinfo_behavior ON animal_info.animal_id = animalinfo_behavior.fk_animal_id
WHERE animal_info.animal_id = :animal_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':animal_id', $animal_id, PDO::PARAM_INT);
$stmt->execute();

# 取得動物資訊
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

# 檢查是否有找到動物
if (!$animal) {
    echo 'Animal not found';
    exit;
}
if (empty($animal_id)) { #沒有值就直接跳回list
  header('Location: list.php');
  exit;
}
// if (!isset($animal['shelter_name'])) {
//   echo 'Shelter name not found';
//   var_dump($animal); // 輸出 $animal 陣列以進行調試
//   exit;
// }
?>

<!-- 主要內容開始 -->
<div class="container">
    <!-- 照片 -->
    <div class="row">
        <div class="col-6">
            <img src="<?= htmlentities($animal['animal_photo_url']) ?>" class="card-img-top" alt="Animal Photo">
            </div>
            <div class="col-6">
                <h3 class="card-title mb-3"><?= htmlentities($animal['animal_name']) ?></h3>
                <dl class="row"> 
                    <dt class="col-sm-3">所在地</dt>
                    <dd class="col-sm-9"><?= htmlentities($animal['shelter_name']) ?></dd>
                </dl>
               
        
    

<dl class="row">
  <dt class="col-sm-3">種類</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_type']) ?></dd>

  <dt class="col-sm-3">性別</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_gender']) ?></dd>

  <dt class="col-sm-3">花色</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_color']) ?></dd>

  <dt class="col-sm-3">年齡</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_age']) ?></dd>

  <dt class="col-sm-3">特質</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_qualities']) ?></dd>

  <dt class="col-sm-3">簡述</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_simple_narrative']) ?></dd>

  <dt class="col-sm-3">行為</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_behavior']) ?>  <span class=" badge rounded-pill bg-secondary "><?= htmlentities($animal['animal_degree']) ?></span> </dd>

  <dt class="col-sm-3">健康狀態</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_state']) ?></dd>

<dt class="col-sm-3">醫療史</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_medical_record']) ?> 
  <span class=" badge rounded-pill bg-secondary"><?= htmlentities($animal['checkup_date']) ?></span> </dd>

  <dt class="col-sm-3">背景故事</dt>
  <dd class="col-sm-9"><?= htmlentities($animal['animal_story']) ?></dd>
 </div>
</div>
</div>
<!-- 主要內容結束 -->
