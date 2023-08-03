<?php
require_once("Media.php");

class MediaInfoSection{
    private $con,$media,$loggedInUserName,$mediaId,$mediaOwner;
    public function __construct($con,$media,$userLoggedInObj,$mediaId,$mediaOwner){
        $this->media= $media;
        $this->con= $con;
        $this->loggedInUserName= $userLoggedInObj;
        $this->mediaId= $mediaId;
        $this->mediaOwner= $mediaOwner;
    }


    public function create(){
    
        $title= $this->media->getTitle();
        $uploadTime = $this->media->getUploadDate();
        $keywords = $this->media->getKeywords();
        $views= $this->media->getViews(); 

        $html = "<div class='videoInfo'>

            <span class='keywords' style='color:blue;'>#$keywords</span>
            <h1>$title</h1>
            <div class='BottomSection'>
                <div class='BottomSection-left'>
                    <div class='stats'>
                        <span class='viewCount'>$views Views </span>
                        <span class='bullet viewCount'>&#8226;</span>
                        <span><time class='timeago viewCount' datetime='$uploadTime'></time></span>
                    </div>
                </div>      
           ";
    
        if($this->loggedInUserName != ""){
                $html.= "<div class='rating push-right'>";
                $checkquery = $this->con->prepare("SELECT * from ratings where videoId = '$this->mediaId'");
                $checkquery -> execute();
            
                if ($checkquery->rowCount() == 0) {
                    $html.= "<label>Ratings: 0 (0)  &nbsp;</label>";
                }
                else{
                   $ratingquery = $this->con->prepare("SELECT ROUND(AVG(ratedIndex),1) as average FROM ratings where videoId='$this->mediaId'");
                    $ratingquery->execute();
                    while($row = $ratingquery->fetch(PDO::FETCH_ASSOC)){
                        $avg = $row['average'];
                        $totalRatings = $checkquery->rowCount();
                        $html.= "<span>Ratings: $avg ($totalRatings)  &nbsp;</span>";
                    }
                }


                $html.= "
                    <form  action='updateRating.php' method='POST' >
                        <a href='updateRating.php?rate=1&mediaId=" . $this->mediaId . "' class='fa fa-star'></a>
                        <a href='updateRating.php?rate=2&mediaId=" . $this->mediaId . "' class='fa fa-star'></a>
                        <a href='updateRating.php?rate=3&mediaId=" . $this->mediaId . "' class='fa fa-star'></a>
                        <a href='updateRating.php?rate=4&mediaId=" . $this->mediaId . "' class='fa fa-star'></a>
                        <a href='updateRating.php?rate=5&mediaId=" . $this->mediaId . "' class='fa fa-star'></a>
                    </form>
                </div>
                ";


            $html.= "<form action='addtoplaylist.php' method='POST' >";
   
            $query = $this->con->prepare("SELECT * FROM playlist where userName = '$this->loggedInUserName'");
            $query->execute();

            if ($query->rowCount()==0){
                //Create new playlist
                $playlistnamein = 'My Playlist';
                $query = $this->con->prepare("INSERT INTO playlist (name, userName) VALUES ('$playlistnamein', '$this->loggedInUserName')");
                $query->execute();
                header("location:player.php?Id=$this->mediaId");
            }

            $html.= "<div style='margin-left:12px;width:24px;' class='playlist_dropdown'>
            <img style='width:24px;' src='https://static.thenounproject.com/png/568648-200.png' />
            <div class='dropdown-content'>";

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $html.= "<a href='AddToPlaylist.php?playlistname=" . $row['name'] . "&videoId=" . $this->mediaId . "'>" . $row['name'] . "</a>";                }
             
           $html.=   "</div>
            </div>
            </form>
            <div>
            ";
    
            $checkquery = $this->con->prepare("SELECT * from favorites where userName='$this->loggedInUserName' and videoId = '$this->mediaId'");
            $checkquery->execute();

            if ($checkquery->rowCount() == 0) {
                $html.= "<form action='AddMediaToFavorites.php' method='GET' >
                            <div class='fav-button-tooltip'>
                                <button class='fav-button' type='submit' value='$this->mediaId' name='Id'> 
                                    <img style='width:24px;' src='https://cdn-icons-png.flaticon.com/512/535/535234.png' />   
                                </button>
                                <span class='tooltiptext'>Add to favorite</span>
                            </div>
                      </form>";
            }
            else {
                $html.= "<form action='removeFromFavorite.php' method='GET' >
                <div class='fav-button-tooltip'>      
                <button class='fav-button' type='submit' value='$this->mediaId' name='Id'>  <img style='width:24px;' src='https://cdn-icons-png.flaticon.com/512/2107/2107845.png' /></button>
                <span class='tooltiptext'>Remove from favorite</span>
                </div>   
                </form>   
                      ";
    
            }
    
            $html.= " </div>";

            $html.=  "<form action='download.php' method='POST' >
            <div class='fav-button-tooltip'>      
            <button class='fav-button' type='submit' value='$this->mediaId' name='downloadButton'> <img style='width:24px;' src='assets/download.png' /></button>
            <span class='tooltiptext'>Download this media</span>
            </div>  
            </form>";
            
    
            if ($this->mediaOwner == $this->loggedInUserName) {
                $html.= "<form action='updateVideoInfo.php' method='GET' >
                        <div class='fav-button-tooltip'>      
                        <button class='fav-button' type='submit' value='$this->mediaId' name='Id'> <img style='width:24px;' src='https://cdn-icons-png.flaticon.com/512/1160/1160515.png' /></button>
                        <span class='tooltiptext'>Edit this media</span>
                        </div>  
                  </form>";
            }

            
        }
        $html.= " </div>";
        return $html;
    }
}
?>
