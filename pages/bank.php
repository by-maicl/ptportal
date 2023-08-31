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
    <link rel="stylesheet" href="/CSS/bank.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Банк</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">

<div class="content"> <!--Основная часть сайта-->

  <div class="windBack" id="windNewCard"> <!--Открытие нового счёта-->
    <div class="windTrans">
      <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
      <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
      <font color="white" size="5" class="windHeader">Відкриття рахунку</font>
      <form class="" action="new_card.php" method="post"><br>
        <input type="text" name="card_name" class="pole1" maxlength="100" placeholder="Введіть назву рахунку" required><br><br>
        <i id="downArrowNewCard" class="fa-solid fa-chevron-down"></i>
        <select class="pole1" id="poleSel" name="card_des" required>
            <option value="des_green.svg">Зелений</option>
            <option value="des_blue.svg">Синій</option>
            <option value="des_orange.svg">Помаранчевий</option>
            <option value="des_purple.svg">Фіолетовий</option>
        </select><br><br>
        <button type="submit" class="OK">ОК</button><br><br>
      </form>
    </div>
  </div>

    <?php

      $balance = $sel_card1['card_balance']; //Транзакции
      $sel_trans = "SELECT * FROM `trans` WHERE `trans_from` = '$_COOKIE[user]' OR `trans_to` = '$_COOKIE[user]' ORDER BY `trans_id` DESC LIMIT 0,500";
      $sel_result = mysqli_query($mysql, $sel_trans);
      $sel_result1 = mysqli_fetch_assoc($sel_result);

      //Штрафы
      $penalty1 = mysqli_query($mysql, "SELECT * FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1' ORDER BY `penalt_id` DESC");
      $penaltySelect = mysqli_fetch_assoc($penalty1);
      //Количество штрафов
      $penaltyCount1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `penalty` WHERE `penalt_to` = '$_COOKIE[user]' AND `penalt_status` = '1'");
      $penaltyCount = mysqli_fetch_assoc($penaltyCount1);

      $sel_card = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_user` = '$_COOKIE[user]' ORDER BY `card_id`"); //Проверка на наличие карты
      $sel_card1 = mysqli_fetch_assoc($sel_card);
      if ($sel_card1['card_user'] == '') {
        echo '<font size="5" color="white"><p align="center">У вас ще немає рахунку!</p></font><a href="#windNewCard"><button class="button" id="newNewCard">Відкрити рахунок</button></a>';
      } else {
     ?>

 <div class="blocks">


  <div class="cards"> <!--Счёта-->
    <?php foreach ($sel_card as $cardInf) { ?>
    <div class="card">
      <div class="cardStyle">
          <font color="white" size="3" class="cardName" onclick="trans()"><?= $cardInf['card_name'] ?></font>
          <font class="cardButt" size="3">
          <a href="#windDelCard-<?= $cardInf['card_number'] ?>"><i class="fa-regular fa-trash-can" id="cardDel"></i></a>
          <a href="#windEditCard-<?= $cardInf['card_number'] ?>"><i class="fa-regular fa-pen-to-square" id="cardEdit"></i></a>
          </font><br><br>
          <font color="white" class="cardBalance"><b><?= $cardInf['card_balance'] ?> ІР</b></font>
          <img src="../images/des_cards/<?= $cardInf['card_design'] ?>" width="110px" class="cardDes">
          <font color="white" size="4" class="cardNumb"><?= $cardInf['card_number'] ?></font>
      </div>
    </div><br><br>

    <div class="windBack" id="windEditCard-<?= $cardInf['card_number'] ?>"> <!--Изменение счёта-->
      <div class="windTrans">
        <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
        <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
        <font color="white" size="5" class="windHeader">Зміна рахунку</font>
        <form class="" action="edit_card.php" method="post"><br>
          <input type="text" name="new_card_name" class="pole1" maxlength="100" placeholder="Введіть нову назву рахунку" required><br><br>
          <i id="downArrowNewCard" class="fa-solid fa-chevron-down"></i>
          <select class="pole1" id="poleSel" name="card_des" required>
              <option value="des_green.svg">Зелений</option>
              <option value="des_blue.svg">Синій</option>
              <option value="des_orange.svg">Помаранчевий</option>
              <option value="des_purple.svg">Фіолетовий</option>
          </select><br><br>
          <input type="text" name="card_number" class="pole1" id="invisibleInput" value="<?= $cardInf['card_number'] ?>" readonly required>
          <button type="submit" class="OK">ОК</button><br><br>
        </form>
      </div>
    </div>

    <div class="windBack" id="windDelCard-<?= $cardInf['card_number'] ?>"> <!--Удаление счёта-->
      <div class="windTrans windDelMob">
        <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
        <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
        <font color="white" size="5" class="windHeader windHeaderDel">Ви впевнені, що хочете закрити рахунок?</font>
        <form class="" action="del_card.php" method="post">
          <input type="text" name="card_number" class="pole1" id="invisibleInput" value="<?= $cardInf['card_number'] ?>" readonly required>
          <button type="submit" class="OK" id="okDelCard">Так</button>
        </form>
      </div>
    </div>
    <?php } ?>

    <a href="#windNewCard"><button class="button" id="cardNew"><i class="fa-solid fa-plus"></i></button></a>
  </div>

  <div class="buttAndTrans"> <!--Кнопки и транзакции-->
    <div class="buttons"> <!--Кнопки-->
      <button class="button" onclick="self.location = 'bank.php#windTrans';" id="firstBut"><i class="fa-solid fa-arrow-right-arrow-left"></i> Переказ</button>
      <button class="button" onclick="self.location = 'penalty.php';"><i class="fa-solid fa-money-bills"></i></i> Штрафи <?php if ($penaltyCount['count'] == 0) {echo '';} else {echo '(' . $penaltyCount['count'] . ')';} ?></button>
    </div>
    <div class="trans">
      <?php foreach ($sel_result as $transInf) {

        if ($_COOKIE['user'] == $transInf['trans_from']) {
          $selAva1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$transInf[trans_to]'");
          $selAva = mysqli_fetch_assoc($selAva1);
        } else {
          $selAva1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$transInf[trans_from]'");
          $selAva = mysqli_fetch_assoc($selAva1);
        }
        ?>
        <div class="trans1" onclick="self.location = 'bank.php#transaction№<?= $transInf['trans_id'] ?>'">
          <div class="transPart1">
            <img src="ava_user/<?= $selAva['ava'] ?>" class="avaTrans">
            <p class="transName">
              <?php
                if ($_COOKIE['user'] == $transInf['trans_from']) {
                  echo $transInf['trans_to'];
                } else {
                  echo $transInf['trans_from'];
                }
              ?>
            <br><font class="transComm">
              <?php
                if ($transInf['trans_mess'] == '') {
                  echo 'Немає коментаря';
                } else {
                echo $transInf['trans_mess']; }
              ?>
            </font></p>
          </div>
          <div class="transPart2">
            <p class="transSum">
              <?php
                if ($transInf['trans_mess'] == 'Помилка! Недостатньо коштів.') {
                  echo '<font color="white">' . 0 . ' ІР</font>';
                } else {
                if ($_COOKIE['user'] == $transInf['trans_from']) {
                  echo '<font color="#a00000">-' . $transInf['trans_summa'] . ' ІР</font>';
                } else {
                  echo '<font color="#4e9f3d">' . $transInf['trans_summa'] . ' ІР</font>';
                } }
              ?>
            </p>
          </div>
        </div>

        <div class="windBack" id="transaction№<?= $transInf['trans_id'] ?>"> <!--Окно просмотра транзакции-->
          <div class="windTrans">
            <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
            <a href="" class="xmark xmarkTrans"><i class="fa-solid fa-xmark"></i></a>
            <img src="ava_user/<?= $selAva['ava'] ?>" class="avaTransWatch">
            <div class="transNameWatch" align="center">
              <?php
                if ($_COOKIE['user'] == $transInf['trans_from']) {
                  echo $transInf['trans_to'];
                } else {
                  echo $transInf['trans_from'];
                }
              ?>
            </div>
            <div class="transDateWatch" align="center"><?= $transInf['trans_date'] ?></div>
            <div class="transSumWatch" align="center"><b>
              <?php
                if ($transInf['trans_mess'] == 'Помилка! Недостатньо коштів.') {
                  echo '<font color="white">' . 0 . ' ІР</font>';
                } else {
                if ($_COOKIE['user'] == $transInf['trans_from']) {
                  echo '<font color="#a00000">-' . $transInf['trans_summa'] . ' ІР</font>';
                } else {
                  echo '<font color="#4e9f3d">' . $transInf['trans_summa'] . ' ІР</font>';
                } }
              ?></b>
            </div>
            <hr color="414141">
            <div class="transCardWatch">
              <i class="fa-regular fa-credit-card"></i>
              <?php
              if ($_COOKIE['user'] == $transInf['trans_from']) {
                echo $transInf['card_to'];
              } else {
                echo $transInf['card_from'];
              }
               ?><br>
               <i class="fa-solid fa-comment-dots"></i> <?php
                 if ($transInf['trans_mess'] == '') {
                   echo 'Немає коментаря';
                 } else {
                 echo $transInf['trans_mess']; }
               ?>
            </div>
          </div>
        </div>

      <?php } ?>
    </div>
  </div>

 </div>

 <div class="windBack" id="windTrans"> <!--Окно перевода-->
   <div class="windTrans">
     <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
     <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
     <font color="white" size="5" class="windHeader">Переказ</font>
     <form class="" action="trans_bank.php" method="post"><br>
       <i id="downArrow" class="fa-solid fa-chevron-down"></i>
       <select class="pole1" id="poleSel" name="card_from" required>
         <?php foreach ($sel_card as $transCardName): ?>
           <option value="<?= $transCardName['card_name'] ?>"><?= $transCardName['card_name'] ?></option>
         <?php endforeach; ?>
       </select><br><br>
       <input type="number" name="trans_to" class="pole1" maxlength="4" placeholder="Введіть номер карти отримувача" required><br><br>
       <input type="number" name="trans_summa" class="pole1" step="any" placeholder="Введіть суму (0.0)" required><br><br>
       <input type="text" name="trans_mess" class="pole1" maxlength="50" placeholder="Коментар (необов'язково)"><br><br>
       <button type="submit" class="OK">ОК</button><br><br>
     </form>
   </div>
 </div>

</div>
<?php } ?>
</body>
</html>
<?php
  }
  mysqli_close($mysql);
?>
