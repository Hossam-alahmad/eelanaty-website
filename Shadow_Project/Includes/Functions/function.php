<?php 

/*  Get All Category */
function getCategory(){
    // this function for get all categories to categories.php page
    try{
        global $con;
        $query = $con->prepare("SELECT * FROM categories");
        $query->execute();
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            $cat_id         = $result["cat_id"];
            $cat_icon       = $result["cat_icon"];
            $cat_title      = $result["cat_title"];
            $cat_desc       = $result["cat_desc"];
            $class = "col-md-6 col-lg-4";
            if($cat_title == "اخرى"){
                $class = "col-md-12 col-lg-8";
            }
            echo "
                <div class='$class'>
                    <a href='ads.php?cat_id=$cat_id&page=1'>
                        <div class='item'>
                            <div class='img-box'>
                                <img src='Layout/Images/icons/$cat_icon' class='img-responsive' alt='$cat_icon'>
                            </div>
                            <h4>$cat_title</h4>
                            <p>$cat_desc</p>
                        </div>
                    </a>
                </div>
            ";
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
/*  Get All Category In Sidebar */
function getSideBarCategory(){
    // this function for get all categories exist in sidebar components
    try{
        global $con;
        // query select for get all categories
        $query = $con->prepare("SELECT * FROM categories");
        $query->execute();
        // if we have cat_id then go inside condition
        if(isset($_GET['cat_id'])){
            if($_GET['cat_id'] == 'all'){
                echo "
                    <li class='active'><a href='ads.php?cat_id=all&page=1'>كل الأقسام</a></li>
                ";
            }
            else{
                echo "
                    <li class=''><a href='ads.php?cat_id=all&page=1'>كل الأقسام</a></li>
                ";
            }
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                // Initialize Variables
                $cat_id         = $result["cat_id"];
                $cat_title      = $result["cat_title"];
                if($_GET['cat_id'] == $cat_id){
                    echo "
                        <li class='active'><a href='ads.php?cat_id=$cat_id&page=1'>$cat_title</a></li>
                    ";
                }
                else{
                    echo "
                        <li class=''><a href='ads.php?cat_id=$cat_id&page=1'>$cat_title</a></li>
                    ";
                }
            }
        }
        else{
            echo "
                    <li class=''><a href='ads.php?cat_id=all&page=1'>كل الأقسام</a></li>
                ";
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $cat_id         = $result["cat_id"];
                $cat_title      = $result["cat_title"];
                echo "
                    <li class=''><a href='ads.php?cat_id=$cat_id&page=1'>$cat_title</a></li>
                ";
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
/* Get All Services */
function getServices(){
    /*
        This Function for get all service to index.php
    */
    try{
        global $con;
        // query select for get just 6 services from services table
        $query = $con->prepare("SELECT * FROM services LIMIT 6");
        $query->execute();
        // fetch services
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            // initialize variables
            $service_icon       = $result["service_icon"];
            $service_title      = $result["service_title"];
            $service_desc       = $result["service_desc"];
            echo "
            <div class='service-item col-md-6 col-lg-4'>
                <div class='img-box'>
                                <img src='Layout/Images/icons/$service_icon' class='img-responsive' alt='$service_icon'>
                            </div>
                <div class='content'>
                    <h4>$service_title</h4>
                    <p>$service_desc</p>
                </div>
            </div>
        ";
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    
}
/*  Get All Category In Index*/
function getIndexCategory(){
    // Get all categories to index.php
    try{
        global $con;
        // query select for get just 6 categories from categories table
        $query = $con->prepare("SELECT * FROM categories LIMIT 6");
        $query->execute();
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            // Initialize Variables
            $cat_id         = $result["cat_id"];
            $cat_icon       = $result["cat_icon"];
            $cat_title      = $result["cat_title"];
            $cat_desc       = $result["cat_desc"];
            echo "
                <div class='category-item col-md-6 col-lg-4'>
                    <div class='content'>
                        <div class='img-box'>
                            <img src='Layout/Images/icons/$cat_icon' class='img-responsive' alt='$cat_icon'>
                        </div>
                        <div class='info'>
                            <h4>$cat_title</h4>
                            <p>$cat_desc</p>
                            <a class='btn btn-primary' href='ads.php?cat_id=$cat_id&page=1'>عرض القسم</a>
                        </div>
                    </div>
                </div>
            ";
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
// this function for get ads by category
function getAds($per_page){
    // this function for get ads by category
    if(isset($_GET['cat_id'])){
        global $con;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
        }
        $start = ($page - 1) * $per_page;
        $cat_id = $_GET['cat_id'];
        // if p_cat != all then show  ads in database by his p_cat number
        if($cat_id != 'all'){
            $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id' ORDER BY 1 DESC LIMIT $start,$per_page");
            $query->execute();
        }
        // if p_cat = all then show all ads in database
        else{
            $query = $con->prepare("SELECT * FROM products  ORDER BY 1 DESC LIMIT $start,$per_page");
            $query->execute();
        }
        if($query->rowCount() > 0){
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $product_id = $result['product_id'];
                $user_id = $result['user_id'];
                $product_title = $result['product_title'];
                $product_images = explode(",",$result['product_images']);
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
                // get user name by user user_id
                $second_query = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
                $second_query->execute();
                $result2 = $second_query->fetch(PDO::FETCH_ASSOC);
                $user_name =   $result2['username']; 
                $user_image = $result2['user_image'];
                $last_login = $result2['last_login'];
                $class = 'offline';
                // for check if user is connect now
                if($last_login > time())
                    $class = 'online';
                echo "
                    <div class='col-sm-6 col-lg-4'>
                        <a href='show-ads.php?p_id=$product_id'>
                            <div class='item'>
                                <div class='ads-title row'>
                                    <div class='col-1 col-sm-2 col-md-2 col-lg-2 user-img'>
                                        <div class='img-box'"; if($user_image != "") echo 'style=background-color:transparent'; echo ">";
                                        if($user_image != ""){
                                            echo "<img src='Profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                                        }
                                        else{
                                            preg_match("/./u",$user_name,$first_char);
                                            $first_char = strtoupper($first_char[0]);
                                            echo "<span>$first_char</span>";
                                        }
                                        echo "<div class='user-connection $class'></div>";
                                        echo    "</div>
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
                                    <img src='Layout/Images/products/$product_images[0]' class='img-responsive' alt='$product_images[0]'>
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
}
// this function for get ads by category
function getUsersAdsBySearch($per_page,$found,$id){
    // this function for get ads or users by search
    if($found == true){
        global $con;
        try{
            // if we have cat_id then get ads
            if(isset($_GET['cat_id'])){
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                else{
                    $page = 1;
                }
                $start = ($page - 1) * $per_page;
                //query select for get product by use $id parameter of search input result";
                $query = $con->prepare("SELECT * FROM products where product_id IN ($id) ORDER BY 1 DESC LIMIT $start,$per_page");
                $query->execute();
                if($query->rowCount() > 0){
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $product_id = $result['product_id'];
                        $user_id = $result['user_id'];
                        $product_title = $result['product_title'];
                        $product_images = explode(",",$result['product_images']);
                        $product_watch = $result['product_watch'];
        
                        // get user name by user user_id
                        $second_query = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
                        $second_query->execute();
                        $result2 = $second_query->fetch(PDO::FETCH_ASSOC);
                        $user_name =   $result2['username']; 
                        $user_image = $result2['user_image'];
                        $last_login = $result2['last_login'];
                        $class = 'offline';
                        // for check if user is connect now
                        if($last_login > time())
                            $class = 'online';
                            echo "
                            <div class='col-sm-6 col-lg-4'>
                                <a href='show-ads.php?p_id=$product_id'>
                                    <div class='item'>
                                        <div class='ads-title row'>
                                            <div class='col-1 col-sm-2 col-md-2 col-lg-2 user-img'>
                                                <div class='img-box'"; if($user_image != "") echo 'style=background-color:transparent'; echo ">";
                                                if($user_image != ""){
                                                    echo "<img src='Profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                                                }
                                                else{
                                                    preg_match("/./u",$user_name,$first_char);
                                                    $first_char = strtoupper($first_char[0]);
                                                    echo "<span>$first_char</span>";
                                                }
                                                echo "<div class='user-connection $class'></div>";
                                                echo    "</div>
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
                                            <img src='Layout/Images/products/$product_images[0]' class='img-responsive' alt='$product_images[0]'>
                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ";
                    }
                }
            }
            // if we dont have cat_id then get users
            else{
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                else{
                    $page = 1;
                }
                $start = ($page - 1) * $per_page;
                //query select for get users by use $id parameter of search input result";
                $query = $con->prepare("SELECT * FROM users where user_id IN ($id) ORDER BY 1 DESC LIMIT $start,$per_page");
                $query->execute();
                if($query->rowCount() > 0){
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $user_id    = $result['user_id'];
                        $user_name   = $result['username'];
                        $user_image = $result['user_image'];
                        $user_location = $result['user_location'];
                        if($user_location == ''){
                            $user_location = 'غير معروف';
                        }
                        // for check if user is connect now
                        $last_login = $result['last_login'];
                        $class = 'offline';
                        $status = 'غير متصل';
                        if($last_login > time()){
                            $class = 'online';
                            $status = 'متصل';
                        }
                        echo "
                            <div class='col-md-4'>
                                <div class='item'>
                                    <div class='user-img img-box'"; if($user_image != "") echo 'style=background-color:transparent'; echo ">";
                                    
                                        if($user_image != ""){
                                            echo "<img src='Profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                                        }
                                        else{
                                            preg_match("/./u",$user_name,$first_char);
                                            $first_char = strtoupper($first_char[0]);
                                            echo "<span>$first_char</span>";
                                        }
                                        //<img src='profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>
                        echo"       </div>
                                    <div class='username'>
                                        <h5>$user_name</h5>
                                        <div>
                                            <span><i class='fa fa-map-marker'></i> $user_location</span>
                                            <span><i class='fa fa-circle user-connection $class'></i> $status</span>
                                        </div>
                                    </div>
                                    <div class='user-profile'>
                                        <a class='btn btn-primary btn-block' href='profile/user-profile.php?user_id=$user_id'>الملف الشخصي</a>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "
                <div class='no-ads'>
                    <p>لايوجد أي نتائج بحث</p>
                </div>
            ";
    }
}
// this function for get users
function getUsers($per_page){
    // this function for get all users from database to users.php
    global $con;
    if(isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = 1;
        
    $start = ($page - 1) * $per_page;
    try{
        $query = $con->prepare("SELECT * FROM users ORDER BY 1 DESC LIMIT $start,$per_page");
        $query->execute();
        if($query->rowCount() > 0){
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $user_id    = $result['user_id'];
                $user_name   = $result['username'];
                $user_image = $result['user_image'];
                $user_location = $result['user_location'];
                if($user_location == ''){
                    $user_location = 'غير معروف';
                }
                $last_login = $result['last_login'];
                $class = 'offline';
                $status = 'غير متصل';
                // for check if user is connect now
                if($last_login > time()){
                    $class = 'online';
                    $status = 'متصل';
                }
                
                echo "
                    <div class='col-md-6 col-lg-4'>
                        <div class='item'>
                            <div class='user-img img-box'"; if($user_image != "") echo 'style=background-color:transparent'; echo ">";                         
                                if($user_image != ""){
                                    echo "<img src='Profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                                }
                                else{
                                    preg_match("/./u",$user_name,$first_char);
                                    $first_char = strtoupper($first_char[0]);
                                    echo "<span>$first_char</span>";
                                }
                                //<img src='profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>
                echo"       </div>
                            <div class='username'>
                                <h5>$user_name</h5>
                                <div>
                                    <span><i class='fa fa-map-marker'></i> $user_location</span>
                                    <span><i class='fa fa-circle user-connection $class'></i> $status</span>
                                </div>
                            </div>
                            <div class='user-profile'>
                                <a class='btn btn-primary btn-block' href='Profile/user-profile.php?user_id=$user_id&page=1'>الملف الشخصي</a>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

}
// this function for get title of ads
function getTitleOfAds(){
    if(isset($_GET['cat_id'])){
        global $con;
        if($_GET['cat_id'] != 'all'){
            $cat_id = $_GET['cat_id'];
            $query = $con->prepare("SELECT cat_title FROM categories where cat_id = '$cat_id'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $cat_title = $result['cat_title'];
            echo $cat_title;
        }
        else{
            echo "كل الإعلانات";
        }
    }
}
// pagintation
function pagantition($per_page,$found,$id){
    // this function for get pages of ads by categories
    global $con;
    $page = "";
    $link = "";
    if(!isset($_GET['result']) && isset($_GET['cat_id'])){
        try{
            
            if($_GET['cat_id'] != 'all'){
                $cat_id = $_GET['cat_id'];
                $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id'");
                $query->execute();
                $link = "ads.php?cat_id=$cat_id&page=";
            }
            else{
                $query = $con->prepare("SELECT * FROM products");
                $query->execute();  
                $link = "ads.php?cat_id=all&page=";
            }
            $total_page = 0;
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            if($total_page != 0){
                if($_GET['page'] != 1){
                    $page = ($_GET['page'] -1);
                }
                else{
                    $page = 1;
                }
                echo "
                        <a href='". $link . $page ."' class='btn btn-default' id='prev'>السابق</a>
                    ";
                if($_GET['page'] < $total_page){
                    $page = ($_GET['page'] + 1);
                    //echo "<a href='$link" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                }
                else{
                    $page = $total_page;
                    //echo "<a href='$link" . $total_page ."' class='btn btn-default' id='next'>التالي</a>";
                }
                echo "<a href='". $link . $page ."' class='btn btn-default' id='next'>التالي</a>";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    else if(isset($_GET['result']) && isset($_GET['cat_id'])){
        if($found == true){
            try{
                if($_GET['cat_id'] != 'all'){
                    $cat_id = $_GET['cat_id'];
                    $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id' AND product_id IN($id)");
                    $query->execute();
                    $link = "ads.php?result=$id&cat_id=$cat_id&page=";
                }
                else{
                    $query = $con->prepare("SELECT * FROM products where product_id IN($id)");
                    $query->execute();  
                    $link = "ads.php?result=$id&cat_id=all&page=";
                }
                $total_page = 0;
                $records = $query->rowCount();
                $total_page = ceil($records / $per_page);
                if($total_page != 0){
                    if($_GET['page'] != 1){
                        $page = ($_GET['page'] -1);
                    }
                    else{
                        $page = 1;
                    }
                    echo "
                            <a href='". $link . $page ."' class='btn btn-default' id='prev'>السابق</a>
                        ";
                    if($_GET['page'] < $total_page){
                        $page = ($_GET['page'] + 1);
                        //echo "<a href='$link" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                    }
                    else{
                        $page = $total_page;
                        //echo "<a href='$link" . $total_page ."' class='btn btn-default' id='next'>التالي</a>";
                    }
                    echo "<a href='". $link . $page ."' class='btn btn-default' id='next'>التالي</a>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
    else{
        try{
            if($id != ""){
                $query = $con->prepare("SELECT * FROM users where user_id IN($id)");
                $query->execute();
                $link = "users.php?result=$id&page=";
            }
            else{
                $query = $con->prepare("SELECT * FROM users");
                $query->execute();
                $link = "users.php?page=";
            }
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            if($total_page != 0){
                if($_GET['page'] != 1){
                    $page = ($_GET['page'] -1);
                }
                else{
                    $page = 1;
                }
                echo "
                        <a href='". $link . $page ."' class='btn btn-default' id='prev'>السابق</a>
                    ";
                if($_GET['page'] < $total_page){
                    $page = ($_GET['page'] + 1);
                    //echo "<a href='$link" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                }
                else{
                    $page = $total_page;
                    //echo "<a href='$link" . $total_page ."' class='btn btn-default' id='next'>التالي</a>";
                }
                echo "<a href='". $link . $page ."' class='btn btn-default' id='next'>التالي</a>";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
function pagantitionResult($per_page){
    // this function for get pages of ads by categories
    global $con;
    if(!isset($_GET['result'])){
        try{
            $link = "";
            if($_GET['cat_id'] != 'all'){
                $cat_id = $_GET['cat_id'];
                $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id'");
                $query->execute();
                $link = "ads.php?cat_id=$cat_id&page=";
            }
            else{
                $query = $con->prepare("SELECT * FROM products");
                $query->execute();  
                $link = "ads.php?cat_id=all&page=";
            }
            $total_page = 0;
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            if($total_page != 0){
                if($_GET['page'] != 1){
                    echo "
                        <a href='$link" . ($_GET['page'] -1)."' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                else{
                    echo "
                        <a href='$link" . '1' . "' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                if($_GET['page'] < $total_page){
                    echo "<a href='$link" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                }
                else{
                    echo "<a href='$link" . $total_page ."' class='btn btn-default' id='next'>التالي</a>";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    else if(isset($_GET['result'])){
        try{
            $link = "";
            if($_GET['cat_id'] != 'all'){
                $cat_id = $_GET['cat_id'];
                $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id'");
                $query->execute();
                $link = "ads.php?result&cat_id=$cat_id&page=";
            }
            else{
                $query = $con->prepare("SELECT * FROM products");
                $query->execute();  
                $link = "ads.php?cat_id=all&page=";
            }
            $total_page = 0;
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            if($total_page != 0){
                if($_GET['page'] != 1){
                    echo "
                        <a href='$link" . ($_GET['page'] -1)."' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                else{
                    echo "
                        <a href='$link" . '1' . "' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                if($_GET['page'] < $total_page){
                    echo "<a href='$link" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                }
                else{
                    echo "<a href='$link" . $total_page ."' class='btn btn-default' id='next'>التالي</a>";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    else{
        try{
            $query = $con->prepare("SELECT * FROM users");
            $query->execute();
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            if($total_page != 0){
                if($_GET['page'] != 1){
                    echo "
                        <a href='users.php?page=" . ($_GET['page'] -1)."' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                else{
                    echo "
                        <a href='users.php?page=1' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                    ";
                }
                if($_GET['page'] < $total_page){
                    echo "<a href='users.php?page=" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
                }
                else{
                    echo "<a href='users.php?page=$total_page' class='btn btn-default' id='next'>التالي</a>";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
/*
function pagantitionUsers($per_page){
    global $con;
    $query = $con->prepare("SELECT * FROM users");
    $query->execute();
    $records = $query->rowCount();
    $total_page = ceil($records / $per_page);
    if($total_page != 0){
        if($_GET['page'] != 1){
            echo "
                <a href='users.php?page=" . ($_GET['page'] -1)."' class='btn btn-default' id='prev' data-text='1'>السابق</a>
            ";
        }
        else{
            echo "
                <a href='users.php?page=1' class='btn btn-default' id='prev' data-text='1'>السابق</a>
            ";
        }
        if($_GET['page'] < $total_page){
            echo "<a href='users.php?page=" . ($_GET['page'] +1)."' class='btn btn-default' id='next'>التالي</a>";
        }
        else{
            echo "<a href='users.php?page=$total_page' class='btn btn-default' id='next'>التالي</a>";
        }
    }
}
*/

// time ago function
function timeAgo($datetime,$full=false){
    $now = new DateTime('NOW',new DateTimeZone('Asia/Damascus'));
    $ago = new DateTime($datetime,new DateTimeZone('Asia/Damascus'));
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'سنة',
        'm' => 'شهر',
        'w' => 'اسبوع',
        'd' => 'يوم',
        'h' => 'ساعة',
        'i' => 'دقيقة',
        's' => 'ثانية',
    
    );
    foreach($string as $k => &$v){
        if($diff->$k){
            $v = $diff->$k . ' ' . $v;
        }
        else{
            unset($string[$k]);
        }
    }
    if(!$full) $string = array_slice($string,0,1);
    if($string){
        $time = "منذ " . implode(',',$string);
    }
    else{
        $time = "الآن";
    }
    return $time;
}
?>