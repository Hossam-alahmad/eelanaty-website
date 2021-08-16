<!-- Start Account -->
<div class="col-md-9">
    <div class="alert alert-success">
        <p>ملاحظة: نوصي بوضع رقم الهاتف من اجل تواصل المهتمين بمنتجك أو اعلانك</p>
    </div>  
    <div class="my-account">
        <div class="heading">
            <h4>حسابي</h4>
        </div>
        <div class="menu-bar">
                <ul>
                    <li><a href="personal-profile.php?account" class='<?php if(!isset($_GET['about-me'])) echo 'active'; ?>'>معلوماتي الشخصية</a></li>
                    <li><a href="personal-profile.php?account&about-me" class='<?php if(isset($_GET['about-me'])) echo 'active'; ?>'>نبذة عني</a></li>
                </ul>
            </div>
        <div class="info"> 
            <div class="row">
                <div class="col-md-4">
                    <div class="user-image" <?php if($user_image != "") echo 'style=background-color:transparent';?>>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="file" name="user_image" id="user-image" type="image/*">
                        </form>
                        <?php 
                            if($user_image != ""){
                                //$user_image = $result['user_image'];
                                echo "<img class='img-responsive' src='Layout/Images/users-images/$user_image' alt='$user_image'>";
                            }
                            else{
                                preg_match("/./u",$user_name,$first_char);
                                $first_char = strtoupper($first_char[0]);
                                echo "<span>$first_char</span>";
                            }
                        ?>
                        
                    </div>
                </div>
                <?php 
                    if(!isset($_GET['about-me'])){
                        include 'Includes/Components/my-info.php';
                    }
                    else{
                        include 'Includes/Components/about-me.php';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Finished Account -->