<?php 
    require_once("main.php");
   
    if(isset($_GET["playlistname"])){
        $playlistname = $_GET["playlistname"];
    }

    if(isset($_GET["videoId"])){
        $vidId = $_GET["videoId"];
    }

    header("Refresh: 1;URL=player.php?Id=$vidId");
    $checkquery = $con->prepare("SELECT * from playlist inner join playlist_details on name = playlistName where userName = '$loggedInUserName' and videoId = '$vidId'");
    $checkquery->execute();

    if($checkquery->rowCount() == 0){
    	$query = $con->prepare("INSERT INTO playlist_details(playlistName, videoId) values ('$playlistname', '$vidId')");
    	$query->execute(); 
        echo "<script type='text/javascript'>alert('Video added to playlist $playlistname');</script>";
    }
    else{
    	echo "<script type='text/javascript'>alert('Video already exists in playlist');</script>";
    }

?>
