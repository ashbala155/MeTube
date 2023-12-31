<?php
class Media{
    private $con;
    private $userData;
    public function __construct($con,$input){
        $this->con = $con;
        if(is_array($input)){
            $this->userData=$input;
        }
        else{
            $query = $this->con->prepare("SELECT * FROM media where id = '$input'");
            $query->execute();

            $this->userData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId(){
        return $this->userData["id"];
    }
    
    public function getUploadedBy(){
        return $this->userData["uploadedBy"];
    }

    public function getTitle(){
        return $this->userData["title"];
    }

    public function getDescription(){
        return $this->userData["description"];
    }

    public function getVisibility(){
        return $this->userData["visibility"];
    }

    public function getKeywords(){
        return $this->userData["keywords"];
    }

    public function getFilepath(){
        return $this->userData["filepath"];
    }

    public function getThumbnailpath(){
        return $this->userData["thumbnail"];
    }

    public function getSize(){
        return $this->userData["mediaSize"];
    }

    public function getCategory(){
        return $this->userData["category"];
    }

    public function getUploadDate(){   
        return $this->userData["uploadDate"];
    }
    public function getViews(){
        return $this->userData["views"];
    }

    public function getDuration(){
        return $this->userData["duration"];
    }

    public function incrementViews(){
        $videoId=$this->getId();
        $uploaddate=$this->getUploadDate();
        $query= $this->con->prepare("UPDATE media SET views = views+1, uploadDate='$uploaddate' WHERE id = '$videoId'");
        $query->execute();
        $this->userData["views"] = $this->userData["views"] + 1;
    }  

    public function getMediasize(){
        return round($this->userData["mediaSize"]/1024, 2). "kb";
    }  

}
?>