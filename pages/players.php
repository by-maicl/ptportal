<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  include("../connect.php");
  include "menu.php";

  if($_COOKIE['user'] == ''){
    echo "<script>self.location='/index.php';</script>";
  } else {

  $userSel = mysqli_query($mysql, "SELECT * FROM `user`");
 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="shortcut icon" href="/images/2_green.png" type="image/x-icon">
  <link rel="stylesheet" href="/CSS/menu.css">
  <link rel="stylesheet" href="/CSS/upMenu.css">
  <link rel="stylesheet" href="/CSS/players.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Гравці</title>
 <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
</head>
  <body bgcolor="#191a19">

         <div class="content"> <!--Основная часть сайта-->

             <div class="search">
                 <form action="players.php" method="post">
                 <input list="search" name="search" placeholder="Введіть нік гравця" required class="pole1">
                 <datalist id="search">
                   <?php foreach ($userSel as $user) {?><option value="<?= $user['login'] ?>"><?php } ?>
                 </datalist>
                 <button type="submit" id="searchButt"></button>
                 <label for="#searchButt" class="button"><i class="fa-solid fa-magnifying-glass"></i></label>
               </form>
             </div><br>
             <?php
               $player = $_POST['search'];
               $selPlayer1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$player'");
               $playerName = mysqli_fetch_assoc($selPlayer1);

               if ($player == "") {
                 echo '<p class="startText" align="center">Тут ви можете знайти сорінку гравця по ніку</p>';
               } else {
             ?>
             <div class="profile">
               <div class="profile2">
                 <img src="ava_user/<?= $playerName['ava'] ?>" class="ava_user"><font color="white" size="5"><?= $playerName['login'] ?></font>
                 <br>
                 <font color="#828282" size="3" style="clear: top"><?= $playerName['description'] ?></font><br><br>
                 <hr color="#414141">
                 <p style="color:white;font-size:18px;">Публикації:</p>

                 <?php
                    $postSel1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_from` = '$player' ORDER BY `post_id` DESC");
                    $postSel = mysqli_fetch_assoc($postSel1);

                    $selPublic1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `post` WHERE `post_from` = '$player'");
                    $selPublic = mysqli_fetch_assoc($selPublic1);
                  ?>

                 <div class="public">
                   <?php if ($selPublic['count'] == 0) { ?>
                         <font color="#828282" size="3"><p>Гравець не створив жодної поблікації</font><br><br>
                   <?php } ?>
                   <?php foreach ($postSel1 as $post) {
                     if ($post['post_file'] == '') {
                           echo '<a href="content.php#' . $post['post_id'] . '"><div class="post">
                                 <div class="post1">
                                 <p>' . $post['post_text'] . '<p>
                                 </div>
                                 </div></a>';
                     } else {
                           echo '<a href="content.php#' . $post['post_id'] . '"><div class="post" style="background-image: url(post_file/' . $post['post_file'] . ');">
                                 <div class="post1">
                                 </div>
                                 </div></a>';
                     }
                    }
                    ?>
                 </div>

               </div>
             </div><br> <?php } ?>

         </div>

  </body>
</html>
<?php } ?>
