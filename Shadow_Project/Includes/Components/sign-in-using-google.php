<?php 
    /* 
        This script for take data from ajax to this file
        This file used to save user information in database
        by sign in using google api
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    if(isset($_POST['user_name'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        try{
            // this query for test if this user has already exist or his email is used
            $query = $con->prepare("SELECT * FROM users where user_email = '$user_email' ");
            $query->execute();
            // if user email not found in database so save user info in database
            if($query->rowCount() <= 0)
            {
                $query = "INSERT INTO users (username,user_firstname,user_lastname,user_email)
                                    VALUES ('$user_name','$first_name','$last_name','$user_email')";
                $con->exec($query);
                $_SESSION['user_email'] = $user_email;
                setcookie("user_login",$user_email,time() + (3600 * 24 * 30 * 12),"/");
                echo "<script>alert('register is success')</script>";
            }
            // if user email  found in database so print message email it exist
            else{
                $_SESSION['user_email'] = $user_email;
                // set coockie for 1 year
                setcookie("user_login",$user_email,time() + (3600 * 24 * 30 * 12),"/");
                echo "<script>alert('login is success')</script>";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>