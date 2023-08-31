<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("../connect.php");

 $commId = $_POST['comm_id'];
 $user = $_COOKIE['user'];

 mysqli_query($mysql, "DELETE FROM `post_comm` WHERE `id` = '$commId'");

 $notificationDel = mysqli_query($mysql, "DELETE FROM `notification` WHERE `object_id2` = '$commId' AND `type` = 'comm'");

 mysqli_close($mysql);
 header('Location: content.php');
?>
