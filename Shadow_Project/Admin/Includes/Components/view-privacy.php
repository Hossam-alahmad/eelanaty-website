<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-lock"></i> سياسة الخصوصية</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / سياسة الخصوصية
            </li>
        </ul>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="view">
                <?php 
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
                ?>
            </div>
            <a href="index.php?edit_privacy" class="btn btn-primary">تعديل سياسة الخصوصية</a>
        </div>
    </div>