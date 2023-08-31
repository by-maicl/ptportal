<?php

  include("../connect.php");

  $new_card_name = filter_var(trim($_POST['new_card_name']), FILTER_SANITIZE_STRING);
  $new_card_design = $_POST['card_des'];
  $card_number = $_POST['card_number'];

  $new_card = mysqli_query($mysql, "UPDATE `card` SET `card_name` = '$new_card_name', `card_design` = '$new_card_design' WHERE `card_number` = '$card_number'");
  mysqli_close($mysql);
  header('Location: bank.php');

?>
