<?php 
require_once("main.php"); 
require_once("ContactClass.php");
require_once("StatusMessage.php");
?>

<div style='padding-top:40px;'>
<div>
<br>    <br>


    <h3 class="text-dark display-4 text-center">Manage your contacts here</h3>
    <br>
    <br>    <br>

    <?php
    
    $contactClass = new ContactClass($con);
    $result= $contactClass->getAllUserstoFriend($loggedInUserName);
    if($result!="")
    {
        echo $result;
    }
    else{
        echo "<h5 class='text-primary display-5 text-center'>";
        echo StatusMessage::$NoContacts;
        "</h5>";
    }
                
    ?>

	<?php
		if(isset($_POST["friendsButton"])){
			$relation = $_POST['relation'];
			$person = $_POST['person'];
    		$resultKey = $contactClass->makefriends($loggedInUserName,$person, $relation);
    	}
        else if(isset($_POST["blockButton"])){
        	$relation = $_POST['block'];
			$person = $_POST['person'];
            $resultKey = $contactClass->blockfriends($loggedInUserName, $person, $relation);
        }
   	?>

</div>
</div>