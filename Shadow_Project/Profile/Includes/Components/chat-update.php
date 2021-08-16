<?php
    /* 
        This script for take data from ajax to this file
        This file used to update chat messages between sender and recever
    */
    session_start();
    include "../../../Admin/Includes/Components/connection.php";
    if(isset($_POST['user2_id'])){
        try{
            // variables
            $message_count = $_POST['message_count'];
            $user2_id = $_POST['user2_id'];
            $user_email = $_SESSION['user_email'];
            // get user id (sender) from database
            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user1_id = $result['user_id'];
            
            // query for get total chat we have it between sender and recever
            $query = $con->prepare("SELECT * FROM chat where (user1_id = '$user1_id' AND user2_id = '$user2_id') || (user1_id = '$user2_id' AND user2_id = '$user1_id')");
            $query->execute();
            // if we have new message then just fetch it from database
            if($query->rowCount() > $message_count){
                $user_class = "";
                $total_record = $query->rowCount();
                $query = $con->prepare("SELECT * FROM chat where (user1_id = '$user1_id' AND user2_id = '$user2_id') || (user1_id = '$user2_id' AND user2_id = '$user1_id') ORDER BY 1 LIMIT $message_count,$total_record");
                $query->execute();
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $message = base64_decode($result['chat_text']);
                    // this condition for get all message from user1 to user2
                    if($user1_id == $result['user1_id'] && $user2_id == $result['user2_id'])
                        $user_class = "user1";
                    // this condition for get all message from user2 to user1
                    else if($user1_id == $result['user2_id'] && $user2_id == $result['user1_id'])
                        $user_class = "user2";

                    echo "
                        <div class='message'>
                            <p class='$user_class'>$message</p>
                        </div>
                        ";
                    
                }
            }
            
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>