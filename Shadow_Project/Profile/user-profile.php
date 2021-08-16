<?php 
        include "Includes/Components/header.php";
        
        // get user data from database
        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];
            
            $query          = $con->prepare("SELECT * FROM users where user_id = '$user_id'");
            $query->execute();
            $result         = $query->fetch(PDO::FETCH_ASSOC);
            $user_name      = $result['username'];
            $user_firstname = $result['user_firstname'];
            $user_lastname  = $result['user_lastname'];
            $user_phone     = $result['user_number'];
            $user_gender    = $result['user_gender'];
            $user_birthday  = $result['user_birthday'];
            $user_image     = $result['user_image'];
            $user_location  = $result['user_location'];
            $user_about     = $result['user_about'];
            $last_login     = $result['last_login'];

            $user_birthday = explode("-",$user_birthday);
            $user_age = "غير معروف";
            $user_locate = "غير معروف";
            $user_gendr  = "غير معروف";
            $class="male";
            $status = "غير متصل";
            $class_status = "offline";
            $about_me   = "هذا المستخدم لم يقم بوضع نبذة عنه";
            if($user_birthday[0] != '0000'){
                $user_age = date('Y') - $user_birthday[0];
            }
            if($user_location != ""){
                $user_locate = $user_location;
            }
            if($user_gender != ""){
                $user_gendr = $user_gender;
                if($user_gender == "انثى"){
                    $class="female";
                }
            }
            if($user_about != ""){
                $about_me = $user_about;
            }
            if($last_login > time()){
                $status = "متصل";
                $class_status = "online";
            }
            $page  = $_GET['page'];
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
            echo "<script>window.open('../users.php?page=1','_self')</script>";
        }
        
    ?>
    <!-- Start User-profile -->
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
                            //window.open('user-profile.php?user_id=$user_id&page=$page','_self');
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
                            //window.open('user-profile.php?user_id=$user_id&page=$page','_self');
                        },3000);
                    </script>";
            }
        }
    ?>
    <div class="user-profile" id="page-wrapper">
        <div class="container-fluid">
            <div class="user-details row">
                <div class="col-md-3">
                    <div class="user-box">
                        <div class="img-box" <?php if($user_image != "") echo 'style=background-color:transparent';?>>
                            <?php 
                                if($user_image != ""){
                                    echo "<img class='img-responsive' src='Layout/Images/users-images/$user_image' alt='$user_image'>";
                                }
                                else{
                                    preg_match("/./u",$user_name,$first_char);
                                    $first_char = strtoupper($first_char[0]);
                                    echo "<span>$first_char</span>";
                                }
                            ?>
                        </div>
                        <div class="user-title">
                            <h4><?php echo $user_name; ?></h4>
                            <span><i class="fa fa-circle user-connection <?php echo $class_status; ?>"></i> <?php echo $status; ?></span>
                        </div>
                        <div class="user-info">
                            
                            <table class="table">
                                <tr>
                                    <th><i class="fa fa-map-marker" aria-hidden="true"></i></th>
                                    <td><?php echo $user_locate; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-birthday-cake" aria-hidden="true"></i></th>
                                    <td><?php echo $user_age ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-<?php echo $class;?>" aria-hidden="true"></i></th>
                                    <td><?php echo $user_gendr; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contact">
                        <h5>معلومات التواصل</h5>
                        <div class="contact-btn">
                            <?php 
                                if($user_phone != "0"){
                                    echo "<a href='https://wa.me/$user_phone' class='btn btn-success btn-block'><i class='fa fa-whatsapp' aria-hidden='true'></i> واتساب </a>";
                                }
                            ?>
                            <a href='user-profile.php?user_id=<?php echo $user_id;?>&page=<?php echo $page; ?>&open_chat=<?php echo $user_id;?>' class="btn btn-primary btn-block"><i class="fa fa-commenting-o" aria-hidden="true"></i> محادثة عبر الموقع</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="information">
                        <h5>نبذة عني:</h5>
                        <p><?php echo $about_me;?></p>
                    </div>
                    <div class="my-ads">
                        <div class="heading">
                            <h5>الاعلانات الخاصة به</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <?php
                                    // this function for get ads by category
                                    $page = 6;
                                    getAds($page); 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="pagintation">
                            <?php pagantition($page);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Finished User-profile -->
    <?php
        Include "Includes/Components/footer.php";
        if(isset($_GET['open_chat'])){
            echo "<script src='Layout/Js/chat.js'></script>
                    <script src='Layout/Js/chat-update.js'></script>
                    <script src='Layout/Js/close-chat.js'></script>";
        }
    ?>
    </body>
</html>