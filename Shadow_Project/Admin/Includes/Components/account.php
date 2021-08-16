<?php 
    $admin_email = $_SESSION['admin_email'];
    $query = $con->prepare("SELECT * FROM admins WHERE admin_email = '$admin_email'");
    $query->execute();
    if($query->rowCount() > 0){
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $admin_name = $result['admin_name'];
        $admin_first = $result['first_name'];
        $admin_last = $result['last_name'];
        $admin_location = $result['admin_location'];
        $admin_gender = $result['admin_gender'];
        $admin_image = $result['admin_image'];
        $admin_birth = $result['admin_birthday'];
    }
?>
<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-user"></i> الملف الشخصي</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / الملف الشخصي
            </li>
        </ul>
    </div>
</div>
<!-- Start Account -->
<div class="col-md-12">  
    <div class="my-account">
        <div class="info"> 
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="user-image">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="file" name="admin_image" id="admin-image" accept="image/*">
                        </form>
                        <?php 
                                if($admin_image != ""){
                                    echo "<img src='Layout/Images/admin-image/$admin_image' alt='$admin_image'>"; 
                                }
                                else{
                                    preg_match("/./u",$_SESSION['admin_name'],$first_char);
                                    $first_char = strtoupper($first_char[0]);
                                    echo "<div class='avatar'><span>$first_char</span></div>";
                                }
                        ?>
                        
                    </div>
                    <div class="admin-name">
                        <h4><?php echo $admin_name; ?></h4>
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
        <?php 
            
            $content = "تم التعديل بنجاح";
            include "Includes/Components/notification.php";
        ?>
    </div>
</div>
<!-- Finished Account -->