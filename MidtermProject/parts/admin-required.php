<?php
if (!isset($_SESSION)) {
  session_start(); #有session=有登入
}
if (!isset($_SESSION['admin'])) {
  header('Location: index_.php');
  exit;
};
