<?php
require __DIR__ . '/parts/admin-required.php'; #沒登入不能操作
require __DIR__ . '/parts/pdo-connect.php';
$title = '新增浪浪資訊'; #設定TITLE
$page_name = 'add';
?>


<style>
  span {
    color: red;
  }

  .form-warning-text {
    color: red;
  }
</style>
<!-- 主要內容開始 -->
<div class="container">
  <form name="form1" onsubmit="sendData(event)">
    <!-- 此處不用method="post",因為沒有要用傳統的表單送出  -->

    <!-- 照片  -->
    <div class="row">
      <div class="col mb-3">
        <label for="name" class="form-label">上傳圖片</label>
        <input type="text" class="form-control" id="photo" name="photo" placeholder="請輸入圖片網址">
        <div class="form-warning-text"></div>
        <!--  照片預覽 
      <div class="col mb-3">
        <label class="form-label">上傳照片</label>
        <div class="col mb-3">
          <img id="blah" alt="照片預覽" width="100" />
        </div>
      </div>
      照片上傳 
      <div class="col mb-3">

    <input class="form-control" type="file" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" accept="image/*" name="photo" id="photo">
    <div class="form-warning-text"></div>-->
      </div>


      <!-- 名字.收容所 -->
      <div class="row">

        <!-- 名字 -->
        <div class="col mb-3">
          <label for="name" class="form-label">名字</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="請輸入名字">
          <div class="form-warning-text"></div>
        </div>
        <!-- 收容所 -->
        <div class="col">
          <label for="shelter" class="form-label">所在收容所</label>
          <select class="form-select" aria-label="select" id="shelter" name="shelter">
            <!-- 預設值省略或設為合適的預設值 -->
            <option value="" selected disabled>請選擇收容所</option>

            <!-- 填充選項 -->
            <?php
            $shelter = getAllShelter($pdo);

            foreach ($shelter as $shelter) {
              $shelterId = $shelter['shelter_id'];
              $shelterName = htmlentities($shelter['shelter_name']);

              echo "<option value=\"$shelterId\">$shelterName</option>";
            }
            ?>
          </select>
          <div class="form-warning-text"></div>
        </div>
      </div>

      <!-- 類型.性別.花色 -->
      <div class="row">
        <!-- 類型 -->
        <div class="col mb-3">
          <label for="type" class="form-label">類型</label>
          <select class="form-select" aria-label="select" name="type" id="type">
            <!-- 預設值省略或設為合適的預設值 -->
            <option value="" selected disabled>請選擇類型</option>

            <!-- 填充選項 -->
            <?php
            $animalTypes = getAllAnimalTypes($pdo);

            foreach ($animalTypes as $type) {
              $typeId = $type['animal_type_id'];
              $typeName = htmlentities($type['animal_type']);

              echo "<option value=\"$typeId\">$typeName</option>";
            }
            ?>
          </select>
          <div class="form-warning-text"></div>
        </div>

        <!-- 性別 -->
        <div class="col">

          <label for="gender" class="form-label">性別</label>
          <select class="form-select" aria-label="select" name="gender" id="gender">
            <!-- 預設值省略或設為合適的預設值 -->
            <option value="" selected disabled>請選擇性別</option>

            <!-- 填充選項 -->
            <?php
            $animalGender = getAllAnimalGender($pdo);

            foreach ($animalGender as $gender) {
              $genderId = $gender['animal_gender_id'];
              $genderName = htmlentities($gender['animal_gender']);

              echo "<option value=\"$genderId\">$genderName</option>";
            }
            ?>
          </select>
          <div class="form-warning-text"></div>
        </div>

        <!-- 花色 -->
        <div class="col">
          <label for="color" class="form-label">花色</label>
          <select class="form-select" aria-label="select" name="color" id="color">
            <!-- 預設值省略或設為合適的預設值 -->
            <option value="" selected disabled>請選擇花色</option>

            <!-- 填充選項 -->
            <?php
            $animalColor = getAllAnimalColor($pdo);

            foreach ($animalColor as $color) {
              $colorId = $color['animal_color_id'];
              $colorName = htmlentities($color['animal_color']);

              echo "<option value=\"$colorId\">$colorName</option>";
            }
            ?>
          </select>
          <div class="form-warning-text"></div>
        </div>
      </div>

      <!-- 年紀.生日 -->
      <div class="row">
        <!-- 年紀 -->
        <div class="col mb-3">
          <label for="age" class="form-label">年齡</label>
          <input type="number" class="form-control" id="age" name="age" placeholder="請輸入年齡">
          <div class="form-warning-text"></div>
        </div>
        <!-- 生日 -->
        <div class="col mb-3">
          <label for="birthday" class="form-label">生日</label>
          <!-- datetime-local : 日期含時間格式 -->
          <input type="date" class="form-control" id="birthday" name="birthday">
          <div class="form-warning-text"></div>
        </div>
      </div>
      <!-- 特質.簡述 -->
      <div class="row">
        <!-- 特質 -->
        <div class="col mb-3">
          <label for="qualities" class="form-label">個性特質</label>
          <input type="text" class="form-control" id="qualities" name="qualities" placeholder="溫柔 / 好動 / 安靜 ...">
          <div class="form-warning-text"></div>
        </div>
        <!-- 簡述 -->
        <div class="col mb-3">
          <label for="narrative" class="form-label">浪浪簡述</label>
          <input type="text" class="form-control" id="narrative" name="narrative" placeholder="外表與個性簡述">
          <div class="form-warning-text"></div>
        </div>
      </div>
      <!-- 行為.程度 -->
      <div class="row">
        <!-- 行為 -->
        <div class="col mb-3">
          <label for="behavior" class="form-label">行為</label>
          <select class="form-select" aria-label="select" name="behavior" id="behavior">
            <!-- 預設值省略或設為合適的預設值 -->
            <option value="" selected disabled>請選擇行為</option>

            <!-- 填充選項 -->
            <?php
            $animalBehavior = getAllAnimalBehavior($pdo);

            foreach ($animalBehavior as $behavior) {
              $behaviorId = $behavior['animal_behavior_id'];
              $behaviorName = htmlentities($behavior['animal_behavior']);

              echo "<option value=\"$behaviorId\">$behaviorName</option>";
            }
            ?>
          </select>
          <div class="form-warning-text"></div>
        </div>
        <!-- 程度 -->
        <!-- <div class="col mb-3">
          <label for="degree" class="form-label">程度</label>
          <select class="form-select" aria-label="select" name="degree" id="degree">
            <option value="" selected disabled>請選擇程度</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <div class="form-warning-text"></div>
        </div> -->
      </div>

      <!-- 健康狀態 -->
      <div class="row">
        <!-- 健康狀態 -->
        <div class="col mb-3">
          <label for="state" class="form-label">健康狀態</label>
          <input type="text" class="form-control" id="state" name="state" placeholder="定期驅蟲 / 結紮 / 晶片 / 疫苗 ...">
          <div class="form-warning-text"></div>
        </div>

      </div>


      <!-- 醫療史.檢查日期 -->
      <div class="row">
        <!-- 醫療史 -->
        <div class="col mb-3">
          <label for="medical" class="form-label" name="medical">醫療史</label>
          <textarea type="text" rows="3" class="form-control" id="medical" name="medical" placeholder="請輸入醫療史"></textarea>
          <div class="form-warning-text"></div>
        </div>
        <!-- 檢查日期 -->
        <!-- <div class="col mb-3">
<label for="check" class="form-label">檢查日期</label>-->
        <!-- datetime-local : 日期含時間格式
    <input type="date" class="form-control" id="check" name="check">
    <div class="form-warning-text"></div>
  
    </div> -->
      </div>
    </div>

    <!-- 故事 -->
    <div class="col mb-3">
      <label for="story" class="form-label">背景故事</label>
      <textarea type="text" rows="5" class="form-control" id="story" name="story" placeholder="請輸入背景故事"></textarea>
      <div class="form-warning-text"></div>
    </div>

    <!-- 新增btn -->
    <button type="submit" class="btn btn-primary justify-content-end">新增</button>
  </form>
</div>

<!-- 抓FK資料 -->
<?php

function getAllAnimalTypes($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT animal_type_id, animal_type FROM animal_type");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    // 錯誤處理：輸出錯誤信息，或者根據您的需求執行其他操作
    echo "Error: " . $e->getMessage();
    return array(); // 返回空數組表示出現錯誤
  }
}

// 檢查輸出的動物類型
// $animalTypes = getAllAnimalTypes($pdo);
// var_dump($animalTypes); 

function getAllAnimalGender($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT animal_gender_id, animal_gender FROM animal_gender");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    // 錯誤處理：輸出錯誤信息，或者根據您的需求執行其他操作
    echo "Error: " . $e->getMessage();
    return array(); // 返回空數組表示出現錯誤
  }
}

// $animalGender = getAllAnimalGender($pdo);
// var_dump($animalGender);

function getAllAnimalColor($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT animal_color_id, animal_color FROM animal_color");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    // 錯誤處理：輸出錯誤信息，或者根據您的需求執行其他操作
    echo "Error: " . $e->getMessage();
    return array(); // 返回空數組表示出現錯誤
  }
}

function getAllAnimalBehavior($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT animal_behavior_id,animal_behavior FROM animal_behavior");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    // 錯誤處理：輸出錯誤信息，或者根據您的需求執行其他操作
    echo "Error: " . $e->getMessage();
    return array(); // 返回空數組表示出現錯誤
  }
}

// $animalBehavior = getAllAnimalBehavior($pdo);
// var_dump($animalBehavior);

function getAllShelter($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT shelter_id, shelter_name FROM shelter_info");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    // 錯誤處理：輸出錯誤信息，或者根據您的需求執行其他操作
    echo "Error: " . $e->getMessage();
    return array(); // 返回空數組表示出現錯誤
  }
}

?>

<!-- 主要內容結束 -->
<script>
  // const avatar = document.uploadForm.avatar;
  // avatar.onchange = (event) => {
  //   const fd = new FormData(document.uploadForm);
  //   fetch('upload-avatar-api.php', {
  //       method: 'POST',
  //       body: fd
  //     })
  //     .then(r => r.json())
  //     .then((result) => {
  //       if (result.success) {

  //         //result.filename
  //         img_file.value = result.filename;
  //         my_img.src = `../imgs/${result.filename}`;
  //       }
  //     })
  //     .catch((ex) => console.log(ex));
  // }
</script>
<?php include __DIR__ . '/parts/script.php'
?>