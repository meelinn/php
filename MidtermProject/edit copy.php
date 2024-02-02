<?php
require __DIR__ . '/parts/admin-required.php'; #沒登入不能操作
require __DIR__ . '/parts/pdo-connect.php';
$title = '修改資訊'; #設定TITLE
$page_name = 'edit';

$animal_id = isset($_GET['animal_id']) ? intval($_GET['animal_id']) : 0;
if (empty($animal_id)) { #沒有值就直接跳回list
  header('Location: list.php');
  exit;
}

$sql = "SELECT * FROM animal_info WHERE animal_id=$animal_id";
$row = $pdo->query($sql)->fetch(); #沒有問號不用prepare
if (empty($row)) { #沒有值就直接跳回list
  header('Location: list.php');
  exit;
}


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

  <div class="row">

    <form name="form1" onsubmit="sendData(event)">
      <!-- 此處不用method="post",因為沒有要用傳統的表單送出  -->
      <input type="hidden" name="animal_id" value="<?= $row['animal_id'] ?>">

      <!-- 名字 -->
      <div class="mb-3">
        <label for="name" class="form-label">名字</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($row['animal_name']) ?>">
        <div class="form-warning-text"></div>
      </div>
      <!-- 類型 -->
      <div class="mb-3">
        <label for="type" class="form-label">類型</label>
        <select class="form-select" aria-label="select" name="type" id="type">
          <?php
          $animalTypeId = $row['fk_animal_type_id'];
          $animalType = htmlentities(fetchAnimalType($pdo, $animalTypeId));

          // 選擇預設選項
          echo "<option value=\"$animalTypeId\" selected>$animalType</option>";

          // 使用其他外鍵值填充選項
          $animalTypes = getAllAnimalTypes($pdo);

          foreach ($animalTypes as $type) {
            $typeId = $type['animal_type_id'];
            $typeName = htmlentities($type['animal_type']);

            // 排除預設選項，避免重複
            if ($typeId !== $animalTypeId) {
              echo "<option value=\"$typeId\">$typeName</option>";
            }
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">儲存</button>
    </form>

  </div>
</div>
</div>

<!-- 抓FK資料 -->
<?php
function fetchAnimalPhoto($pdo, $animal_photo_id)
{
  $sql = "SELECT animal_photo_url FROM animal_photo WHERE animal_photo_id = :animal_photo_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':animal_photo_id', $animal_photo_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return ($result) ? $result['animal_photo_url'] : '';
}
function getAllAnimalTypes($pdo)
{
  $stmt = $pdo->prepare("SELECT animal_type_id, name FROM animal_type");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Debugging
  var_dump($result);

  return $result;
}
function fetchAnimalType($pdo, $animal_type_id)
{
  $sql = "SELECT animal_type FROM animal_type WHERE animal_type_id = :animal_type_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':animal_type_id', $animal_type_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return ($result) ? $result['animal_type'] : '';
}

function fetchAnimalGender($pdo, $animal_gender_id)
{
  $sql = "SELECT animal_gender FROM animal_gender WHERE animal_gender_id = :animal_gender_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':animal_gender_id', $animal_gender_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return ($result) ? $result['animal_gender'] : '';
}

function fetchShelter($pdo, $shelter_id)
{

  $sql = "SELECT shelter_name FROM shelter_info WHERE shelter_id = :shelter_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':shelter_id', $shelter_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return ($result) ? $result['shelter_name'] : '';
}
?>

<!-- Modal-成功 -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">修改結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a href="list.php" class="btn btn-primary">回到列表頁</a>
        <!-- a標籤+onclick="backToList()" -->
      </div>
    </div>
  </div>
</div>

<!-- Modal-失敗 -->
<div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">修改結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert" id="failureInfo">
          資料修改失敗
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>

        <!-- a改btn???? -->
        <button href="list.php" class="btn btn-primary" onclick="backToList()">跳至列表頁</button>
      </div>
    </div>
  </div>
</div>
<!-- 主要內容結束 -->
<?php include __DIR__ . '/parts/script.php'
?>
<script>
  function backToList() {
    if (document.referrer) {
      location.href = document.referrer;
    } else {
      location.href = "list.php";
    }
  }

  const {
    name: nameEl,
    email: emailEl,
    mobile: mobileEl
  } = document.form1 //以解構的方式拿資料El=Element
  //物件document.form1的屬性設定在{}裡面

  const fields = [nameEl, emailEl, mobileEl]; //抓每個欄位成陣列,下面回復欄位迴圈需用到

  function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  function validateMobile(mobile) {
    const re = /^09\d{2}-?\d{3}-?\d{3}$/ //檢查字串
    return re.test(mobile);
  }

  function sendData(e) {
    //回復欄位的外觀
    /*   nameEl.style.border = '1px solid #CCC';
    nameEl.nextElementSibling.innerHTML = '';
    emailEl.style.border = '1px solid #CCC';
    emailEl.nextElementSibling.innerHTML = '';
    mobilEl.style.border = '1px solid #CCC';
    mobilEl.nextElementSibling.innerHTML = '';  
    改寫成迴圈:*/

    for (let el of fields) {
      el.style.border = '1px solid #CCC';
      el.nextElementSibling.innerHTML = '';
    }

    e.preventDefault(); //不要讓表單以傳統方式送出

    let isPass = true; //整個表單有沒有通過檢查
    //return; //讓以上沒有功能

    //TODO:檢查表單個欄位有沒有符合規範
    if (nameEl.value.length < 2) {
      isPass = false; //名字字元<2=不通過
      /*alert('請填寫正確姓名');
      return;*/
      nameEl.style.border = '1px solid red';
      nameEl.nextElementSibling.innerHTML = '請填寫正確的姓名';
    }

    if (emailEl.value && !validateEmail(emailEl.value)) {
      isPass = false;
      emailEl.style.border = '1px solid #red';
      emailEl.nextElementSibling.innerHTML = '請填寫正確的Email';
    }

    if (mobileEl.value && !validateMobile(mobileEl.value)) {
      isPass = false;
      mobileEl.style.border = '1px solid #red';
      mobileEl.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
    }

    if (isPass) { //if(isPass){}通過才送出表單
      const fd = new FormData(document.form1);
      //把表單內容複製到沒有外觀的表單物件(有外觀=上面form標籤,有外觀才能讓使用者輸入資料)fd變數名稱=formdata , new+類型(FormData)}

      //fetch(送到哪裡,用甚麼方式)
      fetch(`edit-api.php`, { //TypeScript
        method: 'POST',
        body: fd
      }).then(r => r.json()).then(data => {
        console.log(data);
        if (data.success) {
          /* 更改為BOOTSTRAP的彈窗
         alert('資料修改成功');
          location.href = 'list.php';
        } else {
          alert('資料修改失敗\n' + data.error);*/
          successModal.show();
        } else {
          document.querySelector('#failureInfo').innerHTML = data.error;
          failureModal.show();
        }

      }) //data => {}輸出到add-api-output
    }
  }

  const successModal = new bootstrap.Modal(document.getElementById('successModal'), Option);
  const failureModal = new bootstrap.Modal(document.getElementById('failureModal'), Option);
</script>