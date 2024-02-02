<?php
#資料庫連線
require __DIR__ . '/parts/pdo-connect.php';
$title = '浪浪資訊列表'; #設定TITLE
$page_name = 'list';

#4.設定使用者頁數
$page = isset($_GET['page']) ? $_GET['page'] : 1;

#設定頁數小於1的BUG
if ($page < 1) {
  header('Location:?page=1');
  exit; #到這裡就不再往下執行
}

#2.設定每頁最多有幾筆
$pre_page = 5;

#讀取資料
#1.算總筆數
$total_sql = "SELECT count(1) FROM animal_info";
$total_rows = $pdo->query($total_sql)->fetch(PDO::FETCH_NUM)[0];

#3.算總頁數
$total_pages = ceil($total_rows / $pre_page); #ceil=天花板=無條件進位

/* 測試用
echo json_encode([
  'Total Rows' => $total_rows,
]);
exit; #結束程式執行 */

$rows = []; #預設空陣列
#如果有資料的話才往下執行 ,避免沒資料出錯
if ($total_rows) {
  if ($page > $total_pages) {
    header('Location: ?page=' . $total_pages); # . = +的意思
    exit; #到這裡就不再往下執行
  }


  #5.取得分頁資料
  $sql = sprintf("SELECT*FROM`animal_info` ORDER BY animal_id  LIMIT %s,%s", ($page - 1) * $pre_page, $pre_page);
  $rows = $pdo->query($sql)->fetchAll();
  /*
echo json_encode($rows);
exit;*/


  #設定固定分頁
  $start_page = max(1, $page - 5);
  $end_page = min($start_page + 10, $total_pages);
}

#搜尋功能
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchColumns = ['animal_id', 'animal_name', 'animal_simple_narrative', 'animal_story'];

$sqlSearch = '';
#初始化變數 $sqlSearch 為空字符串，用於存儲 SQL 查詢中的條件語句。
$searchConditions = [];
#初始化一個空陣列 $searchConditions，用於存儲每個搜索條件。

if (!empty($searchKeyword)) {
  foreach ($searchColumns as $column) {
    $searchConditions[] = "`$column` LIKE '%$searchKeyword%'";
  }
  $sqlSearch = 'WHERE ' . implode(' OR ', $searchConditions);
};

$sql = sprintf("SELECT * FROM animal_info %s ORDER BY animal_id DESC LIMIT %d, %d", $sqlSearch, ($page - 1) * $pre_page, $pre_page);
$rows = $pdo->query($sql)->fetchAll();

// 排序



?>

<?php include __DIR__ . '/parts/html-head.php'
?>
<?php include __DIR__ . '/parts/navbar.php'
?>
<!-- 主要內容開始 -->
<div class="container-fluid">

  <h2>浪浪資訊列表</h2>
  <div class="container">
    <div class="  d-flex w-100 justify-content-between">
      <!-- 搜尋功能 -->
      <div class=" custom-search-input">
        <form name="form2" class="d-flex">
          <input class="form-control me-2" type="text" placeholder="搜尋" aria-label="Search" id="search" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
          <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>

      <a href="add.php" class="btn-add btn btn-dark" data-bs-toggle="modal" data-bs-target="#addBackdrop">
        <i class="fa-solid fa-plus"></i> 新增
      </a>


    </div>
  </div>

  <!-- 表格開始 -->
  <table class="table table-hover ">
    <thead>
      <tr>
        <th scope="col">選取刪除</th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">編號</a></th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">照片</a>
        </th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">名字</a>
        </th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">類別</a>
        </th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">性別</a>
        </th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">年紀</a>
        </th>
        <th scope="col"><a href="?page=<?= $page ?>&sort=animal_id">收容所</a>
        </th>
        <th scope="col">功能</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <?php foreach ($rows as $r) : ?>

          <td>
            <input class="form-check-input" type="checkbox" value="" id="Checkbox<?= $r['animal_id'] ?>" data-sid="<?= $r['animal_id'] ?>">
          </td>
          <td><?= htmlentities($r['animal_id']) ?></td>
          <td><img src=<?= htmlentities(fetchAnimalPhoto($pdo, $r['fk_animal_photo_id'])) ?> width="100"></td>
          <td><?= htmlentities($r['animal_name']) ?></td>
          <!-- Fetch and display animal type from the related table -->
          <td><?= htmlentities(fetchAnimalType($pdo, $r['fk_animal_type_id'])) ?></td>
          <td><?= htmlentities(fetchAnimalGender($pdo, $r['fk_animal_gender_id'])) ?></td>
          <td><?= htmlentities($r['animal_age']) ?></td>
          <!-- Fetch and display shelter name from the related table -->
          <td><?= htmlentities(fetchShelter($pdo, $r['fk_shelter_id'])) ?></td>
          <td>

            <a href="info.php?animal_id=<?= htmlentities($r['animal_id']) ?>" class="btn-infos btn btn-primary" data-bs-toggle="modal" data-bs-target="#infoBackdrop">
              <i class="fa-solid fa-circle-info"></i> 查看
            </a>

            <a href="edit.php?animal_id=<?= htmlentities($r['animal_id']) ?>" class="btn-edit btn btn-success" data-bs-toggle="modal" data-bs-target="#editBackdrop">
              <i class="fa-solid fa-pen-to-square">
              </i> 編輯
            </a>

            <!-- 單筆刪除 -->
            <!-- javascript: delete_one()=假連結
            <a href="javascript: delete_one(＜?= $r['sid'] ?>)"> <i class="fa-solid fa-trash"></i> </a> 
          -->
            <!-- 多筆刪除 
            <a href="javascript: delete_selected(＜?= $r['sid'] ?>)"><i class="fa-solid fa-trash"></i> </a>
          -->
            <!-- 綜合刪除 -->
            <a href="javascript: delete_record(<?= htmlentities($r['animal_id']) ?>)">
              <button type="button" class="btn btn-danger"> <i class="fa-solid fa-trash"></i> 刪除</button>
            </a>

          </td>

      </tr>

    <?php endforeach ?>

    </tbody>
  </table>
  <!-- 表格結束 -->
  <!-- 分頁開始 -->
  <nav aria-label="Page navigation ">
    <ul class="pagination justify-content-end">
      <li class="page-item">
        <a class="page-link" href="?page=<?= $i = $i = $page - 10 ?>">
          <i class="fa-solid fa-angles-left"></i>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $i = $i = $page - 1 ?>">
          <i class="fa-solid fa-angle-left"></i>
        </a>
      </li>

      <!-- 改為固定i分頁 -->
      <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
        <!--原始分頁設定: php for ($i = $page - 5; $i <= $page + 5; $i++) :  -->
        <!--1.顯示所有的頁數 $i = 1; $i <= $total_pages; $i++ -->
        <?php if ($i >= 1 and $i <= $total_pages) : ?>
          <!-- 檢查頁碼是否於1~total_pages之間 -->

          <li class="page-item <?= $page == $i ? 'active disabled' : '' ?>"> <!-- 3.當頁面在第$i頁時,echo:active狀態,沒有則echo空字串 -->
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a><!-- 2.href=第$i頁 -->
          </li>

        <?php endif ?>
      <?php endfor ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $i = $page + 1 ?>">
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="?page=<?= $i = $i = $page + 10 ?>">
          <i class="fa-solid fa-angles-right"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- 分頁結束 -->
</div>

<!-- Modal開始 -->
<!-- Modal-新增 -->
<div class="modal fade" id="addBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">新增資訊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="addModalBody">
        <!-- ... -->
      </div>

    </div>
  </div>
</div>

<!-- Modal-查看 -->
<div class="modal fade" id="infoBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">查看資訊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="infoModalBody">
        <!-- ... -->
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal-編輯 -->
<div class="modal fade" id="editBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">編輯資訊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editModalBody">
        <!-- AJAX content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<!-- Modal-成功 -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">新增結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a href="list.php" class="btn btn-primary">回到列表頁</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal-失敗 -->
<div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">資料新增成功</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div role="alert" id="failureInfo">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a href="list.php" class="btn btn-primary">跳至列表頁</a>
      </div>
    </div>
  </div>
</div>

<!-- 主要內容結束 -->


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
};


?>

<?php include __DIR__ . '/parts/script.php'
?>

<script>
  // 綜合刪除
  function delete_record(sid) {
    let checkboxes = document.querySelectorAll('.form-check-input:checked');
    let selectedSids = Array.from(checkboxes).map(function(checkbox) {
      return checkbox.dataset.sid;
    });

    if (selectedSids.length > 0) {
      if (confirm(`是否要刪除編號為${selectedSids.join(',')}的資料？`)) {
        //將animal_id傳給 delete.php
        location.href = `delete.php?animal_id=${selectedSids.join(',')}`;
      }
    } else {
      // 如果沒有選取多個,就刪除一個
      if (confirm(`是否要刪除編號為${sid}的資料？`)) {
        location.href = `delete.php?animal_id=${sid}`;
      }
    }
  }

  // //Modal-關閉
  $('#addBackdrop,#editBackdrop,#infoBackdrop').on('hidden.bs.modal', function() {
    $('.modal-backdrop').remove();
  });

  //Modal-新增
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.btn-add').addEventListener('click', function(e) {
      e.preventDefault();

      // Get the URL from the href attribute
      var addUrl = this.getAttribute('href');


      fetch(addUrl)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          // Update the content of the modal body with the loaded data
          document.getElementById('addModalBody').innerHTML = data;

          // Show the modal
          new bootstrap.Modal(document.getElementById('addBackdrop')).show();
        })
        .catch(error => {
          console.error('Error loading content:', error);
        });
    });
  });

  //Modal-編輯
  document.addEventListener('DOMContentLoaded', function() {
    // When the "編輯" button is clicked
    document.querySelector('.btn-edit').addEventListener('click', function(e) {
      e.preventDefault();

      // Get the URL from the href attribute
      var editUrl = this.getAttribute('href');

      // Use fetch API to load the content of edit.php
      fetch(editUrl)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          // Update the content of the modal body with the loaded data
          document.getElementById('editModalBody').innerHTML = data;

          // Show the modal
          new bootstrap.Modal(document.getElementById('editBackdrop')).show();
        })
        .catch(error => {
          console.error('Error loading content:', error);
        });
    });
  });

  //Modal-資訊
  document.addEventListener('DOMContentLoaded', function() {
    // When the "編輯" button is clicked
    document.querySelector('.btn-infos').addEventListener('click', function(e) {
      e.preventDefault();

      // Get the URL from the href attribute
      var infoUrl = this.getAttribute('href');

      // Use fetch API to load the content of edit.php
      fetch(infoUrl)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          // Update the content of the modal body with the loaded data
          document.getElementById('infoModalBody').innerHTML = data;

          // Show the modal
          new bootstrap.Modal(document.getElementById('infoBackdrop')).show();
        })
        .catch(error => {
          console.error('Error loading content:', error);
        });
    });
  });


  // function validateEmail(email) {
  //   const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  //   return re.test(email);
  // }

  // function validateMobile(mobile) {
  //   const re = /^09\d{2}-?\d{3}-?\d{3}$/ //檢查字串
  //   return re.test(mobile);
  // }

  // function validatePhoto(photo) {
  //   const re = /^09\d{2}-?\d{3}-?\d{3}$/; //檢查字串
  //   return re.test(photo);
  // }

  function sendData(event) {
    event.preventDefault(); //不要讓表單以傳統方式送出
    // 檢查表單
    const {
      photo: photoEl,
      name: nameEl,
      shelter: shelterEl,
      type: typeEl,
      gender: genderEl,
      color: colorEl,
      age: ageEl,
      qualities: qualitiesEl,
      narrative: narrativeEl,
      behavior: behaviorEl,
      // degree: degreeEl,
      state: stateEl,
      medical: medicalEl,
      story: storyEl
    } = document.form1; //以解構的方式拿資料El=Element
    //物件document.form1的屬性設定在{}裡面
    //  check: checkEl
    const fields = [photoEl, nameEl, shelterEl, typeEl, genderEl, colorEl, ageEl, qualitiesEl, narrativeEl, behaviorEl, stateEl, medicalEl, storyEl]; //抓每個欄位成陣列,下面回復欄位迴圈需用到
    // degreeEl,checkEl

    // 圖片上傳
    // const avatar = document.uploadForm.avatar;
    // avatar.onchange = (event) => {
    //   const fd = new FormData(document.uploadForm);
    //   alert('change avatar')
    //   fetch("upload-avatar-api.php", {
    //       method: "POST",
    //       body: fd,
    //     })
    //     .then((r) => r.json())
    //     .then((result) => {
    //       if (result.success) {
    //         // result.filename
    //         image_path.value = result.filename;
    //         myimg.src = `./imgs/${result.filename}`;
    //       }

    //     })
    //     .catch((ex) => console.log(ex));
    // };

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

    let isPass = true; //整個表單有沒有通過檢查

    //TODO:檢查表單個欄位有沒有符合規範
    // if (checkEl.value.length < 1) {
    //   isPass = false; //名字字元<1=不通過
    //   /*alert('請填寫正確姓名');
    //   return;*/
    //   checkEl.style.border = '1px solid red';
    //   checkEl.nextElementSibling.innerHTML = '請輸入檢查時間';
    // }

    if (photoEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      photoEl.style.border = '1px solid red';
      photoEl.nextElementSibling.innerHTML = '請上傳圖片';
    }

    if (nameEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      nameEl.style.border = '1px solid red';
      nameEl.nextElementSibling.innerHTML = '請輸入名字';
    }

    if (shelterEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      shelterEl.style.border = '1px solid red';
      shelterEl.nextElementSibling.innerHTML = '請選擇收容所';
    }

    if (typeEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      typeEl.style.border = '1px solid red';
      typeEl.nextElementSibling.innerHTML = '請選擇種類';
    }

    if (colorEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      colorEl.style.border = '1px solid red';
      colorEl.nextElementSibling.innerHTML = '請選擇花色';
    }

    if (genderEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      genderEl.style.border = '1px solid red';
      genderEl.nextElementSibling.innerHTML = '請選擇性別';
    }

    if (ageEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      ageEl.style.border = '1px solid red';
      ageEl.nextElementSibling.innerHTML = '請輸入年齡';
    }

    if (qualitiesEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      qualitiesEl.style.border = '1px solid red';
      qualitiesEl.nextElementSibling.innerHTML = '請輸入個性特質';
    }

    if (narrativeEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      narrativeEl.style.border = '1px solid red';
      narrativeEl.nextElementSibling.innerHTML = '請輸入外表與個性簡述';
    }

    if (stateEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      stateEl.style.border = '1px solid red';
      stateEl.nextElementSibling.innerHTML = '請輸入外表與個性簡述';
    }

    if (behaviorEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      behaviorEl.style.border = '1px solid red';
      behaviorEl.nextElementSibling.innerHTML = '請選擇行為';
    }

    // if (degreeEl.value.length < 1) {
    //   isPass = false;
    //   degreeEl.style.border = '1px solid red';
    //   degreeEl.nextElementSibling.innerHTML = '請選擇程度';
    // }

    if (medicalEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      medicalEl.style.border = '1px solid red';
      medicalEl.nextElementSibling.innerHTML = '請輸入醫療史';
    }

    if (storyEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      storyEl.style.border = '1px solid red';
      storyEl.nextElementSibling.innerHTML = '請輸入背景故事';
    }


    // if (emailEl.value && !validateEmail(emailEl.value)) {
    //   isPass = false;
    //   emailEl.style.border = '1px solid #red';
    //   emailEl.nextElementSibling.innerHTML = '請填寫正確的Email';
    // }

    // if (mobileEl.value && !validateMobile(mobileEl.value)) {
    //   isPass = false;
    //   mobileEl.style.border = '1px solid #red';
    //   mobileEl.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
    // }

    if (isPass) { //if(isPass){}通過才送出表單
      const fd = new FormData(document.form1);
      //把表單內容複製到沒有外觀的表單物件(有外觀=上面form標籤,有外觀才能讓使用者輸入資料)fd變數名稱=formdata , new+類型(FormData)}

      //fetch(送到哪裡,用甚麼方式)
      fetch(`add-api.php`, { //TypeScript
        method: 'POST',
        body: fd
      }).then(r => r.json()).then(data => {
        console.log(data);
        if (data.success) {
          /* 更改為BOOTSTRAP的彈窗
         alert('資料新增成功');
          location.href = 'list.php';
        } else {
          alert('資料新增失敗\n' + data.error);*/
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
<script>
  function backToList() {
    if (document.referrer) {
      location.href = document.referrer;
    } else {
      location.href = "list.php";
    }
  }

  const {
    photo: photoEl,
    name: nameEl,
    shelter: shelterEl,
    type: typeEl,
    gender: genderEl,
    color: colorEl,
    age: ageEl,
    qualities: qualitiesEl,
    narrative: narrativeEl,
    behavior: behaviorEl,
    // degree: degreeEl,
    state: stateEl,
    medical: medicalEl,
    story: storyEl
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
    if (photoEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      photoEl.style.border = '1px solid red';
      photoEl.nextElementSibling.innerHTML = '請上傳圖片';
    }

    if (nameEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      nameEl.style.border = '1px solid red';
      nameEl.nextElementSibling.innerHTML = '請輸入名字';
    }

    if (shelterEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      shelterEl.style.border = '1px solid red';
      shelterEl.nextElementSibling.innerHTML = '請選擇收容所';
    }

    if (typeEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      typeEl.style.border = '1px solid red';
      typeEl.nextElementSibling.innerHTML = '請選擇種類';
    }

    if (colorEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      colorEl.style.border = '1px solid red';
      colorEl.nextElementSibling.innerHTML = '請選擇花色';
    }

    if (genderEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      genderEl.style.border = '1px solid red';
      genderEl.nextElementSibling.innerHTML = '請選擇性別';
    }

    if (ageEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      ageEl.style.border = '1px solid red';
      ageEl.nextElementSibling.innerHTML = '請輸入年齡';
    }

    if (qualitiesEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      qualitiesEl.style.border = '1px solid red';
      qualitiesEl.nextElementSibling.innerHTML = '請輸入個性特質';
    }

    if (narrativeEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      narrativeEl.style.border = '1px solid red';
      narrativeEl.nextElementSibling.innerHTML = '請輸入外表與個性簡述';
    }

    if (stateEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      stateEl.style.border = '1px solid red';
      stateEl.nextElementSibling.innerHTML = '請輸入外表與個性簡述';
    }

    if (behaviorEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過

      behaviorEl.style.border = '1px solid red';
      behaviorEl.nextElementSibling.innerHTML = '請選擇行為';
    }

    // if (degreeEl.value.length < 1) {
    //   isPass = false;
    //   degreeEl.style.border = '1px solid red';
    //   degreeEl.nextElementSibling.innerHTML = '請選擇程度';
    // }

    if (medicalEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      medicalEl.style.border = '1px solid red';
      medicalEl.nextElementSibling.innerHTML = '請輸入醫療史';
    }

    if (storyEl.value.length < 1) {
      isPass = false; //名字字元<1=不通過
      /*alert('請填寫正確姓名');
      return;*/
      storyEl.style.border = '1px solid red';
      storyEl.nextElementSibling.innerHTML = '請輸入背景故事';
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
          successModal_edit.show();
        } else {
          document.querySelector('#failureModal_edit').innerHTML = data.error;
          failureModal_edit.show();
        }

      }) //data => {}輸出到add-api-output
    }
  }

  const successModal_edit = new bootstrap.Modal(document.getElementById('successModal_edit'), Option);
  const failureModal_edit = new bootstrap.Modal(document.getElementById('failureModal_edit'), Option);
</script>
<?php include __DIR__ . '/parts/html-foot.php'
?>