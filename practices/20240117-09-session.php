<?php
#啟用session,if設定若此變數$_SESSION沒有被設定,則啟用
if (!isset($_SESSION)) {
  session_start(); #預設是關閉
}


if (isset($_SESSION["my_sess"])) {
  $_SESSION["my_sess"]++;
} else {
  $_SESSION["my_sess"] = 1;
}

#$_SESSION['my_sess'] = 1; #_SESSION為預設變數,是關聯式陣列

echo $_SESSION['my_sess']; #g78q3uvepqrc845nl41e9ief2u=session ID,依賴cookie
