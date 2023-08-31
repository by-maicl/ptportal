<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include "../connect.php";
 include "menu.php";

 if($_COOKIE['user'] == ''){
   echo "<script>self.location='/index.php';</script>";
 } else { ?>
<!DOCTYPE html>
<html lang="ru">
 <head>
   <link rel="shortcut icon" href="../images/2_green.png" type="image/x-icon">
   <link rel="stylesheet" href="../CSS/menu.css">
   <link rel="stylesheet" href="../CSS/upMenu.css">
   <link rel="stylesheet" href="../CSS/content.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Головна</title>
  <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
  <script src="script.js"></script>
 </head>
 <body bgcolor="#191a19">

 <div class="content"> <!--Основная часть сайта-->
   <div class="blocks">
     <div class="sort">
       <div class="sortBlock">
         <div class="sortStyle">
           <p class="sortHeader">Реклама:</p>
           <hr color="#414141">
           <p class="sortHeader">Тут могла бути ваша реклама</p>
         </div>
       </div>
     </div>

     <?php
       $post_sel = mysqli_query($mysql, "SELECT * FROM `post` ORDER BY `post_id` DESC");
       $post_sel1 = mysqli_fetch_assoc($post_sel);
      ?>

     <div class="block1">

   <div> <!--Новый пост-->
      <form id="upload" action="new_post.php" method="post" enctype="multipart/form-data">
        <div class="post">
        <div class="postStyle">
         <img src="ava_user/<?= $role['ava'] ?>" width="50px" height="50px" id="avaPost"> <textarea name="post_text" placeholder="Що нового, <?php echo $_COOKIE['user'] ?>?" class="pole1" id="new_post_pole" maxlength="5000" required></textarea>
         <font class="but_new">
           <input id="file-input" type="file" name="file" class="button" accept="image/*">
           <label for="file-input"><i class="fa-solid fa-image" id="but_new1"></i></label>
           <button type="submit" class="button" id="but_upl"></button>
           <label for="but_upl"><i class="fa-solid fa-arrow-right" id="but_new2"></i></label>
         </font>
         <div id="load"></div>
        </div>
       </div>
      </form>
      <br>

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


        var textarea = document.querySelector('textarea');
        textarea.addEventListener('keyup', function(){
        if(this.scrollTop > 0){
          this.style.height = this.scrollHeight + "px";
        }
        });
      </script>
    </div>

      <!--Посты-->
      <?php
        foreach ($post_sel as $posts) {

          $postFrom1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$posts[post_from]'");
          $postFrom = mysqli_fetch_assoc($postFrom1);

          $commCount1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `post_comm` WHERE `post_id` = '$posts[post_id]'");
          $commCount = mysqli_fetch_assoc($commCount1);
      ?>

     <div class="post" id="<?= $posts['post_id'] ?>">
       <div class="postStyle">
       <font color="white" size="4">
       <img src="ava_user/<?= $postFrom['ava'] ?>" width="50px" height="50px" id="avaPost"> <B><?= $posts['post_from'] ?></B></font><br>
       <font color="grey" size="2"><?= $posts['post_date'] ?></font><br>
       <p class="post_text"><font color="white" size="3"><?= $posts['post_text']  ?></font></p>

       <?php
         if ($posts['post_file'] == '') {} else { ?>
           <img src="<?php echo 'post_file/' . $posts['post_file']; ?>" class="post_file"> <?php
         }
        ?>

       <hr color="#414141">

       <div class="postDown">
          <div class="likeable-object" data-id="<?= $posts['post_id'] ?>">
            <button class="like-button" id="like"><i class="fa-regular fa-heart"></i></button>
            <button class="unlike-button" id="like" style="display:none"><i class="fa-solid fa-heart"></i></button>
            <span class="likes-count">0</span>
            <input type="hidden" class="username-input" placeholder="Ваше ім'я" value="<?= $_COOKIE['user'] ?>">
          </div>

          <div class="additButt">
            <?php
             if ($role['role'] == 'admin' or $posts['post_from'] == $_COOKIE['user']) {
               echo '<a href="#postEdit-' . $posts['post_id'] . '"><i class="fa-regular fa-pen-to-square" id="postEdit"></i></a> <a href="#postDel-' . $posts['post_id'] . '"><i class="fa-regular fa-trash-can" id="postDel"></i></a>';
             }
            ?>
          </div>
        </div>
       <details>
         <summary class="watch_comm"><font size="4">
           <?php if ($commCount['count'] == 0) {
            echo 'Переглянути коментарі'; } else echo 'Переглянути коментарі (' . $commCount['count'] . ')';
           ?>
          </font></summary>
         <br>
         <div class="comm">
             <form action="sent_comm.php" method="post">
               <div class="commParts">
                 <div class="commPart1">
                   <img src="ava_user/<?= $role['ava'] ?>" width="35px" height="35px" id="ava_comm">
                   <input type="text" name="comm_text" placeholder="Додайте коментар" class="pole1" id="pole_comm" maxlength="500" required>
                   <input type="text" name="post_id" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required>
                 </div>
                 <div class="commPart2">
                   <button type="submit" name="button" class="commButtSent"><i class="fa-solid fa-arrow-right"></i></button>
                 </div>
               </div>
            </form>
            <br>

               <?php
                $postId = $posts['post_id'];
                $selComm = mysqli_query($mysql, "SELECT * FROM `post_comm` WHERE `post_id` = '$postId' ORDER BY `id` DESC");
                $selComm1 = mysqli_fetch_assoc($selComm);

                foreach ($selComm as $comms) {

                  $postFrom1 = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$comms[comm_from]'");
                  $postFrom = mysqli_fetch_assoc($postFrom1);
               ?>

               <div class="commBlock">
                 <img src="ava_user/<?= $postFrom['ava'] ?>" width="35px" height="35px" id="ava_comm">
                 <p class="commText"><b><?= $comms['comm_from'] ?></b> <font class="commDate"><?= $comms['comm_date'] ?></font><br>
                 <?= $comms['comm_text'] ?></p>
                 </div>

                 <div class="commDo">
                   <details>
                     <summary class="commAnswerHeader">Відповісти</summary>
                       <form action="" method="post">
                         <div class="commAnswerParts">
                           <div class="commAnswerPart1">
                             <img src="ava_user/<?= $role['ava'] ?>" width="35px" height="35px" id="ava_comm">
                             <input type="text" name="comm_text" placeholder="Відповідь <?= $comms['comm_from'] ?>" class="pole1" id="pole_comm" maxlength="500" required>
                           </div>
                           <div class="commAnswerPart2">
                             <button type="submit" name="button" class="commButtSent"><i class="fa-solid fa-arrow-right"></i></button>
                           </div>
                         </div>
                       </form>
                   </details>

                   <details>
                     <summary class="commAnswer">—— Переглянути відповіді (1)</summary><br>
                     <img src="ava_user/<?= $postFrom['ava'] ?>" width="35px" height="35px" id="ava_comm">
                     <p class="commText commTextAnswer"><b><?= $comms['comm_from'] ?></b> <font class="commDate"><?= $comms['comm_date'] ?></font><br>
                     <?= $comms['comm_text'] ?></p>
                     <details>
                       <summary class="commAnswerHeader commAnswerHeader2">Відповісти</summary>
                         <form action="" method="post">
                           <div class="commAnswerParts">
                             <div class="commAnswerPart1">
                               <img src="ava_user/<?= $role['ava'] ?>" width="35px" height="35px" id="ava_comm">
                               <input type="text" name="comm_text" placeholder="Відповідь <?= $comms['comm_from'] ?>" class="pole1" id="pole_comm" maxlength="500" required>
                             </div>
                             <div class="commAnswerPart2">
                               <button type="submit" name="button" class="commButtSent"><i class="fa-solid fa-arrow-right"></i></button>
                             </div>
                           </div>
                         </form>
                     </details>
                   </details><br>

                 </div><br>

             <div class="windBack" id="commDel-<?= $comms['id'] ?>"> <!--Удаление комментария-->
               <div class="wind" id="windDel">
                 <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
                 <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
                 <font color="white" size="5"><p align="center">Видалити коментар?</p></font>
                 <form action="delComm.php" method="post">
                   <input type="text" name="comm_id" class="pole1" id="invisibleInput" value="<?= $comms['id'] ?>" readonly required>
                   <button type="submit" class="OK" id="okDel">Так</button>
                 </form>
               </div>
             </div>

             <?php } ?>
             </div>
          </details>
       </div>
       </div>
     <br>

     <div class="windBack" id="postEdit-<?= $posts['post_id'] ?>"> <!--Изменение поста-->
       <div class="wind">
         <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
         <a href="" class="xmark"><i class="fa-solid fa-xmark"></i></a>
         <font color="white" size="5" class="windHeader">Зміна публікації</font>
         <form action="editPost.php" method="post"><br>
           <textarea name="editPostText" placeholder="Введіть новий вміст" class="pole2" id="editPostPole" maxlength="5000" required><?= $posts['post_text'] ?></textarea><br>
             <script type="text/javascript">
               var textarea = document.querySelector("#editPostPole");
               textarea.addEventListener('keyup', function(){
               if(this.scrollTop > 0){
                 this.style.height = this.scrollHeight + "px";
               }
               });
             </script>
           <input type="text" name="postId" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required><br>
           <button type="submit" class="OK">ОК</button>
         </form>
       </div>
     </div>

     <div class="windBack" id="postDel-<?= $posts['post_id'] ?>"> <!--Удаление поста-->
       <div class="wind" id="windDel">
         <a href="" class="xmarkPhone"><i class="fa-solid fa-arrow-left"></i></a>
         <font color="white" size="5"><p align="center">Видалити публікацію?</p></font>
         <form action="delPost.php" method="post">
           <input type="text" name="post_id" class="pole1" id="invisibleInput" value="<?= $posts['post_id'] ?>" readonly required>
           <div class="buttonsDel">
             <button type="submit" class="OK" id="okDel">Так</button>
             <button type="reset" onclick="self.location=''" class="OK NO" id="okDel">Ні</button>
           </div>
         </form>
       </div>
     </div>

     <?php } ?>

     </div>

     </div>
   </div>
</div>
 </body>
</html>
 <?php } ?>
