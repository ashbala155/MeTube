<?php
require_once("Configuration.php");
require_once("main.php");

$query = $con->prepare("SELECT * FROM wordcloud");
$query->execute();

function randomHexColor()
{
    return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
}

echo "<div style = 'font-size: 30px; text-align: center;'> 
           Search Cloud:
      </div>";
echo "<div style='align-items:center;text-align:center;margin-top:100px;'>";
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $keyword = $row['word'];
    $count = $row['search_count'] + 20;
    if ($count > 100) {
        $count = 100;
    }
    $randomColor = randomHexColor();
    echo "<span style = 'font-size:".$count."px;color:".$randomColor."'>".$keyword."&nbsp;&nbsp;&nbsp;&nbsp;</span>";
}
echo "</div>";
?>