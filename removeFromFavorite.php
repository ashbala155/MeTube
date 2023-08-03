<?php
    require_once("main.php");
    $vidId = (int)$_GET['Id'];
    $checkquery = $con->prepare("SELECT * from favorites where userName='$loggedInUserName' and videoId = '$vidId'");
    $checkquery->execute();
    if ($checkquery->rowCount() > 0) {
        $query = $con->prepare("DELETE FROM favorites WHERE userName='$loggedInUserName' and videoId = '$vidId'");
        $query->execute();
        header("location:player.php?Id=$vidId&delete=success");
    } else {
        echo '<script>alert(Video is already not in favorites)</script>';
    }
?>