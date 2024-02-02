<?php
#依據登入狀態提供不同功能
session_start();
if (isset($_SESSION["admin"])) {
  include __DIR__ . '/list-admin.php';
} else {
  include __DIR__ . '/login.php';
}
