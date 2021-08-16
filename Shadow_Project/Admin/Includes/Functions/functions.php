<?php 
    // this function for get total of users,categories,products,orders
    function getTotal($table_name){
        // this function for get total of users,categories,products,orders
        global $con;
        try{
            $query              = $con->prepare("SELECT * FROM $table_name");
            $query->execute();
            $total              = $query->rowCount();
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        return $total;
    }
    function viewNewAds(){
        global $con;
        $query              = $con->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT 10");
        $query->execute();
        $ads_no = 1;
        
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            $user_id = $result['user_id'];
            $query2 = $con->prepare("SELECT user_email FROM users JOIN products ON users.user_id = '$user_id' LIMIT 0,1");
            $query2->execute();
            $result2 = $query2->fetch(PDO::FETCH_ASSOC);
            $user_email = $result2['user_email'];

            $p_cat_id   = $result['p_cat_id'];

            $query2 = $con->prepare("SELECT cat_title FROM categories JOIN products ON categories.cat_id = '$p_cat_id' LIMIT 0,1");
            $query2->execute();
            $result2 = $query2->fetch(PDO::FETCH_ASSOC);
            $cat_title   = $result2['cat_title'];

            $product_id     = $result['product_id'];
            $product_title     = $result['product_title'];
            $product_location     = $result['product_location'];
            $product_price       = $result['product_price'];
            $product_currency       = $result['product_currency'];
            
            
            echo "
                <tbody align='center'>
                    <tr>
                        <td>$ads_no</td>
                        <td>$product_id</td>
                        <td>$user_email</td>
                        <td>$product_title</td>
                        <td>$product_price$product_currency</td>
                        <td>$product_location</td>
                        <td>$cat_title</td>
                    </tr>
                </tbody>
            
            ";
            $ads_no++;


        }
    }
    function viewAds($per_page){
        // get all ads from new one to the oldest one
        global $con;

        try{
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }
            $start = ($page - 1) * $per_page;
            $number = $start;
            $query = $con->prepare("SELECT * FROM Products ORDER BY 1 DESC LIMIT $start,$per_page");
            $query->execute();
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $product_id       = $result['product_id'];
                $p_cat_id       = $result['p_cat_id'];
                $user_id          = $result['user_id'];
                $product_name     = $result['product_title'];
                $product_image    = explode(",",$result['product_images']);
                $product_price    = $result['product_price'];
                $product_currency    = $result['product_currency'];
                $number++;
                
                $query2 = $con->prepare("SELECT username,user_email FROM users JOIN products ON users.user_id = '$user_id' LIMIT 0,1");
                $query2->execute();
                $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                $user_email = $result2['user_email'];
                $user_name = $result2['username'];
    
                $query2 = $con->prepare("SELECT cat_title FROM categories JOIN products ON categories.cat_id = '$p_cat_id' LIMIT 0,1");
                $query2->execute();
                $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                $cat_title   = $result2['cat_title'];
                echo "
                        <tr>
                            <td>$number</td>
                            <td>$user_name</td>
                            <td>$user_email</td>
                            <td>$product_name</td>
                            <td><img class='img-responsive' src='../Layout/Images/ads-images/$product_image[0]' alt='$product_image[0]' width='60px' height='40px'></td>
                            <td>$product_price$product_currency</td>
                            <td>$cat_title</td>
                            <td><a href='index.php?view_ads&page=$page&ads_id=$product_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>حذف</button></a></td>
                        </tr>
                ";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewUsers($per_page){
        global $con;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
            
        }
        $start = ($page - 1) * $per_page;
        $number = $start ;
        try{
            $query = $con->prepare("SELECT * FROM users order by 1 DESC LIMIT $start,$per_page");
            $query->execute();
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $user_id        = $result['user_id'];
                $user_name      = $result['username'];
                $user_email     = $result['user_email'];
                $user_gender    = $result['user_gender'];
                $user_location  = $result['user_location'];
                $last_login     = $result['last_login'];
                $account_date     = $result['create_account'];
                $number++;
                $status = "غير متصل";
                $class  = "danger";
                if($last_login > time()){
                    $status = "متصل";
                    $class  = "success";
                }
                $user_status = "حظر";
                if($result['status'] =="panned"){
                    $user_status = "فك الحظر";
                }                
                echo "
                        <tr>
                            <td>$number</td>
                            <td>$user_name</td>
                            <td>$user_email</td>
                            <td>$user_gender</td>
                            <td>$user_location</td>
                            <td>$account_date</td>
                            <td><a><button class='btn btn-$class btn-block'>$status</button></a></td>
                            <td><a href='index.php?view_users&user_id=$user_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>$user_status</button></a></td>
                        </tr>
                ";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewCategories($per_page){
        global $con;
        try{
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }
            $start = ($page - 1) * $per_page;
            $number = $start;
            $query = $con->prepare("SELECT * FROM categories ORDER BY 1 ASC LIMIT $start,$per_page");
            $query->execute();
            $record = $query->rowCount();
            if($record > 0){
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $cat_id        = $result['cat_id'];
                    $cat_icon      = $result['cat_icon'];
                    $cat_title     = $result['cat_title'];
                    $cat_desc      = $result['cat_desc'];
                    $cat_keywords  = $result['cat_keywords'];
                    $number++;
                    echo "
                            <tr>
                                <td>$number</td>
                                <td>$cat_title</td>
                                <td><img class='img-responsive' src='../Layout/Images/icons/$cat_icon' alt='$cat_icon' width='50px' height='50px'></td>
                                <td>$cat_desc</td>
                                <td>$cat_keywords</td>
                                <td><a href='index.php?edit_cat&cat_id=$cat_id'><button type='submit' name='delete' class='btn btn-primary btn-block'>تعديل</button></a></td>
                                <td><a href='index.php?view_cats&cat_id=$cat_id'><button class='btn btn-danger btn-block'>حذف</button></a></td>
                            </tr>
                    ";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewServices($per_page){
        // get all ads from new one to the oldest one
        global $con;

        try{
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }
            $start = ($page - 1) * $per_page;
            $query = $con->prepare("SELECT * FROM services ORDER BY 1 LIMIT $start,$per_page");
            $query->execute();
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $service_id       = $result['service_id'];
                $service_icon     = $result['service_icon'];
                $service_title    = $result['service_title'];
                $service_desc     = $result['service_desc'];

                echo "
                        <tr>
                            <td>$service_id</td>
                            <td><img class='img-responsive' src='../Layout/Images/icons/$service_icon' alt='$service_icon' width='50px' height='50px'></td>
                            <td>$service_title</td>
                            <td>$service_desc</td>
                            <td><a href='index.php?edit_service&service_id=$service_id'><button type='submit' name='edit' class='btn btn-primary btn-block'>تعديل</button></a></td>
                            <td><a href='index.php?view_services&service_id=$service_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>حذف</button></a></td>
                        </tr>
                ";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewSearch($search,$table,$per_page,$type_id){
        global $con;

        try{
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }
            $start = ($page - 1) * $per_page;
            $number = $start;
            $query = $con->prepare("SELECT * FROM $table where $type_id IN($search) ORDER BY 1  DESC LIMIT $start,$per_page");
            $query->execute();
            if($table == "products"){
                
                
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $product_id       = $result['product_id'];
                    $p_cat_id       = $result['p_cat_id'];
                    $user_id          = $result['user_id'];
                    $product_name     = $result['product_title'];
                    $product_image    = explode(",",$result['product_images']);
                    $product_price    = $result['product_price'];
                    $product_currency    = $result['product_currency'];
                    $number++;
                    
                    $query2 = $con->prepare("SELECT username,user_email FROM users JOIN products ON users.user_id = '$user_id' LIMIT 0,1");
                    $query2->execute();
                    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                    $user_email = $result2['user_email'];
                    $user_name = $result2['username'];
        
                    $query2 = $con->prepare("SELECT cat_title FROM categories JOIN products ON categories.cat_id = '$p_cat_id' LIMIT 0,1");
                    $query2->execute();
                    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                    $cat_title   = $result2['cat_title'];
                    echo "
                            <tr>
                                <td>$number</td>
                                <td>$user_name</td>
                                <td>$user_email</td>
                                <td>$product_name</td>
                                <td><img class='img-responsive' src='../Layout/Images/ads-images/$product_image[0]' alt='$product_image[0]' width='60px' height='40px'></td>
                                <td>$product_price$product_currency</td>
                                <td>$cat_title</td>
                                <td><a href='index.php?view_ads&page=$page&ads_id=$product_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>حذف</button></a></td>
                            </tr>
                    ";
                }
            }
            else if($table == "users"){
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $user_id        = $result['user_id'];
                    $user_name      = $result['username'];
                    $user_email     = $result['user_email'];
                    $user_gender    = $result['user_gender'];
                    $user_location  = $result['user_location'];
                    $last_login     = $result['last_login'];
                    $account_date     = $result['create_account'];
                    $number++;
                    $status = "غير متصل";
                    $class  = "danger";
                    if($last_login > time()){
                        $status = "متصل";
                        $class  = "success";
                    }
                    $user_status = "حظر";
                    if($result['status'] =="panned"){
                        $user_status = "فك الحظر";
                    }
                    echo "
                            <tr>
                                <td>$number</td>
                                <td>$user_name</td>
                                <td>$user_email</td>
                                <td>$user_gender</td>
                                <td>$user_location</td>
                                <td>$account_date</td>
                                <td><a><button class='btn btn-$class btn-block'>$status</button></a></td>
                                <td><a href='index.php?view_users&user_id=$user_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>$user_status</button></a></td>
                            </tr>
                    ";
                }
            }
            else if($table == "categories"){
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $cat_id        = $result['cat_id'];
                    $cat_icon      = $result['cat_icon'];
                    $cat_title     = $result['cat_title'];
                    $cat_desc      = $result['cat_desc'];
                    $cat_keywords  = $result['cat_keywords'];

                    $number++;
                    echo "
                            <tr>
                                <td>$number</td>
                                <td>$cat_title</td>
                                <td><img class='img-responsive' src='../Layout/Images/icons/$cat_icon' alt='$cat_icon' width='50px' height='50px'></td>
                                <td>$cat_desc</td>
                                <td>$cat_keywords</td>
                                <td><a href='index.php?edit_cat&cat_id=$cat_id'><button type='submit' name='delete' class='btn btn-primary btn-block'>تعديل</button></a></td>
                                <td><a href='index.php?view_cats&cat_id=$cat_id'><button class='btn btn-danger btn-block'>حذف</button></a></td>
                            </tr>
                    ";
                }
            }
            else if($table == "services"){
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $service_id       = $result['service_id'];
                    $service_icon     = $result['service_icon'];
                    $service_title    = $result['service_title'];
                    $service_desc     = $result['service_desc'];
                    $number++;
                    echo "
                            <tr>
                                <td>$number</td>
                                <td><img class='img-responsive' src='../Layout/Images/icons/$service_icon' alt='$service_icon' width='50px' height='50px'></td>
                                <td>$service_title</td>
                                <td>$service_desc</td>
                                <td><a href='index.php?edit_service&service_id=$service_id'><button type='submit' name='edit' class='btn btn-primary btn-block'>تعديل</button></a></td>
                            <td><a href='index.php?view_services&service_id=$service_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>حذف</button></a></td>
                            </tr>
                    ";
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewAdmins($per_page){
        global $con;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
            
        }
        $start = ($page - 1) * $per_page;
        $number = $start ;
        $admins_level = $_SESSION['admin_level'];
        try{
            $query = $con->prepare("SELECT * FROM admins");
        $query->execute();
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $admin_id        = $result['admin_id'];
                $admin_name      = $result['admin_name'];
                $admin_email     = $result['admin_email'];
                $admin_gender    = $result['admin_gender'];
                $admin_location  = $result['admin_location'];
                $admin_level     = $result['admin_level'];
                $number++;
                if($admins_level < 3){
                    echo "
                        <tr>
                            <td>$number</td>
                            <td>$admin_name</td>
                            <td>$admin_email</td>
                            <td>$admin_gender</td>
                            <td>$admin_location</td>
                            ";
                    if($admin_level == 1){
                        $status = "مدير";
                        $link = "#";
                        $edit_link = "#";
                        $edit = "غير مسموح";
                        $content = "غير مسموح";
                    }
                    else if($admin_level == 2){
                        $status = "مشرف";
                        if($_SESSION['admin_email'] == $admin_email){
                            $content = "غير مسموح";
                            $link = "#";
                            $edit = "غير مسموح";
                            $edit_link = "#";
                        }
                        else{
                            $link = "index.php?view_admins&admin_id=$admin_id";
                            $edit_link = "index.php?edit_admin&admin_id=$admin_id";
                            $content = "حذف";
                            $edit = "تعديل";
                        }
                    }
                    else{
                        $status = "محرر";
                        $link = "index.php?view_admins&admin_id=$admin_id";
                        $edit_link = "index.php?edit_admin&admin_id=$admin_id";
                        $content = "حذف";
                        $edit = "تعديل";
                    }
                    echo "  <td>$status</td>
                            <td><a href='$edit_link'><button type='submit' name='delete' class='btn btn-primary btn-block'>$edit</button></a></td>
                            <td><a href='$link'><button type='submit' name='delete' class='btn btn-danger btn-block'>$content</button></a></td>
                            </tr>
                            ";
                }
                else{
                    $status = "محرر";
                    if($admin_level == 1){
                        $status = "مدير";
                    }
                    else if($admin_level == 2){
                        $status = "مشرف";
                    }
                    echo "<tr>
                        <td>$number</td>
                        <td>$admin_name</td>
                        <td>$admin_email</td>
                        <td>$admin_gender</td>
                        <td>$admin_location</td>
                        <td>$status</td>
                    </tr>
                    ";
                }
                
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function viewSearchProductCategories($search){
        global $con;
        $query = $con->prepare("SELECT * FROM product_categories where p_cat_name = '$search'");
        $query->execute();
        while($get_p_cat = $query->fetch(PDO::FETCH_ASSOC)){
            $p_cat_id       = $get_p_cat['p_cat_id'];
            $p_cat_name     = $get_p_cat['p_cat_name'];
            $p_cat_desc     = $get_p_cat['p_cat_desc'];
            echo "
                    <tr>
                        <td>$p_cat_id</td>
                        <td>$p_cat_name</td>
                        <td>$p_cat_desc</td>
                        <td><a href='index.php?view_p_cats&p_cat_id=$p_cat_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                        <td><a href='index.php?edit_p_cat=$p_cat_id'><button class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a></td>
                    </tr>
            ";
        }
    }
    function veiwSlides(){
        global $con;
        $query = $con->prepare("SELECT * FROM slider");
        $query->execute();
            while($get_slide = $query->fetch(PDO::FETCH_ASSOC)){
                $slide_id       = $get_slide['slide_id'];
                $slide_name     = $get_slide['slide_name'];
                $slide_image     = $get_slide['slide_image'];
                echo "
                        <tr>
                            <td>$slide_id</td>
                            <td>$slide_name</td>
                            <td><img class='img-responsive' src='Layout/images/main_slider/$slide_image' alt='$slide_image' width='80px' height='60px'></td>
                            <td><a href='index.php?view_slides&slide_id=$slide_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                            <td><a href='index.php?edit_slide=$slide_id'><button class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a></td>
                        </tr>
                ";
            }
    }
    function viewSearchSlides($search){
        global $con;
        $query = $con->prepare("SELECT * FROM slider where slide_name = '$search'");
        $query->execute();
        $record = $query->rowCount();
        if($record > 0){
            while($get_slide = $query->fetch(PDO::FETCH_ASSOC)){
                $slide_id       = $get_slide['slide_id'];
                $slide_name     = $get_slide['slide_name'];
                $slide_image     = $get_slide['slide_image'];
                echo "
                        <tr>
                            <td>$slide_id</td>
                            <td>$slide_name</td>
                            <td><img class='img-responsive' src='Layout/images/main_slider/$slide_image' alt='$slide_image' width='80px' height='60px'></td>
                            <td><a href='index.php?view_slides&slide_id=$slide_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                            <td><a href='index.php?edit_slide=$slide_id'><button class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a></td>
                        </tr>
                ";
            }
        }
    }
    function viewBoxes(){
        global $con;
        $query = $con->prepare("SELECT * FROM boxes");
                $query->execute();
                while($get_box = $query->fetch(PDO::FETCH_ASSOC)){
                    $box_id    = $get_box['box_id'];
                    $box_title = $get_box['box_title'];
                    $box_desc  = $get_box['box_desc'];

                    echo "
                        <div class='section-box col-lg-4 col-md-6'>
                            <h5 class='header'>$box_title</h5>
                            <p>$box_desc</p>
                            <div>
                                <a href='index.php?edit_boxes=$box_id' class='pull-left'><button type='submit' name='delete' class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a>
                                <a href='index.php?view_boxes&box_id=$box_id' class='pull-right'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Remove</button></a>
                            </div>
                        </div>
                    ";
                }
    }

    function viewSearchUsers($search){
        global $con;
        $query = $con->prepare("SELECT * FROM users where user_name = '$search'");
        $query->execute();
            while($get_user = $query->fetch(PDO::FETCH_ASSOC)){
                $user_id        = $get_user['user_id'];
                $user_name      = $get_user['user_name'];
                $user_image     = $get_user['user_image'];
                $user_email     = $get_user['user_email'];
                $user_birth     = $get_user['user_birth'];
                $user_gender    = $get_user['user_gender'];
                $user_country   = $get_user['user_country'];
                $user_city      = $get_user['user_city'];
                echo "
                        <tr>
                            <td>$user_id</td>
                            <td>$user_name</td>
                            <td><img class='img-responsive' src='../Users/Layout/images/users-image/$user_image' alt='$user_image' width='80px' height='60px'></td>
                            <td>$user_email</td>
                            <td>$user_birth</td>
                            <td>$user_gender</td>
                            <td>$user_country</td>
                            <td>$user_city</td>
                            <td><a href='index.php?view_users&user_id=$user_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                        </tr>
                ";
            }
    }
    function viewOrders(){
        global $con;
        $query              = $con->prepare("SELECT * FROM pending_orders");
        $query->execute();
        while($get_order = $query->fetch(PDO::FETCH_ASSOC)){
            $user_id = $get_order['user_id'];

            $user_query     = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
            $user_query->execute();
            $get_user       = $user_query->fetch(PDO::FETCH_ASSOC);
            $user_email     = $get_user['user_email'];

            $order_id       = $get_order['order_id'];
            $product_id     = $get_order['product_id'];
            $invoice_no     = $get_order['invoice_no'];
            $quantity       = $get_order['quantity'];
            $order_status   = $get_order['order_status'];
            
            echo "
                <tbody align='center'>
                    <tr>
                        <td>$order_id</td>
                        <td>$user_email</td>
                        <td>$invoice_no</td>
                        <td>$product_id</td>
                        <td>$quantity</td>
                        <td>$order_status</td>
                        <td><a href='index.php?view_orders&order_id=$order_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                    </tr>
                </tbody>
            
            ";


        }
    }
    function viewSearchOrders($search){
        global $con;
        $query              = $con->prepare("SELECT * FROM pending_orders where invoice_no = '$search' OR order_status = '$search'");
        $query->execute();
        while($get_order = $query->fetch(PDO::FETCH_ASSOC)){
            $user_id = $get_order['user_id'];

            $user_query     = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
            $user_query->execute();
            $get_user       = $user_query->fetch(PDO::FETCH_ASSOC);
            $user_email     = $get_user['user_email'];

            $order_id       = $get_order['order_id'];
            $product_id     = $get_order['product_id'];
            $invoice_no     = $get_order['invoice_no'];
            $quantity       = $get_order['quantity'];
            $order_status   = $get_order['order_status'];
            
            echo "
                <tbody align='center'>
                    <tr>
                        <td>$order_id</td>
                        <td>$user_email</td>
                        <td>$invoice_no</td>
                        <td>$product_id</td>
                        <td>$quantity</td>
                        <td>$order_status</td>
                        <td><a href='index.php?view_orders&order_id=$order_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                    </tr>
                </tbody>
            
            ";


        }
    }
    function viewPayments(){
        global $con;
        $query              = $con->prepare("SELECT * FROM payments");
        $query->execute();
        while($get_payment = $query->fetch(PDO::FETCH_ASSOC)){
            $payment_id         = $get_payment['payment_id'];
            $invoice_no         = $get_payment['invoice_no'];
            $amount             = $get_payment['amount'];
            $payment_method     = $get_payment['payment_method'];
            $ref_no             = $get_payment['ref_no'];
            $payment_code       = $get_payment['payment_code'];
            $payment_date       = $get_payment['payment_date'];
            
            echo "
                <tbody align='center'>
                    <tr>
                        <td>$payment_id</td>
                        <td>$invoice_no</td>
                        <td>$$amount</td>
                        <td>$payment_method</td>
                        <td>$ref_no</td>
                        <td>$payment_code</td>
                        <td>$payment_date</td>
                        <td><a href='index.php?view_payments&payment_id=$payment_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                    </tr>
                </tbody>
            
            ";
        }
    }
    function viewSearchPayments($search){
        global $con;
        $query              = $con->prepare("SELECT * FROM payments where invoice_no = '$search' OR
                                                                        amount = '$search' OR
                                                                        payment_method = '$search' OR
                                                                        ref_no = '$search' OR
                                                                        payment_code = '$search' OR
                                                                        payment_date = '$search'");
        $query->execute();
        while($get_payment = $query->fetch(PDO::FETCH_ASSOC)){
            $payment_id         = $get_payment['payment_id'];
            $invoice_no         = $get_payment['invoice_no'];
            $amount             = $get_payment['amount'];
            $payment_method     = $get_payment['payment_method'];
            $ref_no             = $get_payment['ref_no'];
            $payment_code       = $get_payment['payment_code'];
            $payment_date       = $get_payment['payment_date'];
            
            echo "
                <tbody align='center'>
                    <tr>
                        <td>$payment_id</td>
                        <td>$invoice_no</td>
                        <td>$$amount</td>
                        <td>$payment_method</td>
                        <td>$ref_no</td>
                        <td>$payment_code</td>
                        <td>$payment_date</td>
                        <td><a href='index.php?view_payments&payment_id=$payment_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                    </tr>
                </tbody>
            
            ";
        }
    }
    function viewSearchAdmins($search){
        global $con;
        $admins_level = $_SESSION['admin_level'];
        $query = $con->prepare("SELECT * FROM admins where admin_name = '$search'");
        $query->execute();
            while($get_admin = $query->fetch(PDO::FETCH_ASSOC)){
                $admin_id        = $get_admin['admin_id'];
                $admin_name      = $get_admin['admin_name'];
                $admin_image     = $get_admin['admin_image'];
                $admin_email     = $get_admin['admin_email'];
                $admin_birth     = $get_admin['admin_birth'];
                $admin_gender    = $get_admin['admin_gender'];
                $admin_country   = $get_admin['admin_country'];
                $admin_city      = $get_admin['admin_city'];
                $admin_level      = $get_admin['admin_level'];
                if($admins_level != 1 || $admin_id == 1){
                    echo "
                        <tr>
                            <td>$admin_id</td>
                            <td>$admin_name</td>
                            <td><img class='img-responsive' src='Layout/images/admins-images/$admin_image' alt='$admin_image' width='80px' height='60px'></td>
                            <td>$admin_email</td>
                            <td>$admin_birth</td>
                            <td>$admin_gender</td>
                            <td>$admin_country</td>
                            <td>$admin_city</td>
                            <td>$admin_level</td>
                            <td><a href='index.php?view_admins'><button type='submit' name='delete' class='btn btn-danger btn-block'>Not Allow</button></a></td>
                        </tr>
                    ";
                }
                else{
                    echo "
                        <tr>
                            <td>$admin_id</td>
                            <td>$admin_name</td>
                            <td><img class='img-responsive' src='Layout/images/admins-images/$admin_image' alt='$admin_image' width='80px' height='60px'></td>
                            <td>$admin_email</td>
                            <td>$admin_birth</td>
                            <td>$admin_gender</td>
                            <td>$admin_country</td>
                            <td>$admin_city</td>
                            <td>$admin_level</td>
                            <td><a href='index.php?view_admins&admin_id=$admin_id'><button type='submit' name='delete' class='btn btn-danger btn-block'><i class='fa fa-trash-o'></i> Delete</button></a></td>
                        </tr>
                    ";
                }
            }
    }
    function viewAdminsLevel(){
        global $con;
        $query = $con->prepare("SELECT * FROM admins");
        $query->execute();
            while($get_admin = $query->fetch(PDO::FETCH_ASSOC)){
                $admin_id        = $get_admin['admin_id'];
                $admin_name      = $get_admin['admin_name'];
                $admin_image     = $get_admin['admin_image'];
                $admin_email     = $get_admin['admin_email'];
                $admin_birth     = $get_admin['admin_birth'];
                $admin_gender    = $get_admin['admin_gender'];
                $admin_country   = $get_admin['admin_country'];
                $admin_city      = $get_admin['admin_city'];
                $admin_level      = $get_admin['admin_level'];
                if($admin_id == 1){
                    echo "
                        <tr>
                            <td>$admin_id</td>
                            <td>$admin_name</td>
                            <td><img class='img-responsive' src='Layout/images/admins-images/$admin_image' alt='$admin_image' width='80px' height='60px'></td>
                            <td>$admin_email</td>
                            <td>$admin_birth</td>
                            <td>$admin_gender</td>
                            <td>$admin_level</td>
                            <td><a href='index.php?admin_id=$admin_id'><button type='submit' name='edit' class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a></td>
                        </tr>
                    ";
                }
                else{
                    echo "
                        <tr>
                            <td>$admin_id</td>
                            <td>$admin_name</td>
                            <td><img class='img-responsive' src='Layout/images/admins-images/$admin_image' alt='$admin_image' width='80px' height='60px'></td>
                            <td>$admin_email</td>
                            <td>$admin_birth</td>
                            <td>$admin_gender</td>
                            <td>$admin_level</td>
                            <td><a href='index.php?admin_id=$admin_id'><button type='submit' name='edit' class='btn btn-primary btn-block'><i class='fa fa-edit'></i> Edit</button></a></td>
                        </tr>
                    ";
                }
            }
    }
    function pagantition($per_page,$table,$url,$type_id){
        global $con;
        $total_page = 0;
        $searching = "";
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $query = $con->prepare("SELECT * FROM $table where $type_id IN ($search) ");
            $query->execute();
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
            $searching = "&search=".$search;
        }
        else{
            $query = $con->prepare("SELECT * FROM $table");
            $query->execute();
            $records = $query->rowCount();
            $total_page = ceil($records / $per_page);
        }
        if($total_page != 1){
            if($_GET['page'] != 1){
                $page = $_GET['page'] - 1;
            }
            else{
                $page = 1;
            }
            echo "
                    <a href='index.php?$url&page=$page$searching' class='btn btn-default' id='prev' data-text='1'>السابق</a>
                ";
            if($_GET['page'] < $total_page){
                $page = $_GET['page'] +1;
            }
            else{
                $page = $total_page;
            }
            echo "<a href='index.php?$url&page=$page$searching' class='btn btn-default' id='next'>التالي</a>";
        }
    }
?>