<?php 
    /*
        This File for get data from ajax and to check if user
        send message and save this message in database
        user1_id is the sender of message
        user2_id is the recever of message
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    
    if(isset($_POST["user_message"])){
        if(isset($_COOKIE['user_login'])){
            $user_email = $_COOKIE['user_login'];
        }
        else if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
        }
        $user2_id = $_POST['user_id'];
        $user_message = base64_encode($_POST['user_message']);
        try{
            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user1_id = $result['user_id'];

            
            $query = $con->prepare("SELECT last_login FROM users where user_id = '$user2_id'");
            $query->execute();
            $last_login = $result['last_login'];
            
            // check if the user1 and user2 already online in chat 
            $query = $con->prepare("SELECT * FROM chat_session where (user1_id = '$user1_id' AND user2_id = '$user2_id') || (user1_id = '$user2_id' AND user2_id = '$user1_id') ");
            $query->execute();

            $num = 0;
            if($query->rowCount() != 2){
                $num = 1;
            }
            $query = "INSERT INTO chat (user1_id,user2_id,chat_text,notification_numbers,message_date) VALUES ('$user1_id','$user2_id','$user_message','$num',NOW())";
            $con->exec($query);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }