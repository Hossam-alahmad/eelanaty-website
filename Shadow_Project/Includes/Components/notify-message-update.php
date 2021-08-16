<?php
    /* 
        This script for take data from ajax to this file
        This file used to update chat messages between sender and recever
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    if(!isset($_POST['total_notify']) && !isset($_POST['total_notify2'])){
        $user1_ids = $_POST['user1_ids'];
        $total_ids = $_POST['total_ids'];
        $user2_id = $_POST['user2_id'];
        if($user1_ids != "" && $total_ids != "" && $user2_id !=""){
            try{
                // variables
                
                $end = $user1_ids;
                
                // query for get user id (sender) and username (sender) by use his ids 
                $query = $con->prepare("SELECT user_id,username FROM users JOIN chat ON users.user_id IN($total_ids) limit 0,$end");
                $query->execute();
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $user_name = $result['username'];
                        $user1_id  = $result['user_id'];
                        // query for get every user sender how much send message
                        $query2 = $con->prepare("SELECT notification_numbers FROM chat where user1_id = '$user1_id ' AND user2_id = '$user2_id' AND notification_numbers = '1'");
                        $query2->execute();
                        $sum_message = $query2->rowCount();
                        
                        if($sum_message > 0){
                            $notify_sender = "لديك " . $sum_message . " رسالة جديدة من " . $user_name; 
                            echo "<li><a href='Profile/user-profile.php?user_id=$user1_id&page=1&open_chat=$user1_id' data-text='$user1_id'>$notify_sender</a></li>";
                        }
                        else{
                            echo "<p>لايوجد اي اشعار</p>";
                        }
                    }
                //echo $user2_id;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
    if(isset($_POST['total_notify']) && !isset($_POST['total_notify2'])){
        if(isset($_SESSION['user_email']) || isset($_COOKIE['user_login'])){
            if(isset($_SESSION['user_email'])){
                $user_email = $_SESSION['user_email'];
            }
            else if(isset($_COOKIE['user_login'])){
                $user_email = $_COOKIE['user_login'];
            }
            try{
                // variables
                $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $user2_id = $result['user_id'];
                // query for get sum of all messages send it to second user
                $query = $con->prepare("SELECT notification_numbers,user1_id FROM chat where user2_id = '$user2_id' AND notification_numbers = '1'");
                $query->execute();
                $total_notify = $query->rowCount();
                $badge = "badge-danger";
                // if we dont have any notification
                if($total_notify == 0){
                    $total_notify = "";
                    $badge = "";
                }
                echo "<span class='badge $badge' id='bell-notify'>$total_notify</span>
                        <a class='nav-link'><i class='fa fa-bell' aria-hidden='true'></i></a>
                    ";
                
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
    if(isset($_POST['total_notify2'])){
        if(isset($_SESSION['user_email']) || isset($_COOKIE['user_login'])){
            if(isset($_SESSION['user_email'])){
                $user_email = $_SESSION['user_email'];
            }
            else if(isset($_COOKIE['user_login'])){
                $user_email = $_COOKIE['user_login'];
            }

            try{
                // query for get id of user who have notification
                $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $user2_id = $result['user_id'];
                // query for get sum of all messages send it to second user
                $query = $con->prepare("SELECT notification_numbers,user1_id FROM chat where user2_id = '$user2_id' AND notification_numbers = '1'");
                $query->execute();
                $total_notify = $query->rowCount();
                $user1_ids = [];
                $i = 0;
                // add all first users (sender) id to array 
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $user1_ids[$i] = $result['user1_id'];
                    $i++;
                }
                // delete duplicate of datd ids
                $user1_ids = array_unique($user1_ids);
                $total_ids = "";
                for($i = 0 ;$i< count($user1_ids);$i++){
                    if($i != (count($user1_ids) - 1)){
                        $total_ids .= $user1_ids[$i] . ",";
                    }
                    else{
                        $total_ids .= $user1_ids[$i];
                    }
                    
                }
                // get user1 id sender                                             
                echo count($user1_ids) . '-' . $total_ids . '-' . $user2_id;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>