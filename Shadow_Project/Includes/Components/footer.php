    <!-- Start Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <h4>روابط</h4>
                    <ul class="links">
                        <li><a href="ads.php?cat_id=all&page=1">الاعلانات</a></li>
                        <li><a href="categories.php">الاقسام</a></li>
                        <li><a href="users.php?page=1">المعلنين</a></li>
                        <li><a href="#">الدعم الفني</a></li>
                        <li><a href="condition-terms.php">شروط الاستخدام</a></li>
                        <li><a href="privacy-policy.php">سياسة الخصوصية</a></li>
                    </ul>
                    <hr class="line">
                </div>
                <div class="col-md-6 offset-lg-1 col-lg-4">
                    <h4>معلومات التواصل</h4>
                    <ul>
                        <li>البريد: support@eelanaty.com</li>
                        <li>مقر العمل: سوريا - محافظة إدلب</li>
                        <li>فروعنا: ادلب - سرمدا - جسر الشغور - اعزاز - عفرين</li>
                    </ul>
                    <hr>
                    <video controls width="75%">
                        <source src="Layout/Video/eelanaty_intro.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="col-md-12 col-lg-3">
                    <h4>افضل 5 اقسام</h4>
                    <ul>
                        <li><a href="ads.php?cat_id=1&page=1">سيارات</a></li>
                        <li><a href="ads.php?cat_id=2&page=1">دراجات نارية</a></li>
                        <li><a href="ads.php?cat_id=4&page=1">اجهزة موبايل</a></li>
                        <li><a href="ads.php?cat_id=5&page=1">اجهزة كمبيوتر</a></li>
                        <li><a href="ads.php?cat_id=3&page=1">عقارات واراضي</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center">
        <div class="container-fluid">
            <p>جميع الحقوق محفوظة &copy; لمنصة إعلاناتي 2020</p>
        </div>
    </footer>
    <!-- End Footer -->
    <script src="Layout/Js/jquery-3.4.1.min.js"></script>
    <script src="Layout/Js/popper.min.js"></script>
    <script src="Layout/Js/bootstrap.min.js"></script>
    <script src="Layout/Js/menu-bar.js"></script>
    <script src="Layout/Js/nav-scroll.js"></script>
    <script src="Layout/Js/update-user-status.js"></script>
    <script src="Layout/Js/notify-message-update.js"></script>
    <?php 
        if(isset($_COOKIE['user_login'])  || isset($_SESSION['user_email'])){
            echo "<script src='Layout/Js/dropdown.js'></script>";
        }
       
    ?>
    

