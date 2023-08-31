<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $object_id = $_POST["object_id"];
    $username = $_POST["username"];

    $sqlSelect = "SELECT * FROM likes WHERE object_id = $object_id AND username = '$username'";
    $result = $mysql->query($sqlSelect);

    if ($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
}

$mysql->close();
?>
