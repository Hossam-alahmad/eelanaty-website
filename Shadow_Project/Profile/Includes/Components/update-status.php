<?php 
    /* 
        This script for take data from ajax to this file
        This file used to save user status in database
        by session
    */
    session_start();
    include "../../../Admin/Includes/Components/connection.php";
    if(isset($_SESSION['user_email'])){
        $user_email = $_SESSION['user_email'];
        $time = time() + 30;
        try{
            $query = "UPDATE users SET last_login = '$time' WHERE user_email = '$user_email'";
            $con->exec($query); 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>