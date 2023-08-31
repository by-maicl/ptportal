<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("../connect.php");

 $card_to = filter_var(trim($_POST['trans_to']), FILTER_SANITIZE_STRING);
 $trans_summa = filter_var(trim($_POST['trans_summa']), FILTER_SANITIZE_STRING);
 $trans_mess = filter_var(trim($_POST['trans_mess']), FILTER_SANITIZE_STRING);
 $trans_from = $_COOKIE['user'];

 $card_name = $_POST['card_from'];
 $card_from1 = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_name` = '$card_name'");
 $card_from2 = mysqli_fetch_assoc($card_from1);
 $card_from = $card_from2['card_number'];

 $trans_sel_to = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_number` = '$card_to'");
 $trans_sel_to1 = mysqli_fetch_assoc($trans_sel_to);
 $trans_to = $trans_sel_to1['card_user'];
 date_default_timezone_set('Europe/Vilnius');
 $trans_date = date('H:i d.m.Y');

 $result = mysqli_query($mysql, ("SELECT * FROM `card` WHERE `card_number` = '$card_from'"));
 $bal = mysqli_fetch_assoc($result);
 //баланс
  $balance = $bal['card_balance'];

  if ($balance < $trans_summa) {
    $trans_mess = 'Помилка! Недостатньо коштів.';
  }
//внос в таблицу данных о транзакции
 $trans = mysqli_query($mysql, "INSERT INTO `trans` (`trans_from`, `trans_to`, `card_from`, `card_to`, `trans_date`, `trans_summa`, `trans_mess`) VALUES ('$trans_from', '$trans_to', '$card_from', '$card_to', '$trans_date', '$trans_summa', '$trans_mess')");
//транзакции
 $sel_trans = "SELECT * FROM `trans` WHERE `card_from` = '$card_from' ORDER BY `trans_id` DESC LIMIT 1";
 $sel_result = mysqli_query($mysql, $sel_trans);
 $sel_result1 = mysqli_fetch_assoc($sel_result);
// - уменьшение баланса у отправителя
 $tr_s = $sel_result1['trans_summa'];
 $bal_upd1 = $balance - $tr_s;
 if ($balance < $tr_s) {
   echo '<script>alert("Помилка! Недостатньо коштів");
   self.location=("penalty.php");
   </script>';
   $tr_s = 0;
   $trans_mess = 'Помилка! Недостатньо коштів';
   $penalt_status = '1';
 }
 else {
 $upd_bal1 = mysqli_query($mysql, "UPDATE `card` SET `card_balance` = '$bal_upd1' WHERE `card_number` = '$card_from'");
 $penalt_status = '0';
 }
// + увеличение баланса у получателя
 $trans_to1 = $sel_result1['card_to'];
 $select2 = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_number` = '$trans_to1'");
 $sel2_result = mysqli_fetch_assoc($select2);
 $sel_bal2 = $sel2_result['card_balance'];
 $bal_upd2 = $sel_bal2 + $tr_s;
 $upd_bal2 = mysqli_query($mysql, "UPDATE `card` SET `card_balance` = '$bal_upd2' WHERE `card_number` = '$trans_to1'");

 //изменение статуса штрафа
 $penalty_id = $_POST['penalty_id'];
 mysqli_query($mysql, "UPDATE `penalty` SET `penalt_status` = '$penalt_status' WHERE `penalt_id` = '$penalty_id'");

 mysqli_query($mysql, "DELETE FROM `notification` WHERE `object_id` = '$penalty_id' AND `type` = 'penalt'");


 mysqli_close($mysql);
 header('Location: penalty.php');
?>
