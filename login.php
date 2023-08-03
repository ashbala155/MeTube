<?php 
require_once("Configuration.php");
require_once("UserAccount.php");
require_once("StatusMessage.php");

$userAccount =new UserAccount($con);
if(isset($_POST["loginButton"])){
    $userName=trim($_POST["username"]);
    $password=$_POST["password"];
    $resultKey=$userAccount->login($userName,$password);
    if($resultKey){
        echo "Success";
        $_SESSION["loggedinUser"] = $userName;
        header("location:mychannel.php");
    }
    else{
        echo "<script type='text/javascript'>alert('Login Failed! Please try again.');</script>";
    }
}

if(isset($_POST["signupButton"])){
    $email = trim($_POST["email"]);
    $userName = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];

    $resultKey=$userAccount->register($email,$password,$confirmPassword,$userName);

    if($resultKey){
        echo "Success";
        header("location:index.php");
    }
    else{
        echo "<script type='text/javascript'>alert('Signup Failed! Please try again.');</script>";
    }
}

?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/loginstyle.css">
    </head>

    <body>    

    <div id="log" class="log-content">
    <div class="log" >
        <transition name="slide-fade">
            <div v-if="log" class="login">
                <form action="login.php" method="POST">
                    <div class="title">Login</div>
                    <br>
                    <label for="username" >Username</label>
                    <input type="text" name="username" placeholder="pewdiepie">
                    <label for="password">Password</label>
                    <div>
                        <input type="password" name="password" placeholder="****************" required>
                        <?php echo $userAccount->displayError(StatusMessage::$loginFailed); ?>
                    </div>
                    <button class="btn" name="loginButton" type="submit">Sign In</button>
                    <span>Don't have an account? <button @click="log = !log">&nbsp;Sign Up</button></span>
                    <transition name="error">
                        <div v-if="error" class="error">Error code </div>
                    </transition>
                </form>
            </div>
        </transition>

        <transition name="slide-fade">
            <div v-if="!log" class="register">
                <form action="login.php" method="POST">
                    <div class="title">Register</div>
                    <br>
                    <label for="username">Username</label>

                    <div>
	                <input type="text" name="username" placeholder="Enter username" required>
	                <?php echo $userAccount->displayError(StatusMessage::$userNameUniqueError); ?>
	                </div>

                    <label for="password">Email</label>

                    <div>
	                <input type="text" name = "email" placeholder="example@email.com" required>
	                <?php echo $userAccount->displayError(StatusMessage::$emailInvalidError); ?>
	                <?php echo $userAccount->displayError(StatusMessage::$emailUniqueError); ?>
	                </div>

                    <label for="password">Password</label>
                    <input type="password" name = "password" placeholder="****************" required>
                 
                    <label for="password">Confirm Password</label>

                    <div >
	                <input type="password" name = "confirmpassword" placeholder="****************" required>
	                <?php echo $userAccount->displayError(StatusMessage::$passwordMatchError); ?>
	                <?php echo $userAccount->displayError(StatusMessage::$passwordLengthError); ?>
	            </div>

                    <button class="btn" @click="error = !error" name ="signupButton" type="submit">Sign Up</button>
                    <span>Do you already have an account ?<button @click="log = !log">&nbsp;Sign In</button></span>
                    <transition name="error">
                        <div v-if="error" class="error"><span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></span>Error code </div>
                    </transition>
                </form>
            </div>
        </transition>

    </div>
    <div class="animation">
        <div class="title">Welcome to MeTube ;)</div>
        <lottie-player class="lt" src="https://assets7.lottiefiles.com/private_files/lf30_cwyafad8.json" background="transparent" speed="1" loop autoplay></lottie-player>
    </div>
</div>
<script src='https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js'></script>
<script  src="js/script.js"></script>
    
</body>
</html>