<?php
require_once("Configuration.php");
require_once("UserDetails.php");
require_once("Media.php");
require_once("GridClass.php");
require_once("MediaItem.php");

$loggedInUserName = "";

if (isset($_SESSION["loggedinUser"])) {
    $loggedInUserName = $_SESSION["loggedinUser"];
}
if(isset($_GET["category"])){
    $category = $_GET["category"];
} else {
    $category = "All";
}
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
?>
<div >
        <div class="sortbyTabs" style="float:right; margin-top:20px;"> 
            <div>
                <p style="font-size: 20px;margin-top:10px;">Sort Media by : &nbsp;&nbsp;</p>
            </div>    
            <div class="sortby">
                <button class="tablinks" onclick="openTab(event, 'Name')" id='defaultOpen'>Name</button>
                <button class="tablinks" onclick="openTab(event, 'Views')">Views</button>
                <button class="tablinks" onclick="openTab(event, 'Upload Time')">Upload Time</button>
                <button class="tablinks" onclick="openTab(event, 'Size')">Size</button>
            </div>
        </div>
        
    <!-- <?php if($page == "MyChannel") echo "
    <div style='margin-top:0px; font-size: 20px;'>
    <p class='my__name' style='text-align: left; font-size: 30px;''>$loggedInUserName</p>
    </div>
    " ?> -->

    <?php if ($page == "MyChannel") { 
        echo " <div style='margin-top:0px; font-size: 20px;'>
            <p class='my__name' style='text-align: left; font-size: 30px;''>$loggedInUserName</p>
        </div> " ?>
    <?php } else if ($page == "Home" && $category != "All") { 
        echo " <div style='margin-top:0px; font-size: 20px'>
            <p class='category_name' style='text-align: left; font-size: 30px;'>Showing results for $category</p>
        </div>"
    ?><?php }?>

</div>

<div class="tab-content">
    <div class="tabcontent" id="Name">
        <?php
        $sortby = "title";
        require("MediaContent.php");
        ?>
    </div>
    <div class="tabcontent" id="Views" >
        <?php
        $sortby = "views";
        require("MediaContent.php");
        ?>
    </div>
    <div class="tabcontent" id="Upload Time" role="tabpanel" aria-labelledby="pills-Upload-tab">
        <?php
        $sortby = "uploadDate";
        require("MediaContent.php");
        ?>
    </div>
    <div class="tabcontent" id="Size" role="tabpanel" aria-labelledby="pills-Size-tab">
        <?php
        $sortby = "mediaSize";
        require("MediaContent.php");
        ?>
    </div>
</div>

<script>
function openTab(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>

