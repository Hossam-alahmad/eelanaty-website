<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-list-ul"></i> شروط الاستخدام</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / شروط الاستخدام
            </li>
        </ul>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <form method='POST' enctype="multipart/form-data">
                <textarea class="form-control text-right" rows="20" name="description"><?php 
                    try{
                        $query = $con->prepare("SELECT terms_content from condition_terms where terms_id = '1'");
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        $description = $result['terms_content'];
                        echo $description;
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                
                ?></textarea>
                <input type="submit" name="edit_terms" class="edit-btn btn btn-primary" value="تعديل سياسة الخصوصية">
            </form>
        </div>
        <?php 
            $error_class = "";
            $content = "تم تعديل شروط الاستخدام";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_POST['edit_terms'])){
        try{
            $description = $_POST['description'];
            $query = "UPDATE condition_terms SET terms_content='$description' WHERE terms_id = '1'";
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