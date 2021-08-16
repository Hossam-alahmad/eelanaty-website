<?php 
    // this file for searching about ads,users,accounts,categories....etc
    session_start();
    include "connection.php";
    if(isset($_POST['search_val'])){
        try{
            $ids = [];
            $string = "";
            $i = 0;
            if($_POST["table"] == 'view_ads'){
                $search = $_POST['search_val'];
                $query = $con->prepare("SELECT * FROM products");
                $query->execute();
                //echo 1;
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $product_id       = $result['product_id'];
                    $p_cat_id         = $result['p_cat_id'];
                    $user_id          = $result['user_id'];
                    $product_name     = $result['product_title'];
                    $product_image    = explode(",",$result['product_images']);
                    $product_price    = $result['product_price'];
                    $product_currency    = $result['product_currency'];
                    
                    
                    $query2 = $con->prepare("SELECT username,user_email FROM users JOIN products ON users.user_id = '$user_id' LIMIT 0,1");
                    $query2->execute();
                    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                    $user_email = $result2['user_email'];
                    $user_name = $result2['username'];
        
                    $query2 = $con->prepare("SELECT cat_title FROM categories JOIN products ON categories.cat_id = '$p_cat_id' LIMIT 0,1");
                    $query2->execute();
                    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                    $cat_title   = $result2['cat_title'];

                    if(strpos($product_name,$search) !== false || strpos($product_price,$search) !== false || strpos($user_name,$search) !== false || strpos($user_email,$search) !== false || strpos($cat_title,$search) !== false)
                    {
                        $ids[$i] = $product_id;
                        $i++;
                    }
                }
                for($j = 0;$j < count($ids); $j++){
                    if($j != (count($ids) - 1)){
                        $string .= $ids[$j] . ",";
                    }
                    else{
                        $string .= $ids[$j];
                    }
                }
                if($string != ""){
                    echo "view_ads&page=1&search=" . $string;
                }
            }
            else if($_POST['table'] == 'view_users'){
                $search = $_POST['search_val'];
                $query = $con->prepare("SELECT * FROM users");
                $query->execute();
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $user_id          = $result['user_id'];
                    $user_name        = $result['username'];
                    $user_email       = $result['user_email'];
                    $user_gender      = $result['user_gender'];
                    $user_location    = $result['user_location'];
                    $user_status      = $result['last_login'];
                    $account_date     = $result['create_account'];
                    
                    $status = "غير متصل";
                    if($user_status > time()){
                        $status = "متصل";
                    }
                    

                    if(strpos($user_name,$search) !== false || strpos($user_email,$search) !== false || strpos($user_gender,$search) !== false ||  strpos($user_location,$search) !== false || strpos($account_date,$search) !== false || $status == $search)
                    {
                        $ids[$i] = $user_id;
                        $i++;
                    }
                }
                for($j = 0;$j < count($ids); $j++){
                    if($j != (count($ids) - 1)){
                        $string .= $ids[$j] . ",";
                    }
                    else{
                        $string .= $ids[$j];
                    }
                }
                if($string != ""){
                    echo "view_users&page=1&search=" . $string;
                }
            }
            else if($_POST['table'] == "view_cats"){
                $search = $_POST['search_val'];
                $query = $con->prepare("SELECT * FROM categories");
                $query->execute();
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $cat_id        = $result['cat_id'];
                    $cat_title     = $result['cat_title'];
                    $cat_desc      = $result['cat_desc'];
                    $cat_keywords  = $result['cat_keywords'];
                    
                    if(strpos($cat_title,$search) !== false || strpos($cat_desc,$search) !== false || strpos($cat_keywords,$search) !== false)
                    {
                        $ids[$i] = $cat_id;
                        $i++;
                    }
                }
                for($j = 0;$j < count($ids); $j++){
                    if($j != (count($ids) - 1)){
                        $string .= $ids[$j] . ",";
                    }
                    else{
                        $string .= $ids[$j];
                    }
                }
                if($string != ""){
                    echo "view_cats&page=1&search=" . $string;
                }
            }
            else if($_POST['table'] == "view_services"){
                $search = $_POST['search_val'];
                $query = $con->prepare("SELECT * FROM services");
                $query->execute();
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $service_id       = $result['service_id'];
                    $service_title    = $result['service_title'];
                    $service_desc     = $result['service_desc'];

                    if(strpos($service_title,$search) !== false || strpos($service_desc,$search) !== false)
                    {
                        $ids[$i] = $service_id;
                        $i++;
                    }
                }
                for($j = 0;$j < count($ids); $j++){
                    if($j != (count($ids) - 1)){
                        $string .= $ids[$j] . ",";
                    }
                    else{
                        $string .= $ids[$j];
                    }
                }
                if($string != ""){
                    echo "view_services&page=1&search=" . $string;
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>