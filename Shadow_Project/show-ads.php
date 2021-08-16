<?php 
    include 'Includes/Components/header.php'; 
        // get ads by his product id
        if(isset($_GET['p_id'])){
            try{
                $p_id = $_GET['p_id'];
                $query = $con->prepare("SELECT * FROM products WHERE product_id = '$p_id'");
                $query->execute();
                if($query->rowCount() > 0){
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $p_cat_id           = $result['p_cat_id'];
                    $user_id            = $result['user_id'];
                    $product_title      = $result['product_title'];
                    $product_price      = $result['product_price'];
                    $product_currency   = $result['product_currency'];
                    $product_location   = $result['product_location'];
                    $product_desc2      = $result['product_desc2']; 
                    $product_date       = $result['product_date'];
                    $product_watch      = $result['product_watch'];
                    $product_status     = $result['product_status'];
                    $product_watch++;

                    //$dt = date('h:',strtotime('D',$product_date));
                    // check if description have links
                    //echo $product_date;
                    $date = timeAgo($product_date);
                    // query for update total watch of product every click or reload this page of product
                    $query = "UPDATE products SET product_watch = '$product_watch' where product_id = '$p_id'";
                    $con->exec($query);
                    if($result['product_images'] != ""){
                        $product_images     = explode(",",$result['product_images']);
                    }
                    else{
                        $product_images = "";
                    }
                    // get user name by user user_id
                    $query   = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
                    $query->execute();
                    $result        = $query->fetch(PDO::FETCH_ASSOC);
                    $user_name      = $result['username'];
                    $user_location  = $result['user_location'];
                    $user_image     = $result['user_image'];
                    $last_login     = $result['last_login'];

                    // for check user status if online or offline
                    $class='offline';
                    $status = 'غير متصل';
                    if($last_login > time()){
                        $class = 'online';
                        $status = 'متصل';
                    }
                    //echo $product_date;
                    // get category name by  p_cat_id
                    $query      = $con->prepare("SELECT * FROM categories where cat_id = '$p_cat_id'");
                    $query->execute();
                    $result     = $query->fetch(PDO::FETCH_ASSOC);
                    $cat_title  = $result['cat_title'];
                    // this code for delete all notify we have in this chat
                    if(isset($_GET['open_chat'])){
                        $user_email = "";
                        if(isset($_COOKIE['user_login'])){
                            $user_email = $_COOKIE['user_login'];
                        }
                        else if(isset($_SESSION['user_email'])){
                            $user_email = $_SESSION['user_email'];
                        }
                        try{
                            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
                            $query->execute();
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            $user2_id = $result['user_id'];
                            $query = $con->prepare("UPDATE chat SET notification_numbers = '0' where user1_id = '$user_id' AND user2_id = '$user2_id'");
                            $query->execute();
                        }
                        catch(PDOException $e){
                            echo $e->getMessage();
                        }
                    }     
        
                }
                else{
                    //header("Location:ads.php?cat_id=all&page=1");
                    echo "<script>window.open('ads.php?cat_id=all&page=1','_self')</script>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        else{
            //header("Location:ads.php?cat_id=all&page=1");
            echo "<script>window.open('ads.php?cat_id=all&page=1','_self')</script>";
        }
?>
    <!-- show-ads Box Started -->
    <?php 
        /*
            this code for open chat page 
            if url have open_chat then 
                if user who open chat have account in our website then open chat page
                else dont open it
        */
        if(isset($_GET['open_chat'])){
            if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])){
                if(isset($_COOKIE['user_login'])){
                    $user_email = $_COOKIE['user_login'];
                }
                else if(isset($_SESSION['user_email'])){
                    $user_email = $_SESSION['user_email'];
                }
                $query = $con->prepare("SELECT user_id from users where user_email = '$user_email'");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $user1_id = $result['user_id'];
                if($user1_id != $_GET['open_chat']){
                    $query = $con->prepare("SELECT * FROM chat_session where user1_id = '$user1_id' AND user2_id = '$user_id'");
                    $query->execute();
                    if($query->rowCount() == 0){
                        $chat_status = "online";
                        $query = $con->prepare("INSERT INTO chat_session (user1_id,user2_id,chat_status) VALUES ('$user1_id','$user_id','$chat_status')");
                        $query->execute();
                    }
                    include "Includes/Components/chat.php";
                }
                else{
                    $content = "لايمكن فتح محادثة مع نفسك";
                    $error_class = "notify-error";
                    $class = "fa-exclamation-circle";
                    include "Includes/Components/notification.php";
                    echo "
                    <script>
                        var notify = document.getElementById('notify');
                        notify.classList.add('show');
                        setTimeout(function(){
                            notify.classList.remove('show');
                            window.open('show-ads.php?p_id=$p_id','_self');
                        },3000);
                    </script>";
                }
            }
            else{
                $content = "يجب انشاء حساب لتتمكن من مراسلة المعلن";
                $error_class = "notify-error";
                $class = "fa-exclamation-circle";
                include "Includes/Components/notification.php";
                echo "
                    <script>
                        var notify = document.getElementById('notify');
                        notify.classList.add('show');
                        setTimeout(function(){
                            notify.classList.remove('show');
                            window.open('show-ads.php?p_id=$p_id','_self');
                        },3000);
                    </script>";
            }
        }
    ?>
    <!-- Start Show-ads Box -->
    <div class="show-ads" id="page-wrapper">
        <div class="title row">
            <div class="col-3 col-sm-2 col-md-1 user-img">
                
                <div class="img-box" <?php if($user_image != "") echo 'style=background-color:transparent';?>>
                    <?php 
                        /*
                        * for image if user have image then put it into image box
                        * else put first char of username into image box
                        */
                        echo "<a href='Profile/user-profile.php?user_id=$user_id'>";
                        if($user_image != ""){
                            echo "<img src='Profile/Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
                        }
                        else{
                            preg_match("/./u",$user_name,$first_char);
                            $first_char = strtoupper($first_char[0]);
                            echo "<span>$first_char</span>";
                        }
                        echo "<div class='user-connection $class'></div>";
                    ?>
                    </a> 
                </div>                                       
            </div>            
            <div class="col-9 col-sm-10 col-md-11 product-title">
                <div class="username">
                    <a href="Profile/user-profile.php?user_id=<?php echo $user_id; ?>"><h5><?php echo $user_name; ?></h5></a>
                    <div class="user-info">
                        <span><i class='fa fa-map-marker'></i> <?php echo $user_location; ?></span> 
                        <span><i class='fa fa-clock-o'></i> <?php echo  $date; ?></span> 
                        <span><i class="fa fa-eye"></i> شاهده [<?php echo $product_watch;?>]</span>
                    </div>
                    <p><?php echo $product_title; ?></p>
                </div>
                
            </div>

        </div>
        <div class="container-fluid">
            <div class="content">
                
                <div class="row">
                    <?php 
                        if(!isset($_SESSION['user_email']) || !isset($_COOKIE['user_login'])){
                            echo "
                                <div class='alert alert-primary' style='width:100%;margin-left:15px'>
                                    <p style='margin-bottom:0'>لامكانية التواصل مع المعلن عبر موقعنا يجب انشاء حساب او تسجيل دخول الى الموقع</p>
                                </div>";
                        }
                    ?>
                    <div class="col-md-8">
                        <div class="ads-info">
                            <h5>شرح الإعلان</h5>
                            <p><?php echo $product_desc2; ?></p>
                        </div>
                        <?php 
                            if($product_images != ""){
                                echo '<div class="ads-images">
                                <h5>صور الإعلان</h5>
                                <!-- Swiper -->
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">';
                                            for($i = 0;$i < count($product_images);$i++){
                                                echo "
                                                    <div class='swiper-slide'>
                                                        <img src='Layout/Images/products/$product_images[$i]' alt='$product_images[$i]' id='myimage'>
                                                    </div>
                                                    ";
                                            }
                                echo '</div>
                                    <!-- Add Pagination -->
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>';
                            }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                            if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])){
                                $product_id = $_GET['p_id'];
                                $query = $con->prepare("SELECT user_id FROM products where product_id = '$product_id'");
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                $user_id = $result['user_id'];

                                if(isset($_COOKIE['user_login'])){
                                    $user_email = $_COOKIE['user_login'];
                                }
                                else if(isset($_SESSION['user_email'])){
                                    $user_email = $_SESSION['user_email'];
                                }    
                                $query2 = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
                                $query2->execute();
                                $result2 = $query2->fetch(PDO::FETCH_ASSOC);
                                if($result2['user_id'] == $user_id){
                                    echo "
                                            <a href='edit-ads.php?p_id=$product_id' class='btn btn-success btn-block' style='margin-bottom:10px;'>تعديل الإعلان</a>
                                            <a href='show-ads.php?p_id=$product_id&delete_ads=$product_id' class='btn btn-danger btn-block' style='margin-bottom:10px;'>حذف الإعلان</a>
                                        ";
                                }
                            }
                        ?>
                        <div class="other-info">
                            <h5>معلومات اضافية</h5>
                            <table class="table">
                                <tr>
                                    <th>سعر المنتج</th>
                                    <td><?php echo $product_price . $product_currency;?></td>
                                </tr>
                                <tr>
                                    <th>الموقع</th>
                                    <td><?php echo $product_location; ?></td>
                                </tr>
                                <tr>
                                    <th>القسم</th>
                                    <td><?php echo $cat_title; ?></td>
                                </tr>
                                <tr>
                                    <th>الحالة</th>
                                    <td><?php echo $product_status; ?></td>
                                </tr>
                            </table>
                            <?php 
                                $query = $con->prepare("SELECT user_number FROM users where user_id = '$user_id'");
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                if($result['user_number'] != "0"){
                                    $user_number = $result['user_number'] ;
                                    echo "<a href='https://wa.me/$user_number' class='btn btn-success btn-block'><i class='fa fa-whatsapp'></i> واتساب</a>";
                                }
                            
                            ?> 
                            <a href="show-ads.php?p_id=<?php echo $p_id;?>&open_chat=<?php echo $user_id ?>" class="btn btn-primary btn-block"><i class="fa fa-commenting-o" aria-hidden="true"></i> محادثة عبر الموقع</a>
                        </div>
                        <div class="share">
                            <h5>شارك الإعلان</h5>
                            <ul>
                                <?php 
                                    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                                    $text = $product_title;
                                ?>
                                <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://wa.me/?text=<?php echo $text . " " . $url; ?>" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                <li><a href="https://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo $text; ?>" target="_blank"><i class="fa fa-twitter" target="_blank"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo $text; ?>" target="_blank"><i class="fa fa-linkedin" target="_blank"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php 
                    $content = "تم حذف الاعلان بنجاح";
                    $class = "fa-check-circle";
                    
                    include "Includes/Components/notification.php";
                ?>
            </div>
        </div>
    </div>
    <div id="myresult">

    </div>
    <!-- Finished Show-ads Box -->
    <?php
        // this script for delete ads by use his product_id
        if(isset($_GET['delete_ads'])){
            $product_id = $_GET['delete_ads'];
            try{
                $query = "DELETE FROM products where product_id = '$product_id'";
                $con->exec($query);
                $query = "ALTER TABLE products AUTO_INCREMENT = 1";
                $con->exec($query);
                echo "
                        <script>
                            var notify = document.getElementById('notify');
                            notify.classList.add('show');
                            setTimeout(function(){
                                notify.classList.remove('show');
                                window.open('ads.php?cat_id=all&page=1','_self');
                            },2000);
                        </script>";
                    
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    ?>
    <!-- show-ads Box Finished -->
    <?php include 'Includes/Components/footer.php'; 
            if(isset($_GET['open_chat'])){
                echo "<script src='Layout/Js/chat.js'></script>
                        <script src='Layout/Js/chat-update.js'></script>
                        <script src='Layout/Js/close-chat.js'></script>    
                    ";
            }
        ?>
    <script src="Layout/Js/swiper.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', 
        {
            slidesPerView: 1,
            speed: 200,
            spaceBetween: 100,
            pagination: 
            {
                el: '.swiper-pagination',
                //clickable: false,
                dynamicBullets: true,
            },
        });
    </script>
</body>
</html>