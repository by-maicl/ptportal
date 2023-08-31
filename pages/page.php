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
    <link rel="stylesheet" href="/CSS/page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя сторінка</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">


<div class="content"> <!--Основная часть сайта-->

  <div class="profile">
    <div class="profile2">
      <img src="ava_user/<?= $role['ava'] ?>" class="ava_user"><font color="white" size="5"><?= $_COOKIE['user'] ?></font>
      <br>
      <font color="#828282" size="3" style="clear: top"><?= $role['description'] ?></font>
    </div><br>
  </div><br>
  <div class="buttProfBlock">
    <button class="buttProf" onclick="self.location = 'page.php#editProfile';" id="firstButt"><i class="fa-regular fa-pen-to-square"></i> Змінити профіль</button>
    <button class="buttProf" onclick="self.location = '/validatoin-form/exit.php';"><i class="fa-solid fa-door-open"></i> Вийти</button>
  </div><br>
  <?php
    if ($role['role'] == 'admin') {
      echo '<a href="admin.php"><button class="buttProf" id="mobButtPanel"><i class="fa-solid fa-bars"></i> Панель</button></a>';
     } ?>

  <div class="windBack" id="editProfile"> <!--Изменение профиля-->
    <div class="wind">
      <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
      <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
      <font color="white" size="5" class="windHeader">Зміна профілю</font><br><br>
      <form action="editProfile.php" method="post" enctype="multipart/form-data">
        <textarea name="description" class="pole1" id="pole3" placeholder="Введіть опис профілю" required><?= $role['description'] ?></textarea><br><br>
        <input id="file-input" type="file" name="file" class="buttImgInv" accept="image/*" value="<?= $role['ava'] ?>">
        <div class="buttImg"><label for="file-input"><font style="margin-left:37%;"><i class="fa-solid fa-user"></i> Змінити аватар</font></label></div><br>
        <div id="load"></div>
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

    <?php
       $postSel1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_from` = '$_COOKIE[user]' ORDER BY `post_id` DESC");
       $postSel = mysqli_fetch_assoc($postSel1);

       $selPublic1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `post` WHERE `post_from` = '$_COOKIE[user]'");
       $selPublic = mysqli_fetch_assoc($selPublic1);
     ?>

    <div class="public">
      <?php if ($selPublic['count'] == 0) { ?>
        <div class="public0">
            <font color="#828282" size="4"><p align="center">Тут з'являться ваші публікації</font><br><br>
            <a href="content.php" class="buttNewPost">Створити публікацію</a></p>
        </div>
      <?php } ?>
      <div class="public1">
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


</body>
</html>
<?php
  }
  mysqli_close($mysql);
?>
