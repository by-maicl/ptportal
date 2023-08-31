<?php
    include("../connect.php");

    date_default_timezone_set('Europe/Vilnius');
    $commFrom = $_COOKIE['user'];
    $commDate = date('H:i d.m.Y');
    $commText = $_POST['comm_text'];
    $postId = $_POST['post_id'];

    $addComm = mysqli_query($mysql, "INSERT INTO `post_comm` (`post_id`, `comm_from`, `comm_date`, `comm_text`) VALUES ('$postId', '$commFrom', '$commDate', '$commText')");

    $selCommQnt1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_id` = '$postId'");
    $selCommQnt = mysqli_fetch_assoc($selCommQnt1);


    $selComm1 = mysqli_query($mysql, "SELECT * FROM `post_comm` WHERE `post_id` = '$postId' ORDER BY `id` DESC");
    $selComm = mysqli_fetch_assoc($selComm1);
    $commId = $selComm['id'];

    $notificationSel1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_id` = '$postId'");
    $notificationSel = mysqli_fetch_assoc($notificationSel1);
    $notificationTo = $notificationSel['post_from'];

    if ($commFrom != $notificationTo) {
      $notificationAdd = mysqli_query($mysql, "INSERT INTO `notification` (`object_id`, `object_id2`, `user_from`, `user_to`, `type`, `text`, `date`) VALUES ('$postId', '$commId', '$commFrom', '$notificationTo', 'comm', '$commText', '$commDate')");
    }

    mysqli_close($mysql);
    header('Location: content.php#' . $postId . '');
?>
