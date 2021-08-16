<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-users"></i> المسؤولين</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / المسؤولين
            </li>
        </ul>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="table-product table-responsive">
                <table class="table table-bordered table-hover">
                    <thead align="center">
                        <th>الرقم:</th>
                        <th>اسم المسؤول:</th>
                        <th>البريد الالكتروني:</th>
                        <th>الجنس:</th>
                        <th>مكان الإقامة:</th>
                        <th>الصلاحيات:</th>
                        <?php 
                            if($_SESSION['admin_level'] < 3){
                                echo "
                                    <th>تعديل:</th>
                                    <th>حذف:</th>";
                            }
                        
                        ?>
                    </thead>
                    <tbody align="center" id="tbody" data-text = "<?php echo $_GET['page']; ?>" data-value="<?php if(isset($_GET['search'])) echo $_GET['search']; else echo ""; ?>">
                        <?php 
                            $per_page = 10;
                            if(!isset($_GET['search'])){
                                viewAdmins($per_page);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagintation">
                <?php pagantition($per_page,"admins","view_admins","admin_id"); ?>
            </div>
        </div>
        <?php 
            $error_class = "";
            $content = "تم حذف المسؤول";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_GET['admin_id'])){
        
        try{
            $admin_id = $_GET['admin_id'];
            $query = "DELETE FROM admins WHERE admin_id = '$admin_id'";
            $con->exec($query);

            $query = "ALTER TABLE admins AUTO_INCREMENT = 1";
            $con->exec($query);

            echo "<script>
                    var notify = document.getElementById('notify');
                    notify.classList.add('show-notify');
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_admins','_self');
                    },2000);
                </script>";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>