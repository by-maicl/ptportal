<?php
include '../connect.php';

$petitionId = $_POST['answerPetitionId'];
$answerText = $_POST['answerText'];
$answerFrom = $_COOKIE['user'];
$support = $_POST['support'];

$upd = mysqli_query($mysql, "UPDATE `petition` SET `status` = 0, `support` = '$support', `answer` = '$answerText', `answer_from` = '$answerFrom' WHERE `id` = '$petitionId'");


$petitonSel1 = mysqli_query($mysql, "SELECT * FROM `petition` WHERE `id` = '$petitionId'");
$petitonSel = mysqli_fetch_assoc($petitonSel1);

$petitonSubSel1 = mysqli_query($mysql, "SELECT * FROM `petition_sub` WHERE `petition_id` = '$petitionId'");
$petitonSubSel = mysqli_fetch_assoc($petitonSubSel1);


  foreach ($petitonSubSel1 as $petitonSub) {
    $notificationTo = $petitonSub['username'];
    date_default_timezone_set('Europe/Vilnius');
    $notificationDate = date('H:i d.m.Y');

    $notificationAdd = mysqli_query($mysql, "INSERT INTO `notification` (`object_id`, `user_to`, `type`, `date`) VALUES ('$petitionId', '$notificationTo', 'petition', '$notificationDate')");
  }

mysqli_close($mysql);
header("Location: petitionSub.php#$petitionId");

 ?>
