<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("../connect.php");

 if($_COOKIE['user'] == ''){
   echo "<script>self.location='/index.php';</script>";
 } else {

   $role_sel = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
   $role = mysqli_fetch_assoc($role_sel);
?>
<!DOCTYPE html>
<html lang="ru">
 <head>
   <link rel="shortcut icon" href="../images/2_green.png" type="image/x-icon">
   <link rel="stylesheet" href="../CSS/menu.css">
   <link rel="stylesheet" href="../CSS/upMenu.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Пітухск</title>
  <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
 </head>
 <body bgcolor="#191a19">

   <div class="upMenuPhone">
     <p>
       <a href="content.php"><img src="../images/logo.png" width="40px" class="upMenuImg"><font color="white">Пітухск</font></a>
       <div align="right" onclick="self.location='#notification'"><i class="fa-solid fa-bell" id="bellMob"></i><i class="fa-solid fa-circle" id="bellCircleMob"></i><font class="bellCountMob">2</font></div>
     </p>
   </div>

   <div class="upMenu">
     <p class="upMenuText">
       <a href="content.php"><img src="/images/logo.png" width="40px" class="upMenuImg"><font color="white">Пітухск</font></a>
       <font onclick="sendAjaxRequest()"><font onclick="toggle(document.getElementById('notification'))" style="cursor:pointer;"><i class="fa-solid fa-bell" id="bell"></i>

         <?php
         $notificationCount1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `notification` WHERE `user_to` = '$_COOKIE[user]' AND `status` = 1");
         $notificationCount = mysqli_fetch_assoc($notificationCount1);
         if ($notificationCount['count'] != 0):
           if ($notificationCount['count'] > 9): ?>
           <i class="fa-solid fa-circle" id="bellCircle"></i>
           <font class="bellCount bellCountMore">9+</font>
          <?php else: ?>
           <i class="fa-solid fa-circle" id="bellCircle"></i>
           <font class="bellCount"><?= $notificationCount['count'] ?></font>
         <?php endif; endif; ?>

         <script>
         function sendAjaxRequest() {
     var xhr = new XMLHttpRequest();
     xhr.open('GET', 'updNotification.php', true);

     xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE) {
             if (xhr.status === 200) {
                 // Обробка успішної відповіді
                 var response = xhr.responseText;
                 console.log(response);
             } else {
                 // Обробка помилки
                 console.error('Помилка: ' + xhr.status);
             }
         }
     };

     xhr.send();
 }

    </script>

    </font></font>
     </p>
   </div><font class="br"><br><br></font>

 <div class="menu"> <!--Меню-->
     <ul>
       <li><a href="page.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-user"></i> Моя сторінка</p></a></li>
       <li><a href="content.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-house"></i> Головна</p></a></li>
       <li><a href="bank.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-building-columns"></i> Банк</p></a></li>
       <li><a href="petition.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-check-to-slot"></i> Петиції</p></a></li>
       <li><a href="players.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-users"></i> Гравці</p></a></li>
       <li><?php if ($role['role'] == 'admin') {
         echo '<a href="admin.php" target="content" id="text" class="panel"><p align="left"><i class="fa-solid fa-bars"></i> Панель</p></a>';
       } ?></li>
     </ul>
</div>

  <div class="mobMenuLox"> <!--Меню для тел-->
      <ul class="mobMenuList">
        <li class="mobMenuPart"><a href="content.php" target="content" class="mobMenuHref"><i class="fa-solid fa-house"></i></a></li>
        <li class="mobMenuPart"><a href="petition.php" target="content" class="mobMenuHref"><i class="fa-solid fa-check-to-slot"></i></a></li>
        <li class="mobMenuPart"><a href="bank.php" target="content" class="mobMenuHref"><i class="fa-solid fa-building-columns"></i></a></li>
        <li class="mobMenuPart"><a href="players.php" target="content" class="mobMenuHref"><i class="fa-solid fa-users"></i></a></li>
        <li class="mobMenuPart"><a href="page.php" target="content" class="mobMenuHref"><img src="ava_user/<?= $role['ava'] ?>" width="25px" height="25px" id="ava"></a></li>
      </ul>
  </div>

  <div class="windNotification" id="notification" style="display: none;">
    <div class="windNotificationStyle">
      <p class="notificationHeader">Сповіщення</p>
      <hr color="#414141" class="notificationHr">

      <?php
      $notificationSel1 = mysqli_query($mysql, "SELECT * FROM `notification` WHERE `user_to` = '$_COOKIE[user]' ORDER BY `id` DESC");
      $notificationSel = mysqli_fetch_assoc($notificationSel1);

      foreach ($notificationSel1 as $notification):

        $selAva1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$notification[user_from]'");
        $selAva = mysqli_fetch_assoc($selAva1);

        $selImg1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_id` = '$notification[object_id]'");
        $selImg = mysqli_fetch_assoc($selImg1);

        $selImgPetition1 = mysqli_query($mysql, "SELECT * FROM `petition` WHERE `id` = '$notification[object_id]'");
        $selImgPetition = mysqli_fetch_assoc($selImgPetition1);

        if ($notification['type'] == 'like') {
       ?>

      <div class="notification" onclick="self.location = 'content.php#<?= $selImg['post_id'] ?>';">
        <div class="notificationStyle">
          <div class="part1">
            <img src="ava_user/<?= $selAva['ava'] ?>" class="notificationAva">
            <p class="notificationName"><b><?= $notification['user_from'] ?></b> вподобав ваш допис <br><font><?= $notification['date'] ?></font></p>
          </div>
          <div class="part2">
            <?php if ($selImg['post_file'] == ""): ?>
              <div class="notificationImg"></div>
            <?php else: ?>
            <img src="post_file/<?= $selImg['post_file'] ?>" class="notificationImg">
            <?php endif; ?>
          </div>
        </div>
      </div>

    <?php } elseif ($notification['type'] == 'comm') { ?>

      <div class="notification" onclick="self.location = 'content.php#<?= $selImg['post_id'] ?>';">
        <div class="notificationStyle">
          <div class="part1">
            <img src="ava_user/<?= $selAva['ava'] ?>" class="notificationAva">
            <p class="notificationName"><b><?= $notification['user_from'] ?></b> коментує: <?= $notification['text'] ?><br><font><?= $notification['date'] ?></font></p>
          </div>
          <div class="part2">
            <?php if ($selImg['post_file'] == ""): ?>
              <div class="notificationImg"></div>
            <?php else: ?>
            <img src="post_file/<?= $selImg['post_file'] ?>" class="notificationImg">
            <?php endif; ?>
          </div>
        </div>
      </div>

    <?php } elseif ($notification['type'] == 'petition') { ?>

      <div class="notification" onclick="self.location = 'petitionSub.php#<?= $selImgPetition['id'] ?>';">
        <div class="notificationStyle">
          <div class="part1">
            <font class="notificationAva"><i class="fa-solid fa-check-to-slot"></i></font>
            <p class="notificationName">Оновлення статусу підсисаної вами петиції<br><font><?= $notification['date'] ?></font></p>
          </div>
          <div class="part2">
            <img src="petition_file/<?= $selImgPetition['file'] ?>" class="notificationImg">
          </div>
        </div>
      </div>

    <?php } elseif ($notification['type'] == 'penalt') { ?>

      <div class="notification" onclick="self.location = 'penalty.php';">
        <div class="notificationStyle">
          <div class="part1">
            <font class="notificationAva"><i class="fa-solid fa-money-bills"></i></font>
            <p class="notificationName"><?= $notification['text'] ?><br><font><?= $notification['date'] ?></font></p>
          </div>
        </div>
      </div>
    <?php }; endforeach; ?>

    </div>
  </div>

  <script type="text/javascript">
    function toggle(el) {
      el.style.display = (el.style.display == 'none') ? 'block' : 'none';
    }
  </script>

</body>
</html>
<?php } ?>
