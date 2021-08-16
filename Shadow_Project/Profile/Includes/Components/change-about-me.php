<?php 
    /*
        This File for get data from ajax and to check if user
        change about  data to save it in database
    */
    session_start();
    include "../../../Admin/Includes/Components/connection.php";
    
    if(isset($_POST['about_me'])){
        $user_email = "";
        if(isset($_COOKIE['user_login'])){
            $user_email = $_COOKIE['user_login'];
        }
        else if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
        }
        $about_me = $_POST['about_me'];
        try{
            $query = "UPDATE users SET user_about = '$about_me'
                                        where user_email = '$user_email'";
            $con->exec($query);
            echo "Change About Me Successfully";
        }
        catch(PDOException $e){
            echo $about_me;
        }
    }
?>