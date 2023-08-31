<?php include("../connect.php");
include "menu.php";
if($_COOKIE['user'] == ''){
  echo "<script>self.location='/index.php';</script>";
} else {

  $userSel = mysqli_query($mysql, "SELECT * FROM `user`");

  $user1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
  $user = mysqli_fetch_assoc($user1);
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
    <link rel="import" href="menu.php">
    <link rel="stylesheet" href="/CSS/menu.css">
    <link rel="stylesheet" href="/CSS/upMenu.css">
    <link rel="stylesheet" href="/CSS/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Админ-панель</title>
   <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <style type="text/css">
    input::-webkit-calendar-picker-indicator {
    opacity: 0;
    }
  </style>
  <body bgcolor="#191a19">

      <div class="content"> <!--Основная часть сайта-->

        <?php
          if ($role['role'] !== 'admin') {
            echo '<font size="5" color="white">Ти як сюди потрапив?</font>';
          } else {
         ?>

        <h2><font color="white"><i class="fa-solid fa-coins"></i> Банковские фишки:</font></h2><font size="4" color="white">
        <div class="block">
          <div class="block1">
            <p>Поиск информации по номеру карты:</p>
            <form action="admin.php" method="post">
              <input type="number" name="searchCardInf" placeholder="Введите номер карты" class="pole1" required><br><br>
              <button type="submit" class="OK">ОК</button><br><br>
            </form>
              <?php
                $cardNumb = $_POST['searchCardInf'];
                $searchCardInf1 = mysqli_query($mysql, "SELECT * FROM `card` WHERE `card_number` = '$cardNumb'");
                $searchCardInf = mysqli_fetch_assoc($searchCardInf1);
              ?>
            <p align="center">| <?= $searchCardInf['card_user'] ?> | <?= $searchCardInf['card_name'] ?> | <?= $searchCardInf['card_balance'] . ' ИР' ?> |</p>
          </div>
        </div>
        <div class="block">
          <div class="block1">
            <p>Пополнение/снятие со счёта</p>
            <form action="editBalance.php" method="post">
              <input type="number" name="cardNumb" placeholder="Введите номер карты" class="pole1" required><br><br>
              <select class="pole1" name="operationType">
                <option value="plus">Пополнение</option>
                <option value="minus">Снятие</option>
              </select><br><br>
              <input type="number" name="editSum" placeholder="Введите сумму" class="pole1" required><br><br>
              <button type="submit" class="OK">ОК</button><br><br>
            </form>
          </div>
        </div>
        <div class="block" id="lastBlock">
          <div class="block1">
            <p>Выдача штрафа</p>
            <form action="newPenalt.php" method="post">
              <input list="search" name="penaltFrom" class="pole1" placeholder="От кого штраф" required><br><br>
              <datalist id="search">
                <?php foreach ($userSel as $user) {?><option value="<?= $user['login'] ?>"><?php } ?>
              </datalist>
              <input type="number" name="penaltCardFrom" class="pole1" maxlength="4" placeholder="Номер карты получателя штрафа" required><br><br>
              <input list="search" name="penaltTo" class="pole1" placeholder="Кому штраф" required><br><br>
              <datalist id="search">
                <?php foreach ($userSel as $user) {?><option value="<?= $user['login'] ?>"><?php } ?>
              </datalist>
              <input type="number" name="penaltSum" class="pole1" placeholder="Сумма штрафа" required><br><br>
              <input type="text" name="penaltText" class="pole1" placeholder="Причина штрафа" required><br><br>
              <button type="submit" class="OK">ОК</button><br><br>
          </form>
          </div>
        </div>

      </div>
  </body>
</html>
<?php }
} ?>
