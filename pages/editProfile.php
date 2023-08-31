<?php
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 include("../connect.php");

 $description = $_POST['description'];
 $login = $_COOKIE['user'];

 if(!empty($_FILES['file'])) {
   $file = $_FILES['file'];
   $name = $file['name'];
   $pathFile = __DIR__ . '/ava_user/' . $name;

   if(!move_uploaded_file($file['tmp_name'], $pathFile)) {

   }
   
   $updProfileAva = mysqli_query($mysql, "UPDATE `user` SET `ava` = '$name', `description` = '$description' WHERE `login` = '$login'");

 } else {
   $updProfile = mysqli_query($mysql, "UPDATE `user` SET `description` = '$description' WHERE `login` = '$login'");
 }

 mysqli_close($mysql);
 header('Location: page.php');
?>
