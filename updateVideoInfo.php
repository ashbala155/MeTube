<?php
require_once("Configuration.php");
require_once("main.php");

$vedioId = (int)$_GET['Id'];
$query = $con->prepare("SELECT * FROM media where id = '$vedioId'");
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$title = $row["title"];

$description = $row['description'];
$category = $row['category'];
$visibility = $row['visibility'];
$categoryMap = array("Nature" => 0, "Animal" => 1 ,"Celebration" => 2,"Plants" => 3, "Other" => 4);
$categoryIndex = $categoryMap[$category];
$categorySelect = array(false, false, false, false);
$categorySelect[$categoryIndex] = true;

$visibilityMap = array("Public" => 0, "Friend" => 1, "Family" => 2, "Fav" => 3);
$visibilityIndex = $visibilityMap[$visibility];
$visibilitySelect = array(false, false, false, false);
$visibilitySelect[$visibilityIndex] = true;

$query = $con->prepare("SELECT keywords FROM media where id = '$vedioId'");
$query->execute();

$keywords = "";
$row = $query->fetch(PDO::FETCH_ASSOC);
$keywords.=$row["keywords"];

$actionString = "updateVideoProcess.php?Id=".$vedioId;
//echo "$actionString";
?>

<form action=<?php echo "$actionString" ?> method="POST" enctype="multipart/form-data">

    <h2 style="color: green">Please edit video info:</h2>


    <div class="form-group">
    <label for="title">Title* <span>Use title case to get a better result</span></label>
    <textarea type="text" name="title" id="title" rows = "1"  maxlength="50" class="form-controll" placeholder="Enter media title" required><?php echo $title ?></textarea>
    </div>

    <div class="form-group">
    <label for="tags">Tags <span>(separted by comma ',')</span></label>
    <textarea type="text" name="keywords" id="keywords" class="form-controll" placeholder="Enter Tags here"><?php echo $keywords ?></textarea>
    </div>

    <div class="form-group" >
    <label for="description">Description <span>maximum 200 characters</span></label>
    <textarea style="min-height:80px;"  type="text" name="description" id="floatingTextarea" class="form-controll" placeholder="Enter media description"><?php echo $description ?></textarea>
    </div>


    <div class="rb_demo-container">
        <label class="form-label" for="category">
            Select a category:
        </label>
        <div class="rb_container">
             <div  class="radio_container" id = 'category'>
                <input type="radio" class="form-check-input" name="category" id="Nature" value="Nature" <?php if ($categorySelect[0]) echo "checked"?>>
                <label class="form-check-label" for="Nature">
                Nature
                </label>

                <input type="radio" class="form-check-input" name="category" id="Animal" value="Animal" <?php if ($categorySelect[1]) echo "checked"?>>
                <label class="form-check-label" for="Animal">
                    Animal
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Celebration" value="Celebration" <?php if ($categorySelect[2]) echo "checked"?>>
                <label class="form-check-label" for="Celebration">
                Celebration
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Plants" value="Plants" <?php if ($categorySelect[3]) echo "checked"?>>
                <label class="form-check-label" for="Plants">
                Plants
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Other" value="Other" <?php if ($categorySelect[4]) echo "checked"?>>
                <label class="form-check-label" for="Other">
                    Other
                </label>
        
             </div> 
        </div>
    </div> 

    <br>

    <div class="rb_demo-container">
        <label class="label" for="visibility">
            Visibility:
        </label>
        <div class="rb_container">
            <div class="radio_container" id = 'visibility'>
                    <input type="radio" name="visibility" id="Public" value="Public" <?php if ($visibilitySelect[0]) echo "checked"?>>
                    <label  for="Public">
                        Public
                    </label>
                    <input type="radio" name="visibility" id="Friend" value="Friend" <?php if ($visibilitySelect[1]) echo "checked"?>>
                    <label  for="Friend">
                        Friend
                    </label>
                    <input type="radio" name="visibility" id="Family" value="Family" <?php if ($visibilitySelect[2]) echo "checked"?>>
                    <label  for="Family">
                        Family
                    </label>
        
                    <input type="radio"  name="visibility" id="Fav" value="Fav" <?php if ($visibilitySelect[3]) echo "checked"?>>
                    <label for="Fav">Fav</label>
            </div>
        </div>
    </div>

  
    <div class="submit_flex">
        <button class="upload_button" value="upload" name="upload" type="submit" />Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button class="cancel_button" onclick="location.href='index.php?page=Home';" type="button" >Cancel</button>
	</div>

</form>
