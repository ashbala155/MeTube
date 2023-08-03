<?php
require_once("main.php");

$query = $con->prepare("SELECT * from playlist where userName = '$loggedInUserName'");
$query->execute();
$html = "";

$html .= "
<div>
<h3> My Playlists </h3>
<br>
<div class='new-playlist-item'>
            <div ><h4 >Create A New Playlist</h4></div>
            <div >   
            <form style='display:flex;' action='playlist.php' method='POST'>
                    <input type='text' name ='playlistNamein' placeholder='Enter Name' required>
                    <button style='margin-left:16px;' type='submit' class='btn-login' name='createPlaylist' value='$loggedInUserName'>Create</button>
            </form>
            </div>
    </div>
    <br>
<div class='playlist-item'> 
";

if($query->rowCount()== 0){
    echo "";
}
else{   
    while($row= $query->fetch(PDO::FETCH_ASSOC)){
        $playlistname = $row['name'];
        $html.= "
                <div class='grid-item'>
                    <form action='playlist.php' method='POST'> 
                        <textarea class = 'override-textarea' readonly=readonly value='" . $row['name'] . "' name='playlistname'>" . $row['name'] . "</textarea>
                        <button type='submit' class='btn btn-primary' name='viewplaylistButton' value='name'>View Playlist</button>
                        <button type='submit' class='btn btn-secondary' name='deleteplaylistButton' value='name'>Delete Playlist</button>
                    </form>
                </div>
        ";
    }
}
$html.="
</div>
</div>";
echo $html;

if(isset($_POST["createPlaylist"])){
    $playlistnamein = $_POST['playlistNamein'];
    $query = $con->prepare("INSERT INTO playlist (name, userName) VALUES ('$playlistnamein', '$loggedInUserName')");
    $query->execute();
    echo $playlistnamein ." has been added. Please refresh the page.";
    header("location:playlist.php");
}

if(isset($_POST["deleteplaylistButton"])){
    $deleteplaylist = $_POST['playlistname'];
    $query = $con->prepare("DELETE FROM playlist where userName='$loggedInUserName' and name='$deleteplaylist'");
    $query->execute();
    echo $deleteplaylist ." has been deleted. Please refresh the page.";
    header("location:playlist.php");
}

if(isset($_POST["viewplaylistButton"])){
    $playlistname = $_POST['playlistname'];
    $query = $con->prepare("SELECT media.*
    FROM media
    JOIN playlist_details ON media.id = playlist_details.videoId
    JOIN playlist ON playlist.name = playlist_details.playlistName
    WHERE playlistName = '$playlistname' AND userName='$loggedInUserName'");
    $query->execute();

    echo"
    <br>
    <br>
    <div>
    <h3 style='color:green; border-bottom:1px solid #e8e8e8; margin-bottom:12px;'>Playlist: $playlistname</h3>";
    $element = "";
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $media = new Media($con, $row);
        $item = new MediaItem($media);
        $element .= $item->create();
    }
    echo "<div class='videoGrid'> $element  </div>";

    echo "</div>";
}
?>