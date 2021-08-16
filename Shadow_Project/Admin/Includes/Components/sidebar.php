
<nav class="navbar bg-dark navbar-dark " id="nav">
    <div class="navbar-header">
        <a href="index.php?dashboard" class="navbar-brand">لوحة تحكم المسؤول</a>
    </div>
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="admin-image">
                    <?php 
                            $admin_email = $_SESSION['admin_email'];
                            $query = $con->prepare("SELECT * FROM admins WHERE admin_email = '$admin_email'");
                            $query->execute();
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            $admin_image= $result['admin_image'];
                            $admin_name = $result['admin_name'];
                            if($admin_image != ""){
                                echo "<img src='Layout/Images/admin-image/$admin_image' alt='$admin_image'>"; 
                            }
                            else{
                                preg_match("/./u",$admin_name,$first_char);
                                $first_char = strtoupper($first_char[0]);
                                echo "<div class='avatar'><span>$first_char</span></div>";
                            }
                    ?>
                </div>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="dropdown-menu">
                <li>
                    <a href="index.php?account">
                        <i class="fa fa-user"></i> الملف الشخصي
                    </a>
                </li>
                <li>
                    <a href="index.php?view_users">
                        <i class="fa fa-users"></i> مستخدمين جدد
                        <span class="badge badge-light">
                            <?php 
                                $date = date("Y-m-d");
                                $query = $con->prepare("SELECT * FROM users where create_account = '$date'");
                                $query->execute();
                                $new_user = $query->rowCount();
                                echo $new_user;
                            ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="index.php?view_ads">
                        <i class="fa fa-tag"></i> إعلانات جديدة
                        <span class="badge badge-light">
                            <?php 
                                $date = date("Y-m-d");
                                $query = $con->prepare("SELECT * FROM products where product_date = '$date'");
                                $query->execute();
                                $new_products = $query->rowCount();
                                echo $new_products;
                            ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> تسجيل خروج
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="menu-bar" id="bars">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>
<div class="sidebar" id="sidebar">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php?dashboard">
                    <i class="fa fa-fw fa-dashboard"></i> لوحة التحكم
                </a>
            </li>
            <li>
                <a href="index.php?view_ads&page=1">
                    <i class="fa fa-fw fa-briefcase"></i> الإعلانات
                </a>
            </li>
            <li>
                <a href="index.php?view_users&page=1" >
                    <i class="fa fa-fw fa-users"></i> المستخدمين
                </a>
            </li>
            <li>
                <a href="#" data-toggle="collapse" data-target="#categories">
                    <i class="fa fa-fw fa-tag"></i> الأقسام
                    <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="categories" class="collapse">
                    <li>
                        <a href="index.php?view_cats&page=1">
                            عرض الاقسام
                        </a>
                        <a href="index.php?insert_cat">
                            اضافة قسم جديد
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="#" data-toggle="collapse" data-target="#services">
                    <i class="fa fa-fw fa-handshake-o"></i> الخدمات
                    <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="services" class="collapse">
                    <li>
                        <a href="index.php?view_services&page=1">
                            عرض الخدمات
                        </a>
                        <a href="index.php?insert_service">
                            اضافة خدمة جديدة
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                
                <a href="#" data-toggle="collapse" data-target="#admin">
                    <i class="fa fa-fw fa-users"></i> المسؤولين
                    <i class="fa fa-fw fa-caret-down"></i>
                </a>
                
                <ul id="admin" class="collapse">
                    <li>
                        <?php 
                            if($_SESSION['admin_level'] < 3){
                                
                                echo "
                                    <a href='index.php?view_admins'>
                                        عرض المسؤولين
                                    </a>
                                    <a href='index.php?insert_admin'>
                                        إضافة مسؤول جديد
                                    </a>
                                    
                                ";
                            }
                            else{
                                echo "
                                    <a href='index.php?view_admins'>
                                        عرض المسؤولين   
                                    </a>
                                    ";
                            }
                        ?>
                    </li>
                </ul>
            </li> 
            <!-- 
                <li>
                <a href="#" data-toggle="collapse" data-target="#accounts">
                    <i class="fa fa-fw fa-money"></i> الحسابات
                    <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="accounts" class="collapse">
                    <li>
                        <a href="index.php?insert_p_cat">
                            اضافة حساب جديد
                        </a>
                        <a href="index.php?view_p_cats">
                            عرض الحسابات
                        </a>
                    </li>
                </ul>
                </li>   
            -->        
            <li>
                <a href="index.php?view_privacy" >
                    <i class="fa fa-lock" aria-hidden="true"></i> سياسة الخصوصية
                </a>
            </li>
            <li>
                <a href="index.php?view_terms">
                    <i class="fa fa-fw fa-list-ul"></i> شروط الإستخدام
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fa fa-fw fa-sign-out"></i> تسجيل خروج
                </a>
            </li>
        </ul>
    </div>