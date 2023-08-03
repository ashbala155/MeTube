<?php require_once("main.php") ?>
<?php require_once("CategoryBar.php") ?>
<?php require_once("MediaContent.php") ?>
<?php
    if (!isset($_GET['page'])) {
        header("location:index.php?page=Home");
    }
    ?>
    