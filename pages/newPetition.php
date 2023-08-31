<?php
  include("../connect.php");

  date_default_timezone_set('Europe/Vilnius');
  $petition_date = date('H:i d.m.Y');
  $petition_from = $_COOKIE['user'];
  $petition_header = $_POST['petitionHeader'];
  $petition_text = $_POST['petitionText'];

  if(!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    $name = $file['name'];
    $pathFile = __DIR__ . '/petition_file/' . $name;

    if(!move_uploaded_file($file['tmp_name'], $pathFile)) {

    }

    $new_petition = mysqli_query($mysql, "INSERT INTO `petition` (`header`, `text`, `file`, `date`, `username`) VALUES ('$petition_header', '$petition_text', '$name', '$petition_date', '$petition_from')");

  }

  mysqli_close($mysql);
  header('Location: petition.php');
?>
