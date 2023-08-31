<?php
  include("../connect.php");

  date_default_timezone_set('Europe/Vilnius');
  $post_date = date('H:i d.m.Y');
  $post_from = $_COOKIE['user'];
  $post_text = $_POST['post_text'];

  if(!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    $name = $file['name'];
    $pathFile = __DIR__ . '/post_file/' . $name;

    if(!move_uploaded_file($file['tmp_name'], $pathFile)) {

    }

    $new_post_file = mysqli_query($mysql, "INSERT INTO `post` (`post_date`, `post_from`, `post_text`, `post_file`) VALUES ('$post_date', '$post_from', '$post_text', '$name')");

  } else {
    $new_post = mysqli_query($mysql, "INSERT INTO `post` (`post_date`, `post_from`, `post_text`) VALUES ('$post_date', '$post_from', '$post_text')");
  }
  mysqli_close($mysql);
  header('Location: content.php');
 ?>
