<?php 
    try{
        if(isset($_GET['cat_id'])){
            $cat_id = $_GET['cat_id'];
            $query = $con->prepare("SELECT * FROM categories where cat_id = '$cat_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $cat_title = $result['cat_title'];
                $cat_icon  = $result['cat_icon'];
                $cat_desc  = $result['cat_desc'];
                $cat_keywords = $result['cat_keywords'];
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-tag"></i> تعديل القسم</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / تعديل القسم
            </li>
        </ul>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" onsubmit="return catValidation();" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="control-label">اسم القسم:</label>
                            <input type="text" class="form-control" id='category_title' name="category_title" maxlength="100" value="<?php echo $cat_title; ?>">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">صورة القسم:</label>
                            <input type="file" class="form-control" name="category_icon" style="padding-bottom:35px" accept="image/*">
                            <div class="img-box">
                                <img src="../Layout/Images/icons/<?php echo $cat_icon; ?>" class="img-responsive">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">كلمات مفتاحية:</label>
                            <input type="text" class="form-control" id='category_keywords' name="category_keywords" value="<?php echo $cat_keywords; ?>">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">وصف القسم:</label>
                            <textarea name="category_desc" id='category_desc' class="form-control" rows="5"><?php echo $cat_desc; ?></textarea>
                            <span></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="تعديل القسم" name="submit" class="btn btn-primary form-control">
                        </div>
                    </form>
                </div>
            </div>
            <?php 
                $error_class = "";
                $content = "تم تعديل القسم بنجاح";
                $class = "fa-check-circle";
                include "Includes/Components/notification.php";
            ?>
        </div>
    </div>
    

<?php
    // Edit Category In Database MySql Using PDO
    if(isset($_POST['submit'])){
        
        $cat_name = $_POST['category_title'];
        $cat_keywords = $_POST['category_keywords'];
        $cat_desc = $_POST['category_desc'];

        $cat_icon2 = $_FILES['category_icon']['name'];
        $cat_temp = $_FILES['category_icon']['tmp_name'];
                    
        if($cat_icon2 != ""){
            move_uploaded_file($cat_temp,'../Layout/Images/icons/' . $cat_icon2 . '');
            $location = "../Layout/Images/icons/" . $cat_icon;
            unlink(realpath($location));
            $cat_icon = $cat_icon2;
        }

        try{
            if($cat_name != "" && $cat_keywords != "" && $cat_desc != "" && $cat_icon != ""){
                $query = "UPDATE categories SET cat_icon = '$cat_icon',
                cat_title ='$cat_name',
                cat_desc = '$cat_desc',
                cat_keywords = '$cat_keywords' WHERE cat_id = '$cat_id'";
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