<?php 
    /* 
        This script for take data from ajax to this file
        This file used to check user images of his ads in database to deleted
    */
    session_start();
    include "../../Admin/Includes/Components/connection.php";
    if(isset($_POST['image'])){ 
        $image = $_POST['image'];
        $product_id = $_POST['product_id'];
        
        try{
            // query for get product images  
            $query = $con->prepare("SELECT product_images FROM products where product_id = '$product_id' ");
            $query->execute();
            // fetch data
            $result = $query->fetch(PDO::FETCH_ASSOC);
            // add location of the image in variable for deleted
            $location = "../../Layout/Images/products/" . $image;
            // delete image using his path
            unlink(realpath($location));  
            $set_image = "";
            if($result['product_images'] != ""){
                /* this for loop for delete image from database 
                * by compare the image who want deleted with 
                * all images in this product
                */
                $product_images = explode(",",$result['product_images']);
                for($i = 0;$i < count($product_images);$i++){
                    if($product_images[$i] == $image){
                        array_splice($product_images,$i,1);
                    }
                }
                // set all images without the deleted one to variable and update database
                for($i = 0;$i < count($product_images);$i++){
                    if($i < (count($product_images) - 1)){
                        $set_image .= $product_images[$i] . ','; 
                    }
                    else{
                        $set_image .= $product_images[$i]; 
                    }
                }
                $query = "UPDATE products SET product_images='$set_image' where product_id = '$product_id'";
                $store_db = $con->exec($query);
                if($store_db){
                    echo "delete image success";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>