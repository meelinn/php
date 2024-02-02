<?php
session_start(); #啟用session
unset($_SESSION['user']); #只清除user session

// session_destroy();#摧毀.清除所有session,可能會清空購物車,不建議使用

header('Location:20240117-10-login.php'); #導向到登入頁面
