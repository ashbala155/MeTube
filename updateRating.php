<?php
require_once("main.php");
    	$mediaId = $_GET["mediaId"];
    	echo $mediaId;
		echo '<script>alert("Welcome to Geeks for Geeks")</script>';
		$ratecheck =  $con->prepare("SELECT * from ratings where userName='$loggedInUserName' and videoId = '$mediaId'");
		$ratecheck->execute();
		$rateme = $_GET['rate'];
   		if ($ratecheck->rowCount() != 0){
   			$updaterating = $con->prepare("UPDATE ratings set ratedIndex='$rateme' where userName = '$loggedInUserName' and videoId = '$mediaId'");
   			$updaterating->execute();
   		}
   		else{
   			$updaterating = $con->prepare("INSERT INTO ratings(userName, videoId, ratedIndex) values ('$loggedInUserName', '$mediaId','$rateme')");
   			$updaterating->execute();
   		}

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
