<?php

  include("../connect.php");

  $post_id = $_POST['post_id'];

  $selPost1 = mysqli_query($mysql, "SELECT * FROM `post` WHERE `post_id` = '$post_id'");
  $selPost = mysqli_fetch_assoc($selPost1);

  mysqli_query($mysql, "DELETE FROM `post` WHERE `post_id` = '$post_id'");
  mysqli_query($mysql, "DELETE FROM `post_comm` WHERE `post_id` = '$post_id'");

  mysqli_close($mysql);
  header('Location: content.php');

?>
