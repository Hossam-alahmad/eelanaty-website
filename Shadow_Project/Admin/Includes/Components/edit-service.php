<?php 
    try{
        if(isset($_GET['service_id'])){
            $service_id = $_GET['service_id'];
            $query = $con->prepare("SELECT * FROM services where service_id = '$service_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $service_title = $result['service_title'];
                $service_icon  = $result['service_icon'];
                $service_desc  = $result['service_desc'];
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-handshake-o"></i> تعديل الخدمة</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / تعديل الخدمة
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
                            <input type="text" class="form-control" id='service_title' name="service_title" maxlength="100" value="<?php echo $service_title; ?>">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">صورة الخدمة:</label>
                            <input type="file" class="form-control" name="service_icon" style="padding-bottom:35px" accept="image/*">
                            <div class="img-box">
                                <img src="../Layout/Images/icons/<?php echo $service_icon; ?>" class="img-responsive">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">وصف الخدمة:</label>
                            <textarea name="service_desc" id='service_desc' class="form-control" rows="5"><?php echo $service_desc; ?></textarea>
                            <span></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="تعديل الخدمة" name="submit" class="btn btn-primary form-control">
                        </div>
                    </form>
                </div>
            </div>
            <?php 
                $error_class = "";
                $content = "تم تعديل الخدمة بنجاح";
                $class = "fa-check-circle";
                include "Includes/Components/notification.php";
            ?>
        </div>
    </div>
    

<?php
    // Edit service In Database MySql Using PDO
    if(isset($_POST['submit'])){
        
        $service_name = $_POST['service_title'];
        $service_desc = $_POST['service_desc'];

        $service_icon = $_FILES['service_icon']['name'];
        $service_temp = $_FILES['service_icon']['tmp_name'];
                    
        if($service_icon2 != ""){
            move_uploaded_file($service_temp,'../Layout/Images/icons/' . $service_icon2 . '');
            $location = "../Layout/Images/icons/" . $service_icon;
            unlink(realpath($location));
            $service_icon = $service_icon2;
        }

        try{
            if($service_name != "" && $service_desc != "" && $service_icon != ""){
                    $query = "UPDATE services SET service_icon = '$service_icon',
                                                    service_title ='$service_name',
                                                    service_desc = '$service_desc'
                                                    WHERE service_id = '$service_id'";
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
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        
        
    }

?>