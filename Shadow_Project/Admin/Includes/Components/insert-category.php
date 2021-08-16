<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-tag"></i> إضافة قسم جديد</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / إضافة قسم جديد
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
                            <input type="text" class="form-control" id='category_title' name="category_title" maxlength="100">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">صورة القسم:</label>
                            <input type="file" class="form-control" id='category_icon' name="category_icon" style="padding-bottom:35px" accept="image/*">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">كلمات مفتاحية:</label>
                            <input type="text" class="form-control" id='category_keywords' name="category_keywords">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">وصف القسم:</label>
                            <textarea name="category_desc" id='category_desc' class="form-control" rows="5"></textarea>
                            <span></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="إضافة القسم" name="submit" class="btn btn-primary form-control">
                        </div>
                    </form>
                </div>
            </div>
            <?php 
                $error_class = "";
                $content = "تم اضافة القسم بنجاح";
                $class = "fa-check-circle";
                include "Includes/Components/notification.php";
            ?>
        </div>
    </div>
    

<?php
    // Insert Product Category In Database MySql Using PDO
    if(isset($_POST['submit'])){
        // Get Data From Form
        
        $cat_name = $_POST['category_title'];
        $cat_keywords = $_POST['category_keywords'];
        $cat_desc = $_POST['category_desc'];

        $cat_icon = $_FILES['category_icon']['name'];
        $cat_temp = $_FILES['category_icon']['tmp_name'];
                    
        // Move the upload image to Image Folder In Admin Area
        move_uploaded_file($cat_temp,'../Layout/Images/icons/' . $cat_icon . '');

        try{
            if($cat_name != "" && $cat_keywords != "" && $cat_desc != "" && $cat_icon != ""){
                    $query = "INSERT INTO categories (cat_icon,cat_title,cat_desc,cat_keywords) VALUES ('$cat_icon','$cat_name','$cat_desc','$cat_keywords')";
                    $store_in_db = $con->exec($query);
                    if($store_in_db){
                        echo "
                            <script>
                                var notify = document.getElementById('notify');
                                    notify.classList.add('show-notify');
                                    setTimeout(function(){
                                        notify.classList.remove('show-notify');
                                        window.open('index.php?view_cats&page=1','_self');
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