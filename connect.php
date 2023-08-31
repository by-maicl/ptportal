<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysql = new mysqli('localhost', 'root', 'root', 'pt');
$mysql->set_charset('utf8mb4');
if($mysql == false) {
  echo 'Не удалось подключится к бд';
  echo mysqli_connect_error();
  exit();
}
?>
