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
$sql = "SELECT  ai.*,
ast.animal_state AS animal_state,
ac.animal_color AS animal_color,
at.animal_type AS animal_type,
ag.animal_gender AS animal_gender,
ab.animal_behavior AS animal_behavior,
aib.animal_degree AS animal_degree,
amr.animal_medical_record AS animal_medical_record,
amr.checkup_date AS checkup_date,
si.shelter_name AS shelter_name,
aph.animal_photo_url AS animal_photo_url
FROM animal_info ai
JOIN animal_state ast ON ai.fk_animal_state_id = ast.animal_state_id
JOIN animal_photo aph ON ai.fk_animal_photo_id = aph.animal_photo_id
JOIN shelter_info si ON ai.fk_shelter_id = si.shelter_id
JOIN animal_medical_record amr ON ai.fk_animal_medical_record_id = amr.animal_medical_record_id
JOIN animal_behavior ab ON ai.fk_animal_behavior_id = ab.animal_behavior_id
JOIN animal_type at ON ai.fk_animal_type_id = at.animal_type_id
JOIN animal_gender ag ON ai.fk_animal_gender_id = ag.animal_gender_id
JOIN animal_color ac ON ai.fk_animal_color = ac.animal_color_id
JOIN animalinfo_behavior aib ON ai.animal_id = aib.fk_animal_id
WHERE ai.animal_id = :animal_id";  // 添加 WHERE 子句以限制 animal_id

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
