<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-handshake-o"></i> إضافة خدمة جديدة</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / إضافة خدمة جديدة
            </li>
        </ul>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" onsubmit="return serviceValidation();" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="control-label">اسم الخدمة:</label>
                            <input type="text" class="form-control" id='service_title' name="service_title" maxlength="100">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">صورة الخدمة:</label>
                            <input type="file" class="form-control" id='service_icon' name="service_icon" style="padding-bottom:35px" accept="image/*">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">وصف الخدمة:</label>
                            <textarea name="service_desc" id='service_desc' class="form-control" rows="5"></textarea>
                            <span></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="إضافة الخدمة" name="submit" class="btn btn-primary form-control">
                        </div>
                    </form>
                </div>
            </div>
            <?php 
                $error_class = "";
                $content = "تم اضافة الخدمة بنجاح";
                $class = "fa-check-circle";
                include "Includes/Components/notification.php";
            ?>
        </div>
    </div>
    

<?php
    // Insert Product Category In Database MySql Using PDO
    if(isset($_POST['submit'])){
        // Get Data From Form
        
        $service_name = $_POST['service_title'];
        $service_desc = $_POST['service_desc'];

        $service_icon = $_FILES['service_icon']['name'];
        $service_temp = $_FILES['service_icon']['tmp_name'];
                    
        // Move the upload image to Image Folder In Admin Area
        move_uploaded_file($service_temp,'../Layout/Images/icons/' . $service_icon . '');

        try{
            if($service_name != "" && $service_desc != "" && $service_icon != ""){
                    $query = "INSERT INTO services (service_icon,service_title,service_desc) VALUES ('$service_icon','$service_name','$service_desc')";
                    $store_in_db = $con->exec($query);
                    if($store_in_db){
                        echo "
                            <script>
                                var notify = document.getElementById('notify');
                                    notify.classList.add('show-notify');
                                    setTimeout(function(){
                                        notify.classList.remove('show-notify');
                                        window.open('index.php?view_services&page=1','_self');
                                    },2000);
                            </script>";
                    }
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        
        
    }

?>