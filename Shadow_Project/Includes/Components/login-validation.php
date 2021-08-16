<?php 
    /* 
        This script for take data from ajax to this file
        This file used to check user information of login in database to login
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    if(isset($_POST['email'])){ 
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        
        try{
            // this query for test if this user has already exist or his email is used
            $query = $con->prepare("SELECT * FROM users where user_email = '$email' ");
            $query->execute();
            // if user email not found in database so print messsage not found
            if($query->rowCount() <= 0)
            {
                echo "<script>alert('email is not found');</script>";
            }
            // if user email  found in database
            else{
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($password != $result['user_pass']){
                    echo "<script>alert('invalid password');</script>";
                }
                else{
                    /*
                    $query = "UPDATE users SET user_connection = 'online'  where user_email = '$email'";
                    $con->exec($query);
                    */
                    $_SESSION['user_email'] = $result['user_email'];
                    $time = time() + 30;
                    $query = "UPDATE users SET last_login = '$time' WHERE user_email = '$email'";
                    $con->exec($query); 
                    setcookie("user_login",$result['user_email'],time() + (3600 * 24 * 30),"/");
                    echo "<script>alert('welcome');</script>";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>