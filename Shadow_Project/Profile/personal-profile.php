    <?php 
        include "Includes/Components/header.php";
        
        // get user data from database
        if(isset($_COOKIE['user_login']) || isset($_SESSION['user_email'])){
            if(isset($_COOKIE['user_login'])){
                $user_email = $_COOKIE['user_login'];
                $_SESSION['user_email'] = $_COOKIE['user_login'];
            }
            else if(isset($_SESSION['user_email'])){
                $user_email = $_SESSION['user_email'];
            }
            
            $query          = $con->prepare("SELECT * FROM users where user_email = '$user_email'");
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

        }
        else{
            echo "<script>window.open('../login.php','_self')</script>";
        }
    ?>
    <!-- Start Personal-profile -->
    <div class="personal-profile" id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <?php 
                    include "Includes/Components/sidebar.php"; 
                    if(isset($_GET["account"])){
                        include "Includes/Components/account.php";
                        $content = 'تم حفظ التغييرات';
                        $class = "fa-check-circle";
                        include "Includes/Components/notification.php"; 
                    }
                    else if(isset($_GET["my-ads"])){
                        include "Includes/Components/my-ads.php";
                    }
                    else if(isset($_GET["balance"])){
                        include "Includes/Components/balance.php";
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Finished Personal-profile -->

    <?php
        Include "Includes/Components/footer.php";
        if(!isset($_GET['about-me'])){
            echo '<script src="Layout/Js/upload-image.js"></script>
                <script src="Layout/Js/change-profile.js"></script>';
        }
        else if(isset($_GET['about-me'])){
            echo '<script src="Layout/Js/upload-image.js"></script>
                <script src="Layout/Js/change-about-me.js"></script>';
        }
    ?>
    </body>
</html>