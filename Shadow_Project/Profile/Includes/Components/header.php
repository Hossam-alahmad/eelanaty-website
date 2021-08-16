<?php
    session_start();
    include "../Admin/Includes/Components/connection.php";
    include "Includes/Functions/function.php";
    // this condition for see if active variable is exist and used for navbar menu list
    if(!isset($active)){
        $active = "";
    }
    // delete user session chat and make him offline only when leave chat 
    if(!isset($_GET['open_chat'])){
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
            $user1_id = $result['user_id'];
            $query = $con->prepare("SELECT * FROM chat_session where user1_id = '$user1_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $query = "DELETE FROM chat_session where user1_id = '$user1_id'";
                $con->exec($query);
                $query = "ALTER TABLE chat_session AUTO_INCREMENT = 1";
                $con->exec($query);
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="google-signin-client_id" content="711355041326-4l6igginacg4n2lik1kuigp7ap7d4b9o.apps.googleusercontent.com">
        <meta name="description" content="">
        <title>Project 1</title>
        <link rel="stylesheet" href="Layout/Css/bootstrap.min.css">
        <link rel="stylesheet" href="Layout/Css/font-awesome.min.css">  
        <link rel="stylesheet" href="Layout/Scss/main.css">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
    </head>
    <body>
        <!-- Navbar Started -->
        <div class="menu-bar" id="menu-bar">
            <ul>
                <li><a href="../ads.php?cat_id=all&page=1"><i class="fa fa-briefcase" aria-hidden="true"></i> تصفح الإعلانات</a></li>
                <li><a href="../users.php"><i class="fa fa-users-o" aria-hidden="true"></i> تصفح المعلنين</a></li>
                <li><a href="../categories.php"><i class="fa fa-tag" aria-hidden="true"></i> تصفح الأقسام</a></li>
                <li><a href="#"><i class="fa fa-life-ring" aria-hidden="true"></i>  الدعم الفني</a></li>
                <li class="support" id="support-collapse">
                    <a><i class="fa fa-thumb-tack" aria-hidden="true"></i>  عرض المزيد <i class="fa fa-angle-left" aria-hidden="true" id="angle-left"></i></a>
                </li>
                <ul id="dropdown-list">
                    <li><a href="../condition-terms.php"><i class="fa fa-list-ul" aria-hidden="true"></i> شروط الإستخدام</a></li>
                    <li><a href="../privacy-policy.php"><i class="fa fa-lock" aria-hidden="true"></i> سياسة الخصوصية</a></li>
                </ul>
                <li><a href="../insert-ads.php"><i class="fa fa-plus" aria-hidden="true"></i>  إضافة إعلان</a></li>
                <?php if(isset($_COOKIE['user_login']) && isset($_SESSION['user_email'])){
                    echo '<li><a href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>  تسجيل خروج</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="overlay-body" id="overlay-body"></div>
        <nav class="navbar" id="navbar">
            <div class="container-fluid">

            <a class="navbar-brand <?php if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])) echo "avatar-brand"; ?>" href="../index.php"><img src="../Admin/Layout/Images/elanati-logo.png" class="img-responsive" alt="إعلاناتي"></a>
                <div class="nav <?php if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])) echo "avatar"; ?>">
                    <ul class="navbar-nav">
                        <li class="nav-item  <?php if($active == "ads")  echo 'active'; ?>" >
                            <a class="nav-link" href="../ads.php?cat_id=all&page=1"><i class="fa fa-briefcase" aria-hidden="true"></i>الاعلانات</a>
                        </li> 
                        <li class="nav-item <?php if($active == "categories") echo 'active'; ?>">
                            <a class="nav-link" href="../categories.php"><i class="fa fa-tag" aria-hidden="true"></i>الاقسام</a>
                        </li>
                        <li class="nav-item <?php if($active == "users")  echo 'active'; ?>">
                            <a class="nav-link" href="../users.php?page=1"><i class="fa fa-users" aria-hidden="true"></i>المعلنين</a>
                        </li>
                        <li class="nav-item" id="notify-bell">
                            
                                <?php  
                                    if(isset($_SESSION['user_email']) || isset($_COOKIE['user_login'])){
                                        if(isset($_SESSION['user_email'])){
                                            $user_email = $_SESSION['user_email'];
                                        }
                                        else if(isset($_COOKIE['user_login'])){
                                            $user_email = $_COOKIE['user_login'];
                                        }

                                        try{
                                            // query for get id of user who have notification
                                            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $user2_id = $result['user_id'];
                                            // query for get sum of all messages send it to second user
                                            $query = $con->prepare("SELECT notification_numbers,user1_id FROM chat where user2_id = '$user2_id' AND notification_numbers = '1'");
                                            $query->execute();
                                            $total_notify = $query->rowCount();
                                            
                                            $user1_ids = [];
                                            $i = 0;
                                            // add all first users (sender) id to array 
                                            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                                $user1_ids[$i] = $result['user1_id'];
                                                $i++;
                                            }
                                            $badge = "badge-danger";
                                            // if we dont have any notification
                                            if($total_notify == 0){
                                                $total_notify = "";
                                                $badge = "";
                                            }
                                            // delete duplicate of datd ids
                                            $user1_ids = array_unique($user1_ids);
                                            $total_ids = "";
                                            for($i = 0 ;$i< count($user1_ids);$i++){
                                                if($i != (count($user1_ids) - 1)){
                                                    $total_ids .= $user1_ids[$i] . ",";
                                                }
                                                else{
                                                    $total_ids .= $user1_ids[$i];
                                                }
                                            }
                                            // get user1 id sender                                             
                                            echo "<span class='badge $badge'>$total_notify</span>";
                                        }
                                        catch(PDOException $e){
                                            echo $e->getMessage();
                                        }
                                    }
                                ?>
                            
                            <a class="nav-link" href="#"><i class="fa fa-bell" aria-hidden="true"></i></a>
                        </li>
                        <div class="notify-dropdown" id="notify-dropdown">
                            <ul id="notify-list" <?php if(count($user1_ids) > 0) echo "data-text = '" . count($user1_ids) . "'"; 
                                                            if($total_ids != "") echo "data-value = '" . $total_ids . "'"; 
                                                            if($total_ids != "") echo "data-id = '" . $user2_id . "'"; ?>
                                >
                                <?php 
                                    // if we dont have any notification
                                    if($total_notify == ""){
                                        
                                        echo "<p>لايوجد اي اشعار</p>";
                                    }
                                    else{
                                        $end = count($user1_ids);
                                        // query for get user id (sender) and username (sender) by use his ids 
                                        $query = $con->prepare("SELECT user_id,username FROM users JOIN chat ON users.user_id IN($total_ids) limit 0,$end");
                                        $query->execute();
                                        while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                            $user_name = $result['username'];
                                            $user1_id  = $result['user_id'];
                                            // query for get every user sender how much send message
                                            $query2 = $con->prepare("SELECT notification_numbers FROM chat where user1_id = '$user1_id ' AND user2_id = '$user2_id' AND notification_numbers = '1'");
                                            $query2->execute();
                                            $sum_message = $query2->rowCount();
                                            $notify_sender = "لديك " . $sum_message . " رسالة جديدة من " . $user_name; 
                                            echo "<li><a href='user-profile.php?user_id=$user1_id&page=1&open_chat=$user1_id' data-text='$user1_id'>$notify_sender</a></li>";
                                        }
                                        
                                    }
                                ?>

                            </ul>
                        </div>
                    </ul>
                    <ul class="navbar-nav reg-login">
                        <?php 
                            /* 
                                This Code for check if user is already in website 
                                if user not exist show login and register buttons
                                if user exist show his image
                            */
                            if(!isset($_COOKIE['user_login']) && !isset($_SESSION['user_email'])){
                                echo '<li class="nav-item login">
                                        <a class="nav-link btn btn-default" href="../login.php">دخول</a>
                                    </li>
                                    <li class="nav-item register">
                                        <a class="nav-link btn btn-primary" href="../register.php">إنشاء حساب</a>
                                    </li> ';
                            }
                            else{
                                if(isset($_COOKIE['user_login'])){
                                    $email = $_COOKIE['user_login'];
                                }
                                else if(isset($_SESSION['user_email'])){
                                    $email = $_SESSION['user_email'];
                                }
                                // query select for get this user as login in our website
                                $query = $con->prepare("SELECT * FROM users where user_email = '$email'");
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                /* if user have image then put into image box
                                *  else put first char of his name into image box
                                */
                                echo "<li class='user-avatar'";  if($result['user_image'] != "") echo "style='background-color:transparent' "; echo "id='user-avatar'>";
                                // if user have cookies then add his data to $email variable
                                // else add data of session to $email variable
                                
                                if($result['user_image'] != ""){
                                    $user_image = $result['user_image'];
                                    echo "<img class='img-responsive' src='Layout/Images/users-images/$user_image' alt='$user_image'>";
                                }
                                else{
                                    preg_match("/./u",$result['username'],$first_char);
                                    $first_char = strtoupper($first_char[0]);
                                    echo "<span>$first_char</span>";
                                }
                                 // show dropdown
                                echo "
                                    </li>
                                    <div class='dropdown' id='dropdown'>
                                        <ul>
                                            <li>
                                                <a href='#'>
                                                    <i class='fa fa-moon-o'></i> تغيير الوضع
                                                </a>
                                            </li>
                                            <li>
                                                <a href='personal-profile.php?account'>
                                                    <i class='fa fa-user'></i> الملف الشخصي
                                                </a>
                                            </li>
                                            <li>
                                                <a href='personal-profile.php?my-ads&page=1'>
                                                    <i class='fa fa-briefcase'></i> إعلاناتي
                                                </a>
                                            </li>
                                            <li>
                                                <a href='personal-profile.php?balance'>
                                                    <i class='fa fa-money'></i> الرصيد
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../logout.php'>
                                                    <i class='fa fa-sign-out'></i> تسجيل الخروج
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                ";
                            }
                        ?>
                    </ul>
                    <div class="menu-bar" id="bars">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                
            </div>
            
        </nav>
        <!-- Navbar Finished -->
    
                            