<?php
  include("../connect.php");

  $petition_id = $_POST['petitionId'];
  $username = $_COOKIE['user'];

  $subSel1 = mysqli_query($mysql, "SELECT * FROM `petition` WHERE `id` = '$petition_id'");
  $subSel = mysqli_fetch_assoc($subSel1);
  $subUpd = $subSel['subscribe'] + 1;

  mysqli_query($mysql, "UPDATE `petition` SET `subscribe` = '$subUpd' WHERE `id` = '$petition_id'");

  mysqli_query($mysql, "INSERT INTO `petition_sub` (`petition_id`, `username`) VALUES ('$petition_id', '$username')");

  mysqli_close($mysql);
  header("Location: petition.php#$petition_id");
?>
