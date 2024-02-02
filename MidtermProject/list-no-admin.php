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
$pre_page = 10;

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
  $sql = sprintf("SELECT*FROM`animal_info` ORDER BY animal_id DESC LIMIT %s,%s", ($page - 1) * $pre_page, $pre_page);
  $rows = $pdo->query($sql)->fetchAll();
  /*
echo json_encode($rows);
exit;*/


  #設定固定分頁
  $start_page = max(1, $page - 5);
  $end_page = min($start_page + 10, $total_pages);
}
?>

<?php include __DIR__ . '/parts/html-head.php'
?>
<?php include __DIR__ . '/parts/navbar.php'
?>
<!-- 主要內容開始 -->
<div class="container">

  <h2>列表</h2>
  <nav aria-label="Page navigation">
    <ul class="pagination">
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

      <!-- 改為固定11分頁 -->
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
  <table class="table">
    <thead>
      <tr>
        <th scope="col">編號</th>
        <th scope="col">姓名</th>
        <th scope="col">電子郵件</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php foreach ($rows as $r) : ?>

          <td><?= htmlentities($r['animal_id']) ?></td>
          <td><?= htmlentities($r['animal_name']) ?></td>
          <td><?= htmlentities($r['animal_story']) ?></td>

      </tr>
    <?php endforeach ?>

    </tbody>
  </table>
</div>
<!-- 主要內容結束 -->
<?php include __DIR__ . '/parts/script.php'
?>
<script>
  /* 單筆刪除
  function delete_one(sid) {
    if (confirm(`是否要刪除編號為${sid}的資料？`)) {
      location.href = `delete.php?sid=${sid}`;
    }
  }
  */

  /* 多筆刪除
   function delete_selected() {
     let checkboxes = document.querySelectorAll('.form-check-input:checked');
     let selectedSids = Array.from(checkboxes).map(function(checkbox) {
       return checkbox.dataset.sid;
     });

     if (selectedSids.length > 0 && confirm(`是否要刪除編號為${selectedSids}的資料？`)) {
       location.href = `delete.php?sid=${selectedSids.join(',')}`;
     }
   }
   */

  // 綜合刪除
  function delete_record(sid) {
    let checkboxes = document.querySelectorAll('.form-check-input:checked');
    let selectedSids = Array.from(checkboxes).map(function(checkbox) {
      return checkbox.dataset.sid;
    });

    if (selectedSids.length > 0) {
      if (confirm(`是否要刪除編號為${selectedSids.join(',')}的資料？`)) {
        //將sid傳給 delete_multiple 函数
        location.href = `delete.php?sid=${selectedSids.join(',')}`;
      }
    } else {
      // 如果沒有選取多個,就刪除一個
      if (confirm(`是否要刪除編號為${sid}的資料？`)) {
        location.href = `delete.php?sid=${sid}`;
      }
    }
  }
</script>

<?php include __DIR__ . '/parts/html-foot.php'
?>