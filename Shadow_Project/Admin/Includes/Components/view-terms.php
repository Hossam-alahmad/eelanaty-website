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
            <div class="view">
                <?php 
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
                ?>
            </div>
            <a href="index.php?edit_terms" class="btn btn-primary">تعديل شروط الاستخدام</a>
        </div>
    </div>