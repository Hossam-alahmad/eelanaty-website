<?php 
    session_start();
    include "connection.php";
    if(isset($_POST['email']) && isset($_POST['password'])){

        $admin_email   = $_POST['email'];
        $admin_pass    = sha1($_POST['password']); // ecriptyon admin password using sha1 algorithm

        try{
            $query        = $con->prepare("SELECT * FROM admins where admin_email = '$admin_email'");
            $query->execute();
            $check_admin   = $query->rowCount();
            if($check_admin == 0){
                echo "Admin Not Found";
            }
            else{
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($admin_pass == $result['admin_pass']){
                    $_SESSION['admin_id']       = $result['admin_id'];
                    $_SESSION['admin_name']     = $result['admin_name'];
                    $_SESSION['admin_email']    = $result['admin_email'];
                    $_SESSION['admin_level']    = $result['admin_level'];
                    echo "Welcome '" . $result['admin_name'];
                    
                }
                else{
                    echo "Invalid Password";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>