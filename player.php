<?php
    require_once("Configuration.php");
    require_once("main.php");
    require_once("MediaPlayer.php");
    require_once("MediaInfoSection.php");
    require_once("CommentsClass.php");

    $commentsClass= new CommentsClass($con);
    if(!isset($_GET["Id"]) && !isset($_POST["postComment"])){
        echo '<script>alert(Video could not be played due to internal issues! Please try again.)</script>';
        exit();
    }

    $mediaId="";
    if(isset($_GET["Id"])){
        $mediaId = $_GET["Id"];
    }
    if(isset($_POST["postComment"])){
        $mediaId = $_POST["postComment"];
    }

    $media= new Media($con,$mediaId);
    $media->incrementViews();
    
    $query = $con->prepare("SELECT description FROM media where id = '$mediaId'");
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $desc = $row['description'];

    $query = $con->prepare("SELECT uploadedBy FROM media where id = '$mediaId'");
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $mediaOwner = $row['uploadedBy'];

?>

<div class="PageDiv"> 
    <div class="watchLeftColumn">
    <?php
        $mediaPlayer= new MediaPlayer($media);
        echo $mediaPlayer->create();
    ?>
    </div>
    <div class= "suggestions">
        <div style="margin-bottom:8px;margin-top:8px;">
            Recommendations:
        </div>
        <?php
            $gridClass= new GridClass($con);
            echo $gridClass->create('Recommendation', "", "","", $loggedInUserName, "", $mediaId);
        ?>

    </div>
</div>

<div>
    <?php
    $mediaPlayer= new MediaInfoSection($con,$media,$loggedInUserName,$mediaId,$mediaOwner);
    echo $mediaPlayer->create();
            
    if (!empty($desc)) {
        echo "<div class='videodesc' style='margin-top:20px;margin-right:425px;'>
        <h5 style='color:black'>Description</h5>
        <span>$desc</span>
        </div>";
    }

?> 
</div>


<?php
    echo "<div style='border-top:1px solid #ccc;margin-right:425px; padding-top:20px;' ><h5>Comments</h5></div>";
    if(isset($_GET["Id"])){
        $result=$commentsClass->getAllCommentsOfMedia($mediaId);
        if($result==""){
            echo "No Comments";
        }
        else{
            echo $result;
        }

    }

    if(isset($_POST["postComment"])){
        $commentsClass->postComment($loggedInUserName,$mediaId,$_POST['comment']);
        $result=$commentsClass->getAllCommentsOfMedia($mediaId);
        echo $result;
        header("location:player.php?Id=$mediaId");
    }


?>
<?php    

if($loggedInUserName!=""){
    echo "<div class='commentSection' style='margin-right:425px;'>
               <form action='player.php' method='POST' style='padding-top:20px' >
                <div class='input-group'>
                    <input type='text' id='comment' name='comment' required placeholder='Comment something here.. dont be harsh' class='form-control' >
                    <div class='input-group-append'>
                        <button class='btn btn-secondary' type='submit' value='$mediaId' name='postComment'>Post</button>
                    </div>
                </div>
            </form>
        </div>";
}

?>
    
