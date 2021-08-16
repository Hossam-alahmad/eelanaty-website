<?php 
    /*
        This File for get data from ajax and to check if user
        change profile  data to save it in database
    */
    session_start();
    include "../../../Admin/Includes/Components/connection.php";
    
    if(isset($_POST["first_name"])){
        if(isset($_COOKIE['user_login'])){
            $user_email = $_COOKIE['user_login'];
        }
        else if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
        }
        $first_name = $_POST["first_name"];
        $last_name  = $_POST["last_name"];
        $user_name  = $first_name . " " . $last_name;
        $location   = $_POST['location'];
        $phone      = $_POST["phone"];
        $gender     = $_POST['gender'];
        $days       = $_POST["days"];
        $months     = $_POST["months"];
        $years      = $_POST["years"];
        $birthday   = $years . '-' . $months . '-' . $days;
        
        try{
            $query = "UPDATE users SET username = '$user_name',
                                        user_firstname = '$first_name',
                                        user_lastname  = '$last_name',
                                        user_number    = '$phone',
                                        user_gender    = '$gender',
                                        user_birthday  = '$birthday',
                                        user_location  = '$location'
                                        where user_email = '$user_email'";
            $con->exec($query);
            echo "Change Profile Successfully";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>