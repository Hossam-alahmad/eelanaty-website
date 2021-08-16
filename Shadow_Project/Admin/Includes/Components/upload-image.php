<?php 

    /*
        This File for get data from ajax and to check if user
        upload image only to save it in database
    */
    session_start();
    include "connection.php";
    if(isset($_FILES['admin_image']['name'])){

        $admin_email = $_SESSION['admin_email'];
        $query = $con->prepare("SELECT admin_image FROM admins where admin_email ='$admin_email'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // this condition for delete old image form folders
        if($result['admin_image'] != ""){
            $admin_image = $result['admin_image'];
            $location = "../../Layout/Images/admin-image/" . $admin_image;
            unlink(realpath($location));
        }

        $filename = $_FILES['admin_image']['name'];

        $location = "../../Layout/Images/admin-image/" . $filename;
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
            if(move_uploaded_file($_FILES['admin_image']['tmp_name'],$location)){
                try{
                    $query = "UPDATE admins SET admin_image = '$filename' where  admin_email = '$admin_email'";
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