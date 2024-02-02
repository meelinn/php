<?php
if (!isset($pageName)) {
  $pageName = '';
}
?>
<style>
  /* .navbar-nav .nav-link.active {
    background-color: #0d6efd;
    color: white;
    border-radius: 6px;
    font-weight: 800;
  } */
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">後台管理</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">訂單管理 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">產品管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">用戶管理</a>
                </li>
                <!-- 可以根據需要添加更多鏈接 -->
            </ul>
        </div>
    </nav>