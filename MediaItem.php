<?php
class MediaItem{
    private $media;
    public function __construct($media){
        $this->media= $media;
    }

    public function create(){
        $thumbnail_path = $this->media->getThumbnailpath();
        $thumbnail="<div class='thumbnail'>
                    <img src='$thumbnail_path'></div>";
        $details= $this->createDetails();
        $url= "player.php?Id=" . $this->media->getId();
        
        return "<a href='$url'>
                    <div class='videoGridItem'>
                   $thumbnail 
                    $details
                    </div>
                </a>";
    }
    private function createDetails(){
        $title = $this->media->getTitle();
        $userName = $this->media->getUploadedBy();
        $views = $this->media->getViews();
        $uploaddate = $this->media->getUploadDate();
        $size = $this->media->getMediasize();
        return "<div class='details'>
                    <h3 class='title'>$title</h3>
                    <span class='username'>Uploaded by: $userName</span>
                    <div class='stats'>
                        <span class='viewCount'>$views Views </span>
                        <span class='bullet'>&#8226;</span>
                        <span><time class='timeago' datetime='$uploaddate'></time></span>
                        </div>
                </div>";

    }
} 
?>