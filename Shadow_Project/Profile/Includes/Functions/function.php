<?php 

// this function for get all ads for users
function getAds($per_page){
    global $con;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $start = ($page - 1) * $per_page;
    // this condition for get all ads to users
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $query = $con->prepare("SELECT user_id,username,user_image FROM users where user_id = '$user_id'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $result['user_id'];
        $user_name = $result['username'];
        $user_image = $result['user_image'];
    }
    // this else condition for get all ads to account of user who login in our website
    else{
        if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])){
            // this condition for if my website dont remember user get session value
            if(isset($_COOKIE['user_login'])){
                $user_email = $_COOKIE['user_login'];
            }
            else if(isset($_SESSION['user_email'])){
                $user_email = $_SESSION['user_email'];
            }
                // query for get data from users table
                $query = $con->prepare("SELECT user_id,username,user_image FROM users where user_email = '$user_email'");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $user_id = $result['user_id'];
                $user_name = $result['username'];
                $user_image = $result['user_image'];
                
        }
        // query for get data from products table   
    }
    $query = $con->prepare("SELECT * FROM products where user_id = '$user_id'  ORDER BY 1 DESC LIMIT $start,$per_page");
    $query->execute();
    if($query->rowCount() > 0){
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            $product_id = $result['product_id'];
            $product_title = $result['product_title'];
            $product_watch = $result['product_watch'];
            $product_status = $result['product_status'];
                $status_color = "";
                if($product_status == "جديد"){
                    $status_color = "orange";
                }
                else if($product_status == "إعلان"){
                    $status_color = "blue";
                }
                else{
                    $status_color = "violet";
                }
            $product_images = explode(",",$result['product_images']);
            echo "
                <div class='col-sm-6 col-lg-4'>
                    <a href='../show-ads.php?p_id=$product_id'>
                        <div class='item'>
                            <div class='ads-title row'>
                                <div class='col-1 col-sm-2 col-md-2 col-lg-2 user-img'>
                                <div class='img-box'"; if($user_image != "") echo 'style=background-color:transparent'; echo ">";
                                    if($user_image != ""){
                                        echo "<img src='Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                                    }
                                    else{
                                        // this statment for get first character of string
                                        preg_match("/./u",$user_name,$first_char);
                                        $first_char = strtoupper($first_char[0]);
                                        echo "<span>$first_char</span>";
                                    }
                                    echo  "</div>
                                </div>
                                <div class='col-9 col-sm-8 col-md-9 col-lg-8 user-info'>
                                    <div class='username'>
                                        <h6>
                                            $user_name
                                        </h6>
                                        <p>$product_title</p>
                                    </div>
                                </div>
                                <div class='col-2 col-sm-2 col-md-1 col-lg-2 watches'>
                                    <div class='watch'>
                                        $product_watch <i class='fa fa-eye'></i> 
                                    </div>
                                </div>
                            </div>
                            <div class='ads-image'>
                                <img src='../Layout/Images/products/$product_images[0]' class='img-responsive' alt='$product_images[0]'>
                                <div class='product-type $status_color'>$product_status</div>
                            </div>
                        </div>
                    </a>
                </div>
                ";
        }
    }
    else{
        echo "
            <div class='no-ads'>
                <p>لايوجد اي إعلانات مضافة</p>
            </div>
        ";
    }
}
// pagintation
function pagantition($per_page){
    global $con;
    $page = "";
    $total_page = "";
    $link = "";
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $query = $con->prepare("SELECT * FROM products where user_id = '$user_id'");
        $query->execute();
        $records = $query->rowCount();
        $total_page = ceil($records / $per_page);
        $link = "user-profile.php?user_id=$user_id&page=";
    }
    else{
        $user_email = $_SESSION['user_email'];

        $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $result['user_id'];

        $query = $con->prepare("SELECT * FROM products where user_id = '$user_id'");
        $query->execute();
        $records = $query->rowCount();
        $total_page = ceil($records / $per_page);
        $link = "personal-profile.php?my-ads&page=";
    }
    if($total_page != 0){
        if($_GET['page'] != 1){
            $page = $_GET['page'] -1;
        }
        else{
            $page = "1";
        }
        echo "
                <a href='$link" . $page ."' class='btn btn-default' id='prev' data-text='1'>السابق</a>
            ";
        if($_GET['page'] < $total_page){
            $page = $_GET['page'] + 1;
        }
        else{
            $page = $total_page;
        }
        echo "<a href='$link" . $page ."' class='btn btn-default' id='next'>التالي</a>";
    }
}
?>