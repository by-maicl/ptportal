<?php
 include("../connect.php");
 include "menu.php";

 if($_COOKIE['user'] == ''){
   echo "<script>self.location='/index.php';</script>";
 } else {
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
    <link rel="stylesheet" href="/CSS/menu.css">
    <link rel="stylesheet" href="/CSS/upMenu.css">
    <link rel="stylesheet" href="/CSS/penalty.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Штрафи</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">

      <?php
      //Штрафы
      $penalty1 = mysqli_query($mysql, "SELECT * FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1' ORDER BY `penalt_id` DESC");
      $penaltySelect = mysqli_fetch_assoc($penalty1);
      //Количество штрафов
      $penaltyCount1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1'");
      $penaltyCount = mysqli_fetch_assoc($penaltyCount1);
      //Проверка на наличие карты
      $sel_card = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_user` = '$_COOKIE[user]' ORDER BY `card_id`");
      $sel_card1 = mysqli_fetch_assoc($sel_card);
       ?>
    <div class="content"> <!--Основная часть сайта-->

      <a href="bank.php"><font size="6"><i class="fa-solid fa-arrow-left"></i></font></a>
      <?php if ($penaltyCount['count'] == 0) {echo '<p align="center"><font size="4" color="#828282">У вас поки що немає штрафів :)</font></p>';} else { ?>
            <div class="penalties">
              <?php foreach ($penalty1 as $penalty) {?>
              <div class="penalty">
                <div class="penaltyStyle">
                  <div class="penaltyHeader"><b>Штраф №<?= $penalty['penalt_id'] ?></b></div>
                  <div class="penaltyInf">
                    <font color="#828282">Від:</font> <?= $penalty['penalt_from'] ?><br>
                    <font color="#828282">Сума:</font> <?= $penalty['penalt_sum'] ?> ІР<br>
                    <font color="#828282">Причина:</font> <?= $penalty['penalt_text'] ?><br>
                    <font color="#828282">Дата:</font> <?= $penalty['penalt_date'] ?>
                  </div><br>
                  <button class="penaltyButt" onclick="self.location = 'penalty.php#windTrans-<?= $penalty['penalt_id'] ?>'">Сплатити</button>
                </div>
              </div>


            <div class="windBack" id="windTrans-<?= $penalty['penalt_id'] ?>"> <!--Окно перевода-->
              <div class="windTrans">
                <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
                <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
                <font color="white" size="5" class="windHeader">Підтвердження платежу</font>
                <form action="payPenalty.php" method="post"><br>
                  <i id="downArrow" class="fa-solid fa-chevron-down"></i>
                  <select class="pole1" id="poleSel" name="card_from" required>
                    <?php foreach ($sel_card as $transCardName): ?>
                      <option value="<?= $transCardName['card_name'] ?>"><?= $transCardName['card_name'] ?></option>
                    <?php endforeach; ?>
                  </select><br><br>
                  <input type="number" name="trans_to" class="pole1" maxlength="4" value="<?= $penalty['penalt_cardFrom'] ?>" readonly required><br><br>
                  <input type="number" name="trans_summa" class="pole1" value="<?= $penalty['penalt_sum'] ?>" readonly required><br><br>
                  <input type="text" name="trans_mess" class="pole1" maxlength="50" value="Оплата штрафу №<?= $penalty['penalt_id'] ?>" readonly><br><br>
                  <input type="text" name="penalty_id" class="pole1" id="invisibleInput" value="<?= $penalty['penalt_id'] ?>" readonly required><br>
                  <button type="submit" class="OK">ОК</button><br><br>
                </form>
              </div>
            </div>

      <?php } } ?>
      </div>

    </div>
  </body>
</html>
<?php } ?>
