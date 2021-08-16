<?php 
    include "Includes/Components/header.php";
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php','_self');</script>";
    }
?>
    <body style="background-color:#fff;">
        <div class="overlay-body" id="overlay"></div>
        <div id="wrapper">
            <?php include "Includes/Components/sidebar.php" ?>
            <div id="page-wrapper" class="page-wrapper">
                <div class="container-fluid">
                    <?php 
                        if(isset($_GET['dashboard'])){
                            include "Includes/Components/dashboard.php";
                        }
                        else if(isset($_GET['view_ads'])){
                            include "Includes/Components/view-ads.php";
                        }
                        else if(isset($_GET['view_users'])){
                            include "Includes/Components/view-users.php";
                        }
                        else if(isset($_GET['view_cats'])){
                            include "Includes/Components/view-categories.php";
                        }
                        else if(isset($_GET['insert_cat'])){
                            include "Includes/Components/insert-category.php";
                        }
                        else if(isset($_GET['edit_cat'])){
                            include "Includes/Components/edit-category.php";
                        }
                        else if(isset($_GET['view_services'])){
                            include "Includes/Components/view-services.php";
                        }
                        else if(isset($_GET['insert_service'])){
                            include "Includes/Components/insert-service.php";
                        }
                        else if(isset($_GET['edit_service'])){
                            include "Includes/Components/edit-service.php";
                        }
                        else if(isset($_GET['view_admins'])){
                            include "Includes/Components/view-admins.php";
                        }
                        else if(isset($_GET['insert_admin'])){
                            include "Includes/Components/insert-admin.php";
                        }
                        else if(isset($_GET['edit_admin'])){
                            include "Includes/Components/edit-admin.php";
                        }
                        else if(isset($_GET['view_privacy'])){
                            include "Includes/Components/view-privacy.php";
                        }
                        else if(isset($_GET['edit_privacy'])){
                            include "Includes/Components/edit-privacy.php";
                        }
                        else if(isset($_GET['view_terms'])){
                            include "Includes/Components/view-terms.php";
                        }
                        else if(isset($_GET['edit_terms'])){
                            include "Includes/Components/edit-terms.php";
                        }
                        else if(isset($_GET['account'])){
                            include "Includes/Components/account.php";
                        }
                        else{
                            include "Includes/Components/dashboard.php";
                        }
                        
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script src="Layout/Js/jquery-3.4.1.min.js"></script>
        <script src="Layout/Js/popper.min.js"></script>
        <script src="Layout/Js/bootstrap.min.js"></script>
        <script src="Layout/Js/nav-scroll.js"></script>
        <script src="Layout/Js/search-system.js"></script>
        <script src="Layout/Js/show-sidebar.js"></script>
        <?php 
            if(isset($_GET['view_users'])){
                echo "<script src='Layout/Js/update-users.js'></script>";
            }
            if(isset($_GET['edit_privacy']) || isset($_GET['edit_terms'])){
                echo "<script src='Layout/Js/tinymce/tinymce.min.js'></script>
                        <script>tinymce.init({
                                    selector: 'textarea',
                                    directionality:'rtl',
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table contextmenu paste'
                                    ],
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft  aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                                });
                        </script>";
            }
            if(isset($_GET['insert_cat'])){
                echo '<script src="Layout/Js/insert-category.js"></script>';
            }
            if(isset($_GET['edit_cat'])){
                echo '<script src="Layout/Js/edit-category.js"></script>';
            }
            if(isset($_GET['insert_service'])){
                echo '<script src="Layout/Js/insert-services.js"></script>';
            }
            if(isset($_GET['edit_service'])){
                echo '<script src="Layout/Js/edit-service.js"></script>';
            }
            if(isset($_GET['insert_admin'])){
                echo '<script src="Layout/Js/insert-admin.js"></script>';
            }
            if(isset($_GET['account'])){
                echo '<script src="Layout/Js/change-profile.js"></script>
                ';
                echo '<script src="Layout/Js/upload-image.js"></script>
                ';
                
            }
        ?>
    </body>
</html>