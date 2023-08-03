<?php
require_once("Configuration.php");
require_once("main.php");
?>

<form action="upload_process.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <?php
            if(isset($_GET["file_exist"])) {
                echo '<script>alert(File exists! Please upload again)</script>';
            }
        ?>
        <h1 style="text-align: center;">Upload Media</h1>
    </div>


        <div class="form-group file-area" style="margin-top: 40px;">
                <label for="files">Files <span>Select a media file to upload</span></label>
            <input type="file" name="mediaFile" id="formFile" required="required"/>
            <div class="file-dummy">
            <div class="success">Great, your files are selected. Keep on.</div>
            <div class="default">Please drag or select media</div>
            </div>
        </div>


        <div class="form-group file-area" style="margin-top: 20px;">
                <label for="thumbnail">Thumbnail <span>Select a thumbnail to upload</span></label>
            <input type="file" name="thumbnail" id="thumbnailFile" required="required"/>
            <div class="file-dummy">
            <div class="success">Great, your files are selected. Keep on.</div>
            <div class="default">Please drag or select media</div>
            </div>
        </div>


    <div class="form-group">
    <label for="title">Title* <span>Use title case to get a better result</span></label>
    <input type="text" name="title" id="title" rows = "1"  maxlength="50" class="form-controll" placeholder="Enter media title"/>
    </div>

    <div class="form-group">
    <label for="tags">Tags <span>(separted by comma ',')</span></label>
    <input type="text" name="keywords" id="keywords" class="form-controll" placeholder="Enter Tags here"/>
    </div>

    <div class="form-group" >
    <label for="description">Description <span>maximum 200 characters</span></label>
    <textarea style="min-height:80px;"  type="text" name="description" id="floatingTextarea" class="form-controll" placeholder="Enter media description"></textarea>
    </div>



    <div class="rb_demo-container">
        <label class="form-label" for="category">
            Select a category:
        </label>
        <div class="rb_container">
             <div  class="radio_container" id = 'category'>
                <input type="radio" class="form-check-input" name="category" id="Animal" value="Animal">
                <label class="form-check-label" for="Animal">
                    Animal
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Nature" value="Nature">
                <label class="form-check-label" for="Nature">
                Nature
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Celebration" value="Celebration" >
                <label class="form-check-label" for="Celebration">
                Celebration
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Plants" value="Plants" >
                <label class="form-check-label" for="Plants">
                Plants
                </label>
        
                <input type="radio" class="form-check-input" name="category" id="Other" value="Other" checked>
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
                    <input type="radio" name="visibility" id="Public" value="Public" checked>
                    <label  for="Public">
                        Public
                    </label>
                    <input type="radio" name="visibility" id="Friend" value="Friend">
                    <label  for="Friend">
                        Friend
                    </label>
                    <input type="radio" name="visibility" id="Family" value="Family">
                    <label  for="Family">
                        Family
                    </label>
        
                    <input type="radio"  name="visibility" id="Fav" value="Fav">
                    <label for="Fav">Fav</label>
            </div>
        </div>
    </div>

    <div class="submit_flex">
        <button class="upload_button" value="upload" name="upload" type="submit" />Upload</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button class="cancel_button" onclick="location.href='index.php?page=Home';" type="button" >Cancel</button>
	</div>

</form>
