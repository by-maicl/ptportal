<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $object_id = $_POST["object_id"];

    $selLikeUpd1 = mysqli_query($mysql, "SELECT COUNT(*) as count FROM `likes` WHERE `object_id` = '$object_id'");
    $selLikeUpd = mysqli_fetch_assoc($selLikeUpd1);
    if ($selLikeUpd1->num_rows > 0) {
        echo $selLikeUpd['count'];
    }
}

$mysql->close();
?>
