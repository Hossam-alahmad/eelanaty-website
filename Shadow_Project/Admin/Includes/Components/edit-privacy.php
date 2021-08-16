<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-lock"></i> تعديل سياسة الخصوصية</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / تعديل سياسة الخصوصية
            </li>
        </ul>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <form method='POST' enctype="multipart/form-data">
                <textarea class="form-control text-right" rows="20" name="description"><?php 
                    try{
                        $query = $con->prepare("SELECT privacy_content from privacy_policy where privacy_id = '1'");
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        $description = $result['privacy_content'];
                        echo $description;
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                
                ?></textarea>
                <input type="submit" name="edit_privacy" class="edit-btn btn btn-primary" value="تعديل سياسة الخصوصية">
            </form>
        </div>
        <?php 
            $error_class = "";
            $content = "تم تعديل سياسة الخصوصية";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_POST['edit_privacy'])){
        try{
            $description = $_POST['description'];
            $query = "UPDATE privacy_policy SET privacy_content='$description' WHERE privacy_id = '1'";
            $con->exec($query);
            echo "<script>
                    var notify = document.getElementById('notify');
                        notify.classList.add('show-notify');
                        setTimeout(function(){
                            notify.classList.remove('show-notify');
                            window.open(document.URL,'_self');
                        },2000);
                </script>";
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

?>