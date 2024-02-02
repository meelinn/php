<?php
#如果沒有設定page_name,就輸出空字串
if (!isset($page_name)) {
  $page_name = '';
}
?>

<style>

</style>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">毛毛救星</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- <input class="form-control form-control-sm form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
  <!-- 上方導覽開始 -->
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="logout.php">登出</a>
    </div>
  </div>
</header>
<!-- 上方導覽結束 -->
<!-- 左導覽開始 -->
<div class="container-fluid">
  <div class="row">
    <!-- 摺疊左導覽 -->
    <div id="sidebarMenu" class=" col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">


      <button class="btn d-grid">
        <i class="bi bi-toggle-on text-light fs-4"></i></button>


      <ul class="list-group pt-3 ">

        <li class="nav mb-2 ">
          <button class="btn btn-toggle align-items-center rounded collapsed list-group-item-action link-dark" data-bs-toggle="collapse" data-bs-target="#mumber-collapse" aria-expanded="false">
            會員管理
          </button>
          <div class="collapse" id="mumber-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="..\mid-project\index_.php" class="link-dark rounded ms-3">一般會員</a></li>
              <li><a href="#" class="link-dark rounded ms-3">合作收容所</a></li>
              <!-- <li><a href="#" class="list-group-item list-group-item-action rounded">一般會員</a></li>
                <li><a href="#" class="list-group-item list-group-item-action rounded">合作收容所</a></li> -->
            </ul>
          </div>
        </li>
        <li class="nav mb-2">
          <button class="btn btn-toggle align-items-center rounded collapsed list-group-item-action link-dark" data-bs-toggle="collapse" data-bs-target="#order-collapse" aria-expanded="false">
            訂單管理
          </button>
          <div class="collapse" id="order-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="..\order\order.php" class="link-dark rounded ms-3">一般訂單</a></li>
              <li><a href="#" class="link-dark rounded ms-3">退貨訂單</a></li>
              <li><a href="#" class="link-dark rounded ms-3">匯出報表</a></li>
            </ul>
          </div>
        </li>
        <li class="nav mb-2">
          <button class="btn btn-toggle align-items-center rounded collapsed list-group-item-action link-dark" data-bs-toggle="collapse" data-bs-target="#product-collapse" aria-expanded="false">
            商品管理
          </button>
          <div class="collapse" id="product-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark rounded ms-3">活動管理</a></li>
              <li><a href="..\Aki_project\list.php" class="link-dark rounded ms-3">上架下架</a></li>
              <li><a href="#" class="link-dark rounded ms-3">庫存管理</a></li>
            </ul>
          </div>
        </li>
        <li class="nav mb-2">
          <button class="btn btn-toggle align-items-center rounded collapsed list-group-item-action link-dark" data-bs-toggle="collapse" data-bs-target="#animal-collapse" aria-expanded="false">
            浪浪資訊管理
          </button>
          <div class="collapse" id="animal-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="list-admin.php" class="link-dark rounded ms-3">浪浪資訊</a></li>
              <li><a href="#" class="link-dark rounded ms-3">收容所資訊</a></li>
            </ul>
          </div>
        </li>
        <li class="nav mb-2">
          <button class="btn btn-toggle align-items-center rounded collapsed list-group-item-action link-dark" data-bs-toggle="collapse" data-bs-target="#article-collapse" aria-expanded="false">
            文章管理
          </button>
          <div class="collapse" id="article-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark rounded ms-3">商品文宣</a></li>
              <li><a href="#" class="link-dark rounded ms-3">飼養知識</a></li>
            </ul>
          </div>
        </li>
        <!-- <li class="border-top my-3"></li>
        <li class="mb-2">
          <button class="btn btn-toggle align-items-center rounded collapsed link-dark" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            Account
          </button>
          <div class="collapse" id="account-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark rounded">New...</a></li>
              <li><a href="#" class="link-dark rounded">Profile</a></li>
              <li><a href="#" class="link-dark rounded">Settings</a></li>
              <li><a href="#" class="link-dark rounded">Sign out</a></li>
            </ul>
          </div>
        </li> -->
      </ul>
    </div>

    <!-- 主要內容 -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">