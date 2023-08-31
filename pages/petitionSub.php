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
    <link rel="stylesheet" href="/CSS/petition.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Петиції</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
    <script src="petition.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body bgcolor="#191a19">


  <div class="content"> <!--Основная часть сайта-->

    <div class="buttons">
      <button class="button" id="firstButt" onclick="self.location = 'petition.php';"><i class="fa-solid fa-check-to-slot"></i> Активні</button>
      <button class="button" onclick="self.location = 'petitionSub.php"><i class="fa-solid fa-check"></i> Завершені</button>
    </div><br>

    <?php
      $petitionSel1 = mysqli_query($mysql, "SELECT * FROM `petition` WHERE `status` = 0 ORDER BY `id` DESC");
      $petitionSel = mysqli_fetch_assoc($petitionSel1);

      foreach ($petitionSel1 as $petition) {

        $petitionSubSel1 = mysqli_query($mysql, "SELECT * FROM `petition_sub` WHERE `username` = '$_COOKIE[user]' AND `petition_id` = '$petition[id]'");
        $petitionSubSel = mysqli_fetch_assoc($petitionSubSel1);
     ?>

    <div class="petitions">
      <div class="petition" onclick="self.location = 'petitionSub.php#<?= $petition['id'] ?>'">
        <img src="petition_file/<?= $petition['file'] ?>" class="petitionImg">
        <div class="petitionStyle">
          <h2 class="petitionHeader"><?= $petition['header'] ?></h2>
          <font class="petitionBr"><br><br><br></font>
          <p class="petitionInf"><?= $petition['username'] ?> <br><?= $petition['date'] ?></p>
          <p class="petitionSub"><?= $petition['subscribe'] ?> / 5</p><font class="petitionBr"><br><br></font>
          <progress value="<?= $petition['subscribe'] ?>" max="5" class="progress"></progress><br>
        </div>
      </div><br>
    </div>

    <div class="windBack" id="<?= $petition['id'] ?>"> <!--Просмотр петици-->
      <div class="wind">
        <div class="windPhone">
          <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
          <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
          <font color="white" size="5" class="windHeader"><b><?= $petition['header'] ?></b></font><br><br>
          <img src="petition_file/<?= $petition['file'] ?>" class="watchImg">
          <?php if ($role['role'] == 'admin' && $petition['status'] == 1 && $petition['subscribe'] >= 5): ?>
          <?php endif;
          if ($petition['status'] == 0): ?>
          <details>
            <summary class="answerWatch">Відповідь на петицію</summary><br>
            <?php
              if ($petition['support'] == 'true') {
                echo '<div class="supportTrue">Підтримано</div>';
              } else {
                echo '<div class="supportFalse">Непідтримано</div>';
              }
             ?>
            <p class="answerText"><?= $petition['answer'] ?><br><br>
            Відповів: <?= $petition['answer_from'] ?></p>
            <hr color="#414141">
          </details>
          <?php endif; ?>
          <p class="watchText"><?= $petition['text'] ?></p>
        </div>
      </div>
    </div>

  <?php } ?>

  </div>
  </body>
</html>
<?php } ?>
