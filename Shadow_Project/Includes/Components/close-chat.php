<?php 
    /*
        This File for get data from ajax and to delete users status from chat
        and make him offline
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    
    if(isset($_POST['user2_id'])){
        $user2_id = $_POST['user2_id'];
        $user_email = "";
        if(isset($_COOKIE['user_login'])){
            $user_email = $_COOKIE['user_login'];
        }
        else if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
        }
        try{
            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user1_id = $result['user_id'];
            $query = $con->prepare("SELECT * FROM chat_session where user1_id = '$user1_id' AND user2_id = '$user2_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $query = "DELETE FROM chat_session where user1_id = '$user1_id' AND user2_id = '$user2_id'";
                $con->exec($query);
                $query = "ALTER TABLE chat_session AUTO_INCREMENT = 1";
                $con->exec($query);
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>