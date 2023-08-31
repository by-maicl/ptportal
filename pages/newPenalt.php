<?php
  include("../connect.php");

  date_default_timezone_set('Europe/Vilnius');
  $penaltDate = date('H:i d.m.Y');
  $penaltFrom = $_POST['penaltFrom'];
  $penaltCardFrom = $_POST['penaltCardFrom'];
  $penaltTo = $_POST['penaltTo'];
  $penaltSum = $_POST['penaltSum'];
  $penaltLastDate = $_POST['penaltLastDate'];
  $penaltText = $_POST['penaltText'];

  mysqli_query($mysql, "INSERT INTO `penalty` (`penalt_from`, `penalt_cardfrom`, `penalt_to`, `penalt_sum`, `penalt_text`, `penalt_date`) VALUES ('$penaltFrom', '$penaltCardFrom', '$penaltTo', '$penaltSum', '$penaltText', '$penaltDate')");


  $penaltSel1 = mysqli_query($mysql, "SELECT * FROM `penalty` ORDER BY `penalt_id` DESC");
  $penaltSel = mysqli_fetch_assoc($penaltSel1);

  $penaltId = $penaltSel['penalt_id'];
  $notificationText = "Новий штраф від <b>$penaltFrom</b> на суму <b>$penaltSum</b> ІР. Причина: $penaltText";

  mysqli_query($mysql, "INSERT INTO `notification` (`object_id`, `user_to`, `type`, `text`, `date`) VALUES ('$penaltId', '$penaltTo', 'penalt', '$notificationText', '$penaltDate')");

  mysqli_close($mysql);
  header('Location: admin.php');
?>
