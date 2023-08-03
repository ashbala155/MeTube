<?php require_once("main.php") ?>
<?php
    if(!isset($_GET["page"])){
        //$keywords = $_GET["term"];
        header("location:search.php?page=Search&keywords=".$_GET["keywords"]);
    }
    $mediaTitle = "Search results for '".$_GET["keywords"]."'";
    if(isset($_GET["size"])){
        $size = $_GET["size"];
    } else {
        $size = "";
    }
    
    $searchtext = $_GET["keywords"];
    $key_query = $con->prepare("SELECT * FROM wordcloud WHERE word = '$searchtext'");
    $key_query->execute();

    if($key_query->rowCount()==0){
        $insert_new_query = $con->prepare("INSERT INTO wordcloud(word, search_count) VALUES('$searchtext', 1)");
        $insert_new_query->execute();
    }else{
        while($row=$key_query->fetch(PDO::FETCH_ASSOC)){
            $count = $row['search_count'];
            $count++;
            $update_query = $con->prepare("UPDATE wordcloud SET search_count = $count where word = '$searchtext'");
            $update_query->execute();
        }
    }

?>


<div>
    <div style="display:flex; font-size: 20px; justify-content: center">
        <span style="display:flex;">Refined Search by size <?php echo $size.":" ?> &nbsp; &nbsp; &nbsp;</span>
        <div>
            <a class="btn btn-turquoise" href='search.php?page=Search&keywords=<?php echo $_GET["keywords"]?>'>All size</a>
            <a class="btn btn-turquoise" href='search.php?page=Search&keywords=<?php echo $_GET["keywords"]?>&size=0-100K'>0-100K</a>
            <a class="btn btn-turquoise" href='search.php?page=Search&keywords=<?php echo $_GET["keywords"]?>&size=100K-1000K'>100K-1000K</a>
            <a class="btn btn-turquoise" href='search.php?page=Search&keywords=<?php echo $_GET["keywords"]?>&size=>1000K'>>1000K </a>
        </div>
    </div>
</div>


<?php require_once("MediaOrder.php") ?>
