<!-- Sidebar Started -->
<div class="col-md-3">
    <div class="sidebar">
        <div class="profile-sidebar">
            <div class="user-picture">
                <div class="img-box" <?php if($user_image != "") echo 'style=background-color:transparent';?>>
                    <?php 
                        if($user_image != ""){
                            echo "<img class='img-responsive' src='Layout/Images/users-images/$user_image' alt='$user_image'>";
                        }
                        else{
                            preg_match("/./u",$result['username'],$first_char);
                            $first_char = strtoupper($first_char[0]);
                            echo "<span>$first_char</span>";
                        }
                    ?>
                </div>
                <div class="user-name">
                    <h4><?php echo $user_name; ?></h4>
                </div>
            </div>
            <div class="sections">
                <ul>
                    <li><a href="personal-profile.php?account"><i class="fa fa-user-o" aria-hidden="true"></i> حسابي</a></li>
                    <li><a href="personal-profile.php?my-ads&page=1"><i class="fa fa-briefcase" aria-hidden="true"></i> إعلاناتي</a></li>
                    <li><a href="personal-profile.php?balance"><i class="fa fa-money" aria-hidden="true"></i> رصيد الحساب</a></li>
                    <li><a href="../logout.php"><i class="fa fa-sign-out"></i> تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar Finished -->