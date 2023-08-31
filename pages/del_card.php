<?php

  include("../connect.php");

  $card_number = $_POST['card_number'];

  $del_card = mysqli_query($mysql, "DELETE FROM `card` WHERE `card_number` = '$card_number'");
  mysqli_close($mysql);
  header('Location: bank.php');

?>
