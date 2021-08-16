<?php 
    /*
        This File for get data from ajax and to check if user
        change profile  data to save it in database
    */
    session_start();
    include "connection.php";
    
    if(isset($_POST["first_name"])){
        $admin_email = $_SESSION['admin_email'];
        $first_name = $_POST["first_name"];
        $last_name  = $_POST["last_name"];
        $admin_name  = $first_name . " " . $last_name;
        $location   = $_POST['location'];
        $gender     = $_POST['gender'];
        $days       = $_POST["days"];
        $months     = $_POST["months"];
        $years      = $_POST["years"];
        $birthday   = $years . '-' . $months . '-' . $days;
        
        try{
            $query = "UPDATE admins SET admin_name = '$admin_name',
                                        first_name = '$first_name',
                                        last_name  = '$last_name',
                                        admin_gender    = '$gender',
                                        admin_birthday  = '$birthday',
                                        admin_location  = '$location'
                                        where admin_email = '$admin_email'";
            $con->exec($query);
            echo "Change Profile Successfully";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>