<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-tag"></i> عرض الأقسام</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / عرض الأقسام
            </li>
        </ul>
        <div class="alert alert-primary">ملاحظة: يتم البحث حسب (اسم القسم - شرح القسم - الكلمات مفتاحية)</div>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="table-product table-responsive">
                <form method="get" class="search" onsubmit="return searchValues();">
                    <input type="search" name="search" class="form-control" placeholder="بحث عن قسم" id="search-inp" data-text="view_cats">
                    <button type="submit" class="fa" id="search-btn">&#xf002;</button>
                </form>
                <table class="table table-bordered table-hover">
                    <thead align="center">
                        <th>رقم القسم:</th>
                        <th>اسم القسم:</th>
                        <th>ايقونة القسم:</th>
                        <th>شرح القسم:</th>
                        <th>كلمات مفتاحية:</th>
                        <th>تعديل القسم:</th>
                        <th>حذف القسم:</th>
                    </thead>
                    <tbody align="center">
                        <?php 
                            $per_page = 10;
                            if(!isset($_GET['search'])){
                                viewCategories($per_page);
                            }
                            
                            else {
                                viewSearch($_GET['search'],"categories",$per_page,"cat_id");
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagintation">
                <?php pagantition($per_page,"categories","view_cats","cat_id"); ?>
            </div>
        </div>
        <?php 
            $error_class = "";
            $content = "تم حذف القسم";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_GET['cat_id'])){
        
        try{
            $cat_id = $_GET['cat_id'];
            $query = "DELETE FROM categories WHERE cat_id = '$cat_id'";
            $con->exec($query);

            $query = "ALTER TABLE categories AUTO_INCREMENT = 1";
            $con->exec($query);

            echo "<script>
                    var notify = document.getElementById('notify');
                    notify.classList.add('show-notify');
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_cats&page=1','_self');
                    },2000);
                </script>";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>