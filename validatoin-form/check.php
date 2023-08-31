<?php
 $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
 $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

 $password = md5($password."su8ft89er7v");

 include("../connect.php");

 $check = mysqli_query($mysql, "SELECT * FROM `user` WHERE `login` = '$login'");
 $check1 = mysqli_fetch_assoc($check);

 if ($check1['password'] == 0) {
   $upd = mysqli_query($mysql, "UPDATE `user` SET `password` = '$password' WHERE `login` = '$login'");
 } else {
   echo '<script>alert("Користувач вже зареєстрований!");
   self.location=("/");
   </script>';
   exit();
 }

 if(count($check1['login']) == 0) {
   echo '<script>alert("Хибний нік!");
   self.location=("/");
   </script>';
   exit();
 }

 mysqli_close($mysql);
 header('Location: /');
?>
