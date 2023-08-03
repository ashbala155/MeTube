<?php
require_once("Configuration.php");
require_once("UserDetails.php");
require_once("Media.php");
require_once("GridClass.php");
require_once("MediaItem.php");

$loggedInUserName = "";
$page = "";
$category = "";
$sortby = "";
$keywords = "";
$mediaTitle = "";

if (isset($_SESSION["loggedinUser"])) {
    $loggedInUserName = $_SESSION["loggedinUser"];
}
$loggedInUser = new UserDetails($con, $loggedInUserName);
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MeTube</title>
    <link rel="icon" type="image/x-icon" href="/assets/youtube.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/jsfile.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    
    <button class="btn hamburger_menu">
        <img src="assets/menu-2.png">
    </button>

    <a class="navbar-brand" href="index.php?page=Home"><i class="fab fa-youtube fa-lg" style="color:Turquoise;"></i> Metube</a>

    <div class="collapse navbar-collapse" id="navbar-collapse-content">

        <form class="form-inline my-2 my-lg-0 mr-auto search-bar" action="search.php" method="GET">
            <input class="form-control mr-sm-2 search" list="datalist" onkeyup="ac(this.value)" type="search"
                   placeholder="Search" aria-label="Search" name="keywords">
            <button class="btn btn-dark my-2 my-sm-0" type="submit"><i class="fab fa-searchengin"></i></button>
        </form>

        <?php
        if ($loggedInUserName != "") {
            echo "
                <a class='btn-upload' href='upload.php'>Upload</i></a>
                <div class='dropdown'>
                <a class='user__name' style='color:white;'>" . $loggedInUser->getuserName() . " </a>
                   <div class='dropdown-content'>
                     <a href='mychannel.php'>My channel</a>
                     <a href='updateProfile.php'>Update Profile</a>
                     <a href='logout.php'>Logout</a>
                   </div>
                </div>
            ";
        } else {
            echo "
                <a class='btn-login' href='login.php'>Log In <i class='fas fa-user'></i></a>
            ";
        }
        ?>
    </div>
</nav>

<div id="side-nav" class="text-light bg-dark" style="display:none;">
            <?php if ($page == "Home") { ?>
                 <div class="side-menu-section text-light bg-dark text-light"">
             <?php } else { ?>
                <div class="side-menu-section-last text-light bg-dark text-light">
            <?php } ?>
        <ul class="side-menu-option">
                <li>
                    <a href='index.php?page=Home'>Home</a>
                </li>
                <li>
                    <a href='wordCloud.php'>Word Cloud</a>
                </li>
            <?php
            if ($loggedInUserName != "") {
                echo "
                    <li>
                        <a href='contact.php'>Contacts</a>
                    </li> 
                    <li>
                        <a href='message.php'>Messages</a>
                    </li>
                    <li>
                      <a href='playlist.php?id='>Playlists</a>
                    </li>
                    <li>
                      <a href='favorites.php'>Favorites</a>
                    </li>
                    ";
            }
            ?>
             </ul>   
    </div>

    <div class="side-menu-section-last text-light bg-dark text-light">
        <ul class="side-menu-option">
                <?php if($page == "Home") echo"
                <h5 style='color:grey;'>Categories</h5>
                 <li>
                 <a href='index.php?page=Home&category=Nature'>Nature</a>
                 </li> 
                 <li>
                 <a  href='index.php?page=Home&category=Animal'>Animal</a>
                 </li>
                 <li >
                 <a  href='index.php?page=Home&category=Celebration'>Celebration</a>
                 </li>
                 <li >
                 <a  href='index.php?page=Home&category=Plants'>Plants</a>
                 </li>
                 <li >
                 <a  href='index.php?page=Home&category=Other'>Other</a>
                 </li>" ?>
        </ul>
    </div>
</div>


<div id="main-section">
    <div id="content" class="container-fluid">
