<?php
#用原密碼做驗證
$hash = '$2y$10$p7yaQe2aoz19nFJm.qlrH.RJNeJ2rBiYYNNBUl.cWCdoJ1/qlhek6';
$pw = '12456';
var_dump(password_verify($pw, $hash));
