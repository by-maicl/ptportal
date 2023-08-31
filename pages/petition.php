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
      <button class="button" id="firstButt" onclick="self.location = 'petition.php#newPetition';"><i class="fa-solid fa-plus"></i> Створити петицію</button>
      <button class="button" onclick="self.location = 'petitionSub.php'"><i class="fa-solid fa-check"></i> Завершені</button>
    </div><br>

    <?php
      $petitionSel1 = mysqli_query($mysql, "SELECT * FROM `petition` WHERE `status` = 1 ORDER BY `id` DESC");
      $petitionSel = mysqli_fetch_assoc($petitionSel1);

      foreach ($petitionSel1 as $petition) {

        $petitionSubSel1 = mysqli_query($mysql, "SELECT * FROM `petition_sub` WHERE `username` = '$_COOKIE[user]' AND `petition_id` = '$petition[id]'");
        $petitionSubSel = mysqli_fetch_assoc($petitionSubSel1);
     ?>

    <div class="petitions">
      <div class="petition" onclick="self.location = 'petition.php#<?= $petition['id'] ?>'">
        <img src="petition_file/<?= $petition['file'] ?>" class="petitionImg">
        <div class="petitionStyle">
          <h2 class="petitionHeader"><?= $petition['header'] ?></h2><font class="petitionBr"><br><br><br></font>
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
            <details>
              <summary class="answerWatch" id="answerButt">Відповісти народу</summary>
              <form action="answerPetition.php" method="post"><br>
                <textarea name="answerText" class="pole1" id="pole3" placeholder="Введіть відповідь на петицію" required></textarea><br><br>
                <input type="hidden" name="answerPetitionId" value="<?= $petition['id'] ?>">
                <select class="pole1" name="support">
                  <option value="true">Підтримано</option>
                  <option value="false">Непідтримано</option>
                </select><br><br>
                <button type="submit" class="OK" id="buttSent">ОК</button>
              </form>
              <hr color="#414141">
            </details>
          <?php endif; ?>
          <p class="watchText"><?= $petition['text'] ?></p>
          <div class="subMob">
            <hr color="#414141">
            <?php
                  if ($petitionSubSel['petition_id'] == $petition['id']) {
                    echo '<button class="sub-petition" id="watchSub">Ви вже підтримали цю петицію</button>';
                  } else {?>
                  <form action="subPetition.php" method="post">
                    <input type="hidden" name="petitionId" value="<?= $petition['id'] ?>">
                    <button type="submit" class="sub-petition" id="watchSub">Підтримати</button>
                  </form>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>

    <div class="windBack" id="newPetition"> <!--Создание петиции-->
      <div class="wind">
        <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
        <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
        <font color="white" size="5" class="windHeader">Створення петиції</font><br><br>
        <form action="newPetition.php" method="post" enctype="multipart/form-data">
          <input type="text" name="petitionHeader" required placeholder="Введіть заголовок петиції" class="pole1"><br><br>
          <textarea name="petitionText" class="pole1" id="pole3" placeholder="Введіть текст петиції" required></textarea><br><br>
          <input id="file-input" type="file" name="file" class="buttImgInv" accept="image/*">
          <div class="buttImg"><label for="file-input"><font class="buttImgText"><i class="fa-solid fa-image"></i> Додати зображення</font></label></div><br>
          <div id="load"></div>
          <div align="center" class="warnCreate">Уважно перечитайте всі пункти, бо далі їх не можна буде змінити!</div>
          <button type="submit" class="OK" id="buttSent">ОК</button>
        </form>
      </div>
    </div>

    <script type="text/javascript">
      let load = document.querySelector('#load');

      document.querySelector('#file-input').addEventListener('change', function(e) {
        let tgt = e.target || window.event.srcElement,
              files = tgt.files;

        load.innerHTML = '';

        if(files && files.length) {
          for(let i = 0; i < files.length; i++) {
              let $self = files[i],
                      fr = new FileReader();
              fr.onload = function(e) {
              load.insertAdjacentHTML('beforeEnd', `<div class="load-img"><img src="${e.srcElement.result}"/></div>`);
              }
              fr.readAsDataURL(files[i]);
          };
        }
      });
    </script>

  </div>
  </body>
</html>
<?php } ?>
