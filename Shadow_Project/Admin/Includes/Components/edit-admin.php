<?php 
    try{
        if(isset($_GET['admin_id'])){
            $admin_id = $_GET['admin_id'];
            $query = $con->prepare("SELECT * FROM admins where admin_id = '$admin_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $first_name = $result['first_name'];
                $last_name  = $result['last_name'];
                $admin_email  = $result['admin_email'];
                $admin_level  = $result['admin_level'];
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-users"></i> تعديل المسؤول</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم /  تعديل المسؤول
            </li>
        </ul>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return adminValidation();">
                            <div class="form-group">
                                <label for="first_name">الاسم الأول:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" disabled value="<?php echo $first_name; ?>">
                                <span></span>
                            </div>  
                            <div class="form-group">
                                <label for="last_name">اسم العائلة:</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" disabled disabled value="<?php echo $last_name; ?>">
                                <span></span>
                            </div> 
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني:</label>
                                <input type="email" class="form-control" name="email" id="email"  disabled value="<?php echo $admin_email; ?>">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label for="level">الصلاحيات:</label>
                                <select class="form-control" name='level' id='level'>
                                    <option disabled></option>
                                    <?php 
                                        $status = [1,2,3];
                                        if($_SESSION['admin_level'] == 1){
                                            for($i = 0; $i < 3 ;$i++){
                                                $j = $i + 1;
                                                if($admin_level == $j){
                                                    echo "<option selected value='$j'>$status[$i]</option>";
                                                }
                                                else{
                                                    echo "<option value='$j'>$status[$i]</option>";
                                                }
                                                
                                            }
                                        }
                                        else if($_SESSION['admin_level'] == 2){
                                            for($i = 1; $i < 3 ;$i++){
                                                $j = $i + 1;
                                                if($admin_level == $j){
                                                    echo "<option selected value='$j'>$status[$i]</option>";
                                                }
                                                else{
                                                    echo "<option value='$j'>$status[$i]</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary form-control" value="تعديل المسؤول"> 
                            </div>                                
                        </form>
                    </div>
            </div>
        </div>
        <?php 
            $error_class = "";
            $content = "تم تعديل المسؤول بنجاح";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $level = $_POST['level'];
        try{
            $query = "UPDATE admins SET admin_level = '$level'
                                            WHERE admin_email = '$admin_email'";
            $store_in_db = $con->exec($query);
            if($store_in_db){
                echo "
                    <script>
                        var notify = document.getElementById('notify');
                            notify.classList.add('show-notify');
                            setTimeout(function(){
                                notify.classList.remove('show-notify');
                                window.open(document.URL,'_self');
                            },2000);
                    </script>";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>
