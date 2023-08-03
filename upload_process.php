<?php
require_once("Configuration.php");
require_once("main.php");


$filename = $_FILES["mediaFile"]["name"];
$thumbnail = $_FILES["thumbnail"]["name"];

$title = $_POST["title"];
$description = $_POST['description'];
$category = $_POST['category'];
$visibility = $_POST['visibility'];
$keywords = $_POST['keywords'];
$keywords = rtrim($keywords, ',');
$keyword_arr = explode(',', $keywords);

$videoExts = array("video/mp4");
$imageExts = array("image/pjpeg", "image/gif", "image/jpeg");
$audioExts = array("audio/mp3", "audio/wma");
$mediaId = 0;
//$extension = pathinfo($_FILES['mediaFile']['name'], PATHINFO_EXTENSION);
$extension = $_FILES["mediaFile"]["type"];
$t_extension = $_FILES["thumbnail"]["type"];
$mediaType = explode('/', $extension);
$mediaType = $mediaType[0];
$t_mediaType = explode('/', $t_extension);
$t_mediaType = $t_mediaType[0];
$size = $_FILES['mediaFile']['size'];
$t_size = $_FILES['thumbnail']['size'];

$username = $_SESSION["loggedinUser"];
$file_path = 'uploads/'.$username.'/';

//if user upload folder does not exist, create the folder
if (!file_exists($file_path)) {
    mkdir($file_path);
    chmod($file_path, 0755);
}

if($_FILES["mediaFile"]["error"] > 0 ) {
    echo "<h1> error:".$_FILES["mediaFile"]["error"] ."</h1>";
    header("Refresh: 2;URL=upload.php?");
    exit;
}


if($_FILES["thumbnail"]["error"] > 0 ) {
    echo "<h1> error:".$_FILES["thumbnail"]["error"] ."</h1>";
    header("Refresh: 2;URL=upload.php?");
    exit;
}

$upload_file = $file_path.$filename; //urlencode work on GET, POST can contain special characters
$t_upload_file = $file_path.$thumbnail; //urlencode work on GET, POST can contain special characters

if(file_exists($upload_file))
{
    echo "<script type='text/javascript'>alert('File".$upload_file." already exists');</script>";
    header("location:upload.php?file_exist=true");
    exit;
}

try{
    move_uploaded_file($_FILES["mediaFile"]["tmp_name"], $upload_file);
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $t_upload_file);

    chmod($upload_file, 0644);
    chmod($t_upload_file, 0644);

    $query = $con->prepare("INSERT INTO media(mediaType, title, description, category, visibility, filepath, fileExtension,thumbnail ,mediaSize, uploadedBy, views, keywords) 
                    VALUES('$mediaType', '$title', '$description','$category','$visibility', '$upload_file', '$extension','$t_upload_file' ,'$size','$username', 0, '$keywords')");
    $query->execute();
    //get the media id just added to database
    $query = $con->prepare("SELECT id FROM media order by id desc limit 1");
    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);
    $mediaId = $row['id'];

    if ($keywords != "") {
        for ($i = 0; $i < count($keyword_arr); $i++) {
            $key = $keyword_arr[$i];
            //echo "$key"."<br>";
            $query = $con->prepare("INSERT INTO keywords(keyword, videoId) VALUES('$key', '$mediaId')");
            $query->execute();
        }
    }
    header("Refresh: 2;URL=player.php?Id=$mediaId");
}
catch(Exception $e){
    echo"Some Error Occured: ".$e->getMessage();
    header("Refresh: 2;URL=upload.php?");
}

?>