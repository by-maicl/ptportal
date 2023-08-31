<?php
 include("connect.php");
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <link rel="shortcut icon" href="images/2_green.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/button.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пітухск</title>
    <script src="https://kit.fontawesome.com/20e02f2fbf.js" crossorigin="anonymous"></script>
  </head>
 <body bgcolor="#191a19">

   <div class="upMenu">
     <div class="upMenuStyle">
       <div class="upMenuLogo">
         <a href="index.php"><img src="images/logo.png" width="30px" class="upMenuImg"><font color="white" size="4" class="upMenuHeader">Пітухск</font></a>
       </div>
       <div class="upMenuInf">
         <a href="index.php" class="upMenuInfText">Головна</a>
         <a href="rules.php" class="upMenuInfText">Правила</a>
       </div>
       <div class="upMenuAcc">
         <a href="login.php"><button class="button">Увійти</button></a>
       </div>
     </div>
   </div>

     <div class="content">
       <div class="contentHeader">
         <font color="white"><h1>Пітухск</h1></font>
         <font color="white" size="4"><p>Приватний майнкрафт сервер,<br>заснований на грі з друзями без грифів та приватів</p></font>

         <button class="blob-btn" onclick="self.location = 'index.php#start';">
           Почати грати
           <span class="blob-btn__inner">
             <span class="blob-btn__blobs">
               <span class="blob-btn__blob"></span>
               <span class="blob-btn__blob"></span>
               <span class="blob-btn__blob"></span>
               <span class="blob-btn__blob"></span>
             </span>
           </span>
         </button>
         <br/>

         <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
           <defs>
             <filter id="goo">
               <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
               <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
               <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
             </filter>
           </defs>
         </svg>

       </div>
       <div class="contentImg">
         <img src="images/parlamentnight.png" class="imgParlament">
       </div>
     </div>

   <div class="start" id="start">
     <div class="startInf">
       <font color="white"><h1 align="center" class="startHeader">Як почати грати?</h1></font>
       <font size="5" color="white"><p>Для початку вам потрібно приєднатись до нашого <u><b><a href="https://discord.gg/CMhkvf6H7R" target="_blank">Діскорд серверу <i class="fa-solid fa-arrow-up-right-from-square"></i></a></b></u>. Там вам необхідно отримати роль та встановити збірку слідуючи інструкції.</p>
       <p>А далі потрібно лиш зайти та насолоджуватись грою та не порушувати <u><a href="rules.php">правил</a></u>!</p></font>
     </div>
     <div class="basement">
       <div class="basementStyle">
         <hr color="#828282">
         <p align="center">
         <a href="https://www.instagram.com/pityhsk_official/" target="_blank" class="upMenuInfText"><i class="fa-brands fa-instagram"></i> Instagram</a>
         <a href="https://www.youtube.com/channel/UCq9z9_gdP2oO13QbFSZfKOw" target="_blank" class="upMenuInfText"><i class="fa-brands fa-youtube"></i> YouTube</a><br>
         <font color="white">Пітухск 2019-2023</font></p>
       </div>
     </div>
   </div>

 </body>
</html>
