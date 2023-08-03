<?php
class ContactClass{
	private $con;
    public function __construct($con){
        $this->con=$con;
    }

    public function getAllUserstoFriend($userName){
        try{
            $query = $this->con->prepare("select * from users where userName != '$userName'");
            $query->execute();
            if($query->rowCount()== 0){
                return "";
            }
            else{
                $html = "
                <div>
                <h3>All Contacts</h3>
                    <div class='contact-item'>";
                        while($row= $query->fetch(PDO::FETCH_ASSOC)){
                            $name = $row['userName'];
                            $html.= "
                            <form action='contact.php' method='POST'>
                            <div class='grid-item'>
                                <div class='name'>
                                    <textarea class='override-textarea' readonly=readonly style ='max-height:30px;' name='person'>$name</textarea>
                                </div>
                                <br>
                                <div class='manage'>
                                    <div style='margin:6px;'>
                                        <div style='float:left;' class='select'>
                                            <select name='relation'>
                                                <option value='Friend'>Friend</option>
                                                <option value='Family'>Family</option>
                                                <option value='Fav'>Favourite</option>
                                            </select>
                                        </div>
                                        <div style='margin-left:6px;float:right;'>
                                                <button type='submit' class='btn-primary' name='friendsButton' value='$userName'>Confirm</button>
                                        </div>
                                    </div>
                                    <div style='margin:6px;'>
                                        <div style='margin-top:6px; float:left;' class='select'>
                                            <select name='block'>
                                                <option value='Blocked'>Block</option>
                                                <option value='Not Blocked'>Unblock</option>
                                            </select>
                                        </div>
                                        <div style='margin-top:6px; margin-left:6px; float:right;'>
                                            <button type='submit' class='btn-primary' name='blockButton' value='$userName'>Confirm</button>
                                        </div>
                                    </div>
                                </div>
                             </div>  
                             </form> 
                            ";

                        } $html.="
                        </div>
                </div>



                <br>
                <h3>Your Relationship</h3>

                     <div><div class='table-responsive'><table class='table table-bordered table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Username</th>
                            <th>Current Relationship</th>
                            <th>Block/Unblock</th>
                        </tr>
                    </thead>
                    <tbody>";



                $contactquery = $this->con->prepare("select * from contacts where userName = '$userName'");
                $contactquery->execute();

                while($row = $contactquery->fetch(PDO::FETCH_ASSOC)){
                    $contactUserName = $row['contactUserName'];
                    $contactType = $row['contactType'];
                    $status = $row['contactStatus'];

                    $html.="
                    <tr><td>$contactUserName</td>
                        <td>$contactType</td>
                        <td>$status</td></tr>";
                }
                $html.= "</tbody></table></div></div>";
                return $html;
            }
        }
        catch(Exception $e){
            echo"Some Error Occured: ".$e->getMessage();
        }
    }
    public function makefriends($userName, $friendName, $relationType){
    	//echo "Relationship status with " . $friendName . " changed to ". $relationType;

    	$checkquery = $this->con->prepare("SELECT * from contacts where userName='$userName' and contactUserName = '$friendName'");
    	$checkquery->execute();

    	if($checkquery->rowCount()==0){
	    	$query = $this->con->prepare("INSERT INTO contacts(userName, contactUserName, contactType) VALUES('$userName', '$friendName', '$relationType')");
	        $query->execute();
	    }
	    else{
	    	$query = $this->con->prepare("UPDATE contacts SET contactType = '$relationType' where userName='$userName' and contactUserName = '$friendName'");
	        $query->execute();
    	}
        header("location:contact.php");
    }
    
    public function blockfriends($userName, $friendName, $relationType){
        //echo "You have " .$relationType. " user " . $friendName;

        $checkquery = $this->con->prepare("SELECT * from contacts where userName='$userName' and contactUserName = '$friendName'");
        $checkquery->execute();

        if($checkquery->rowCount()!=0){
            $query = $this->con->prepare("UPDATE contacts SET contactStatus = '$relationType' where userName='$userName' and contactUserName = '$friendName'");
            $query->execute();
        }
        else{
            $query = $this->con->prepare("INSERT INTO contacts(userName, contactUserName, contactStatus) VALUES('$userName', '$friendName', '$relationType')");
            $query->execute();
        }
        header("location:contact.php");
    }

}