<?php  
class MessagingClass{
    private $con;
    public function __construct($con){
        $this->con=$con;
    }
    public function getAllUserstoMessage($userName){
        try{
            $query = $this->con->prepare("SELECT * from users where userName != '$userName'");
            $query->execute();
            if($query->rowCount()== 0){
                return "";
            }
            else{
                $html = "
                <div style='margin:auto;'>
                    <form action='message.php' method='POST'>
                    <br>
                    <br>
                        <div class='form-group_msg'>
                        <label for='description'>Select Recipient <span></span></label>
                            <div class='select'>
                                <select name='recipient'>";
                                    while($row= $query->fetch(PDO::FETCH_ASSOC)){
                                        $html.= "<option value='" . $row['userName'] . "'>" . $row['userName'] . "</option>";
                                    }
                                    $html.= "
                                </select>
                            </div>
                            <br>
                            <div >
                                <label for='description'>Message <span></span></label>
                                <textarea style='min-height:80px;'  type='text' name='msg' class='form-controll' placeholder='Enter your message here'></textarea>
                            </div>
                            <br>
                            <button class='send_msg_button' value='$userName' name='messageButton' type='submit' />Send</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </form>
                </div>
                <br>
                <br>";
                return $html;
            }
        }
        catch(Exception $e){
            echo"Some Error Occured: ".$e->getMessage();
        }
    }
    public function sendMessage($loggedInUserName, $recipient, $msg){
        $query = $this->con->prepare("INSERT INTO messages(sentBy, sentTo, message) VALUES('$loggedInUserName', '$recipient', '$msg')");
        $query->execute();
    }

    public function viewMessage($loggedInUserName){
    
        $query = $this->con->prepare("select * from messages where sentTo = '$loggedInUserName'");

        $query->execute();
        if($query->rowCount()== 0){
                return "";
        }
        else{

            $html = "
            <br>
            <div class='sent'>
            <h3 style='color:green;'>Inbox</h3>
            ";

            while($row=$query->fetch(PDO::FETCH_ASSOC)){
                $sentBy= $row["sentBy"];
                $message= $row["message"];
                $sentAt= $row["sentAt"];
                $html.= "<div class='msg-item' >";
                $html.=  "<h5>$message</h5>";  
                $html.=  "<p>From: $sentBy, At: $sentAt</p></div>";
            }
            $html.=  "</div>";   

            echo $html;

        }

        $sent_query = $this->con->prepare("select * from messages where sentBy = '$loggedInUserName'");
        $sent_query->execute();
        if($sent_query->rowCount()== 0){
                return "";
        }
        else{  

            $html = "
            <br>
            <div>
            <h3 style='color:green;'>Sent</h3>
            ";

            while($row=$sent_query->fetch(PDO::FETCH_ASSOC)){
                $sentTo= $row["sentTo"];
                $message= $row["message"];
                $sentAt= $row["sentAt"];
                $html.= "<div class='msg-item' >";
                $html.=  "<h5>$message</h5>";  
                $html.=  "<p>To: $sentTo, At: $sentAt </p>";
                $html.=  "</div>";   
            }
            $html.=  "</div>";   

            echo $html;
        }
    }
}

