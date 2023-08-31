<?php

  include("../connect.php");

  $editPostText = $_POST['editPostText'];
  $postId = $_POST['postId'];

  $new_card = mysqli_query($mysql, "UPDATE `post` SET `post_text` = '$editPostText' WHERE `post_id` = '$postId'");
  mysqli_close($mysql);
  header('Location: content.php#' . $postId . '');

?>
