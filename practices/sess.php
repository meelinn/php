<?php
#此php為查看session的工具
session_start(); #啟用session
header('Content-Type: application/json');
echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
