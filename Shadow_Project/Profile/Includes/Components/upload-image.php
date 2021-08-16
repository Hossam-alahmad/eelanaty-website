<?php 

    /*
        This File for get data from ajax and to check if user
        upload image only to save it in database
    */
    session_start();
    include "../../../Admin/Includes/Components/connection.php";
    if(isset($_FILES['user_image']['name'])){

        $user_email = $_COOKIE['user_login'];
        $query = $con->prepare("SELECT user_image FROM users where user_email ='$user_email'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // this condition for delete old image form folders
        if($result['user_image'] != ""){
            $user_image = $result['user_image'];
            $location = "../../Layout/Images/users-images/" . $user_image;
            unlink(realpath($location));
        }

        $filename = $_FILES['user_image']['name'];

        $location = "../../Layout/Images/users-images/" . $filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $valid_extension = array("jpg","jpeg","png");
        if(!in_array(strtolower($imageFileType),$valid_extension)){
            $uploadOk = 0;
        }
        if($uploadOk == 0){
            echo 0;
        }
        else{
            if(move_uploaded_file($_FILES['user_image']['tmp_name'],$location)){
                if(isset($_COOKIE['user_login'])){
                    $user_email = $_COOKIE['user_login'];
                }
                else if(isset($_SESSION['user_email'])){
                    $user_email = $_SESSION['user_email'];
                }
                try{
                    $query = "UPDATE users SET user_image = '$filename' where  user_email = '$user_email'";
                    $con->exec($query); 
                    echo "Upload Image Success";
                }
                catch(Exception $e){
                    echo $e->getMessage();
                }
            }
            else{
                echo 0;
            }
        }
    }
?>