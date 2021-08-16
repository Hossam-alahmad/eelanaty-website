<?php   
        include 'Includes/Components/header.php'; 
        // if user have already remmber him go to ads page direct
        if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])){
            echo "<script>window.open('Profile/personal-profile.php?account','_self');</script>";
        }
?>
    <!-- Start Header -->
    <div class="header" id="page-wrapper">
        <div class="overlay"></div>
        <div class="container-fluid">
            <div class="content">
                <p>إعلاناتي |  منصة لوضع اعلاناتك التي تريد تسويقها</p>
                <div>
                    <input type="text" class="form-control" placeholder="مثال: مطلوب لابتوب hp">
                    <a class="btn btn-primary" href="insert-ads.php">أضف اعلانك</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Finished Header -->
    <!-- Start about -->
    <div class="about">
        <div class="container-fluid">
            <h1 class="text-center">ما هي منصة إعلاناتي</h1>
            <div class="content">
                <p>هي منصة تساعد المستخدمين للوصول الى طلباتهم واحتياجاتهم من خلال اعلان البائع عن المنتج الذي يريد بيعه ليتم شرائها من المستخدمين المهتمين بهذا المنتج حيث تعتبر المنصة صلة وصل بين البائع والمشتري</p>
            </div>
        </div>
    </div>
    <!-- Finished about -->
    <!-- Start service -->
    <div class="service">
        <div class="container-fluid">
            <h2 class="text-center h1">ماذا تقدم منصة إعلاناتي</h2>
            <div class="row">
                <?php getServices(); ?>
            </div>
        </div>
    </div>
    <!-- Finished service -->
    <!-- Start category -->
    <div class="category">
        <div class="container-fluid">
            <h2 class="text-center h1">أقسام منصة إعلاناتي</h2>
            <div class="row">
                <?php getIndexCategory(); ?>
            </div>
        </div>
    </div>
    <!-- Finished category -->
    <!-- Start reg -->
    <div class="reg">
        <div class="container-fluid">
            <div class="content">
                <p>ابدأ في استخدام إعلاناتي واعلن بسهولة عبر الانترنت</p>
                <a class="btn btn-default" href="register.php">إنشاء حساب</a>
            </div>
        </div>
    </div>
    <!-- Finished reg -->
    <?php include 'Includes/Components/footer.php'; ?>
    </body>
</html>