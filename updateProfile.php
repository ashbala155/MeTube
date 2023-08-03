<?php 
    require_once("main.php"); 
    require_once("Configuration.php");
    require_once("StatusMessage.php");
    require_once("UserAccount.php");

    $emailResult = false;
    $userAccount = new UserAccount($con);

    if(isset($_POST["UpdateEmail"])){
        $email=trim($_POST["email"]);
        $emailResult=$userAccount->updateEmail($email, $loggedInUserName);
    }
    else if(isset($_POST["UpdatePassword"])){
        $currentPassword=$_POST["currentpassword"];
        $newPassword=$_POST["newpassword"];
        $confirmNewPassword=$_POST["confirmnewpassword"];
        $result=$userAccount->updatePassword($currentPassword,$newPassword,$confirmNewPassword,$loggedInUserName);
    }
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
    <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>    

        <div class="log-content" style="background-color: bg-dark;">
              <div class="title"  >Update your profile</div>
              <div class="log">
                <form action="updateProfile.php" method="POST">
                        <div >
                            <input type="text" name="email" placeholder="Enter your new email">
                            <?php  echo $userAccount->displayError(StatusMessage::$emailInvalidError); ?>
                            <?php echo $userAccount->displayError(StatusMessage::$emailUniqueError); ?>
                        </div>
                        <button class="btn" type="submit" name="UpdateEmail">Update Email</button>
                        <br>
                        <input type="password" name ="currentpassword" placeholder="Enter old password">
                        <input type="password" name ="newpassword" placeholder="Enter new password">
                        <div >
                            <input type="password" name = "confirmnewpassword" placeholder="Confirm new password">
                            <?php echo $userAccount->displayError(StatusMessage::$passwordMatchError); ?>
                            <?php echo $userAccount->displayError(StatusMessage::$passwordLengthError); ?>
                        </div>
                        <button class="btn" type="submit" name="UpdatePassword">Update Password</button>
                        
                </form>
              </div>
        </div>
    </body>
</html>
