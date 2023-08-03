<?php
require_once("Configuration.php");
require_once("main.php");
$mediaId = (int)$_GET['Id'];
if (isset($_POST["cancel"])) {
    header("location:player.php?Id=$mediaId");
}

$title = $_POST["title"];
$description = $_POST['description'];
$category = $_POST['category'];
$visibility = $_POST['visibility'];
$keywords = $_POST['keywords'];
$keywords = rtrim($keywords, ',');
$keyword_arr = explode(',', $keywords);

try{

    $query = $con->prepare("UPDATE media
                                 SET title = '$title', description = '$description', category = '$category', visibility = '$visibility', keywords = '$keywords'
                                 WHERE id = '$mediaId'");
    $query->execute();
    //get the media id just added to database
    $query = $con->prepare("DELETE FROM keywords WHERE videoId = '$mediaId'");
    $query->execute();

    if ($keywords != "") {
        for ($i = 0; $i < count($keyword_arr); $i++) {
            $key = $keyword_arr[$i];
            //echo "$key"."<br>";
            $query = $con->prepare("INSERT INTO keywords(keyword, videoId) VALUES('$key', '$mediaId')");
            $query->execute();
        }
    }
}
catch(Exception $e){
    echo"Some Error Occured: ".$e->getMessage();
    header("location:player.php?Id=$mediaId");
}
header("Refresh: 2;URL=player.php?Id=$mediaId");
?>