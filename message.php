<?php 

require_once("main.php"); 
require_once("messagingClass.php");

?>
<div style='padding-top:10px;'>
<div >
    <h3 class="text-dark display-4 text-center">Messages</h3>

    <?php
    
    $messagingClass = new MessagingClass($con);
    $result= $messagingClass->getAllUserstoMessage($loggedInUserName);
    if($result!="")
    {
        echo $result;
    }
    else{
        echo "<h5 class='text-primary display-5 text-center'>";
        echo StatusMessage::$NoContacts;
        "</h5>";
    }
    $resultKey = $messagingClass->viewMessage($loggedInUserName);
?>
<?php

	if(isset($_POST["messageButton"])){
        $recipient = $_POST['recipient'];
		$resultKey = $messagingClass->sendMessage($loggedInUserName, $recipient, $_POST["msg"]);
        header("Refresh:0; url=message.php");
    }
?>
	