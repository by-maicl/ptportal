<?php

  include("../connect.php");

  $trans_summa = $_POST['editSum'];
  $operationType = $_POST['operationType'];
  date_default_timezone_set('Europe/Vilnius');
  $trans_date = date('H:i d.m.Y');
  $card_user = $_POST['cardNumb'];

  $trans_sel_to = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_number` = '$card_user'");
  $trans_sel_to1 = mysqli_fetch_assoc($trans_sel_to);

  if ($operationType == 'plus') {
    $trans_mess = 'Поповнення рахунку. Банкір ' . $_COOKIE['user'];
    $trans_from = 'PityhBank';
    $card_from = '0';
    $trans_to = $trans_sel_to1['card_user'];
    $card_to = $_POST['cardNumb'];

    $updBalance = $trans_sel_to1['card_balance'] + $trans_summa;
    mysqli_query($mysql, "UPDATE `card` SET `card_balance` = '$updBalance' WHERE `card_number` = '$card_to'");
  } else {
    $trans_mess = 'Зняття з рахунку. Банкір ' . $_COOKIE['user'];
    $trans_from = $trans_sel_to1['card_user'];
    $card_from = $_POST['cardNumb'];
    $card_to = 0;
    $trans_to = 'PityhBank';
    $updBalance = $trans_sel_to1['card_balance'] - $trans_summa;
    mysqli_query($mysql, "UPDATE `card` SET `card_balance` = '$updBalance' WHERE `card_number` = '$card_from'");
  }

  mysqli_query($mysql, "INSERT INTO `trans` (`trans_from`, `trans_to`, `card_from`, `card_to`, `trans_date`, `trans_summa`, `trans_mess`) VALUES ('$trans_from', '$trans_to', '$card_from', '$card_to', '$trans_date', '$trans_summa', '$trans_mess')");



  mysqli_close($mysql);
  header('Location: admin.php');

?>
