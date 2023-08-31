<?php
 include("../connect.php");

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
    <link rel="stylesheet" href="/CSS/market.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <title>Ринок</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
  <body bgcolor="#191a19">

    <div class="upMenu"> <!--Верхнее меню-->
      <p class="upMenuText">
        <a href="content.php"><img src="/images/2_green.png" width="40px" class="upMenuImg"><font color="white">Пітухск</font><sup><font color="#4e9f3d"> бета</font></sup></a>
      </p>
    </div><br><br>

    <div class="menu"> <!--Меню-->
          <?php
          $role_sel = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$_COOKIE[user]'");
          $role = mysqli_fetch_assoc($role_sel);
          ?>

          <ul>
            <li><a href="page.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-user"></i> Моя сторінка</p></a></li>
            <li><a href="content.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-house"></i> Головна</p></a></li>
            <li><a href="bank.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-building-columns"></i> Банк</p></a></li>
            <li><a href="market.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-cart-shopping"></i> Ринок <sup><font color="#4e9f3d" size="2"> new</font></sup></p></a></li>
            <!-- <li><a href="#" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-file-circle-check"></i> Петиції</p></a></li> -->
            <li><a href="players.php" id="text" target="content" class="butt"><p align="left"><i class="fa-solid fa-users"></i> Гравці <sup><font color="#4e9f3d" size="2"> new</font></sup></p></a></li>
            <li><?php if ($role['role'] == 'admin') {
              echo '<a href="admin.php" target="content" id="text" class="panel"><p align="left"><i class="fa-solid fa-bars"></i> Панель</p></a>';
            } ?></li>
          </ul>
      </div>

<div class="content"> <!--Основная часть сайта-->

  <div class="buttons">
    <a href="#newProduct"><button class="button"><i class="fa-solid fa-plus"></i> Створити оголошення</button></a>
    <a href="myProduct.php"><button class="button"><i class="fa-solid fa-cart-flatbed-suitcase"></i> Мої оголошення</button></a>
  </div><br>
    <form action="" method="post">
      <input type="text" name="searchProduct" class="pole1" placeholder="Пошук оголошень" required>
      <button type="submit" id="searchButt"></button>
      <label for="#searchButt" class="buttonSearch"><i class="fa-solid fa-magnifying-glass"></i></label>
    </form>
    <br>

  <div class="product">
    <div style="padding: 10px;">
      <img src="/images/nature.jpg" width="20%" height="100%" style="border-radius:5px; float:left; margin-right: 7px;">
      <font color="white" size="5"><a href="#product-" class="productHeader">Заголовок оголошення</a><font style="float:right;">36 ІР</font></font><br>
      <font color="#828282" size="3">Опис оголошення</font>
      <br><br><br><br>
      <font color="#828282" size="3">Шиза-сіті 23:16 13.04.2023<font style="float:right;">Maicl_GraB</font></font>
    </div>
  </div><br>

  <div class="windBack" id="newProduct">
    <font class="xmark" color="white" size="6"><a href=""><i class="fa-solid fa-xmark"></i></a></font>
    <div class="wind">
      <font color="white" size="5">Створення оголошення</font>
      <form action="" method="post"><br>
        <input type="text" name="" class="pole1" id="pole2" placeholder="Введіть заголовок оголошення" required><br><br>
        <textarea name="name" class="pole1" id="pole3" placeholder="Введіть опис оглошення" required></textarea><br><br>
        <input id="file-input" type="file" name="file" class="buttImgInv" accept="image/*">
        <div class="buttImg"><label for="file-input"><font style="margin-left:37%;"><i class="fa-solid fa-image"></i> Додати зображення</font></label></div><br>
        <div id="load"></div>

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

        <button type="submit" class="OK" id="buttSent">Опублікувати</button>
      </form>
    </div>
  </div>

</div>

</body>
</html>
<?php
  }
  mysqli_close($mysql);
?>
