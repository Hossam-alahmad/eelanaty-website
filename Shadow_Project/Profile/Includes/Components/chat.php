<!-- Start Chat Box -->
<div class="chat-box">
    <div class="title">
        <div class="img-box pull-right">
        <?php 
            if($user_image != ""){
                echo "<img src='Layout/Images/users-images/$user_image' class='img-responsive' alt='$user_image'>";
            }
            else{
                preg_match("/./u",$user_name,$first_char);
                $first_char = strtoupper($first_char[0]);
                echo "<span>$first_char</span>";
            }
            ?>
        </div>
        <div class="username pull-right">
            <h5><?php echo $user_name; ?></h5>
            <span><i class='fa fa-circle <?php echo $class_status; ?>'></i> <?php echo $status; ?></span>
        </div>
        <a href="user-profile.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page; ?>" class="close" id="close-chat" data-text="<?php echo $user_id?>">X</a>
    </div>
    <div class="content" id="chat-content" data-text="<?php echo $user_id;?>">
        <?php
            /*  This code for get messages from databases between
            *   user1  sender 
            *   user2  recever
            */
            $user2_id = $_GET['open_chat'];
            $user_email = $_SESSION['user_email'];
            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user1_id = $result['user_id'];

            $query = $con->prepare("SELECT * FROM chat where (user1_id = '$user1_id' AND user2_id = '$user2_id') || (user1_id = '$user2_id' AND user2_id = '$user1_id') ");
            $query->execute();
            $user_class = "";
                while($result = $query->fetch(PDO::FETCH_ASSOC)){
                    $message = base64_decode($result['chat_text']);
                    if($user1_id == $result['user1_id'] && $user2_id == $result['user2_id']){
                        $user_class = "user1";
                    }
                    else if($user1_id == $result['user2_id'] && $user2_id == $result['user1_id']){
                        $user_class = "user2";
                    }
                    echo "
                        <div class='message'>
                            <p class='$user_class'>$message</p>
                        </div>
                    ";
                }
        ?>
    </div>
    <form class="row" method="POST" enctype="multipart/form-data" onsubmit="return sendMessage();">
        <div class="col-9 col-sm-9">
            <textarea class="form-control" placeholder="اكتب رسالة" id="message" data-text="<?php echo $user_id; ?>"></textarea>
        </div>
        <div class="col-3 col-sm-3 ">
            <button  class="btn btn-primary form-control"><i class="fa fa-reply" aria-hidden="true"></i></button>
        </div>
    </form>
</div>
<!-- Finished Chat Box -->