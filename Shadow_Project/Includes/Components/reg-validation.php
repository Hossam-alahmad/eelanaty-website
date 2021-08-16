<?php 
    /* 
        This script for take data from ajax to this file
        This file used to save user information of register in database
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    if(isset($_POST['firstname'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $user_name = $firstname . ' ' . $lastname;
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        
        try{
            // this query for test if this user has already exist or his email is used
            $query = $con->prepare("SELECT * FROM users where user_email = '$email' ");
            $query->execute();
            // if user email not found in database so save user info in database
            if($query->rowCount() <= 0)
            {
                $query = "INSERT INTO users (username,user_firstname,user_lastname,user_email,user_pass,create_account)
                                    VALUES ('$user_name','$firstname','$lastname','$email','$password',NOW())";
                $con->exec($query);
                /*
                    $query = "UPDATE users SET user_connection = 'online' where user_email = '$email'";
                    $con->exec($query);
                */
                $_SESSION['user_email'] = $email;
                $time = time() + 30;
                $query = "UPDATE users SET last_login = '$time' WHERE user_email = '$email'";
                $con->exec($query); 
                setcookie("user_login",$email,time() + (3600 * 24 * 30 * 12),"/");
                echo "<script>alert('register is success')</script>";
            }
            // if user email  found in database so print message email it exist
            else{
                echo "<script>alert('email is exist')</script>";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>