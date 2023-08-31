<?php
 include("../connect.php");

 $card_name = filter_var(trim($_POST['card_name']), FILTER_SANITIZE_STRING);
 $card_design = $_POST['card_des'];
 $card_user = $_COOKIE['user'];
 $card_number = rand(1000, 9999);

 $new_card = mysqli_query($mysql, "INSERT INTO `card` (`card_name`, `card_user`, `card_number`, `card_design`) VALUES ('$card_name', '$card_user', '$card_number', '$card_design')");
 mysqli_close($mysql);
 header('Location: bank.php');
?>
