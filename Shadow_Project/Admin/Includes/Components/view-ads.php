<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-briefcase"></i> عرض الإعلانات</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / عرض الإعلانات
            </li>
        </ul>
        <div class="alert alert-primary">ملاحظة: يتم البحث حسب (اسم المعلن - بريد المعلن - اسم الإعلان - سعر الإعلان - القسم)</div>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="table-product table-responsive">
                <form  method="POST" class="search" onsubmit="return searchValues();">
                    <input type="search" name="search" class="form-control" placeholder="بحث عن إعلان" id="search-inp" data-text="view_ads">
                    <button type="submit" class="fa" id="search-btn">&#xf002;</button>
                </form>
                <table class="table table-bordered table-hover">
                    <thead align="center">
                        <th>الرقم:</th>
                        <th>اسم المعلن:</th>
                        <th>بريد المعلن:</th>
                        <th>اسم الإعلان:</th>
                        <th>صورة الإعلان:</th>
                        <th>سعر الإعلان:</th>
                        <th>القسم:</th>
                        <th>حذف الإعلان:</th>
                    </thead>
                    <tbody align="center">
                        <?php 
                            $per_page = 10;
                            if(!isset($_GET['search'])){
                                viewAds($per_page);
                            }
                            else{
                                viewSearch($_GET['search'],"products",$per_page,"product_id");
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagintation">
                <?php 
                    pagantition($per_page,"products","view_ads","product_id");
                ?>
            </div>
        </div>
        <?php 
            
            $content = "تم حذف الإعلان";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_GET['ads_id'])){
        
        try{
            $ads_id = $_GET['ads_id'];
            $query = "DELETE FROM products WHERE product_id = '$ads_id'";
            $con->exec($query);

            $query = "ALTER TABLE products AUTO_INCREMENT = 1";
            $con->exec($query);

            echo "<script>
                    var notify = document.getElementById('notify');
                    notify.classList.add('show-notify');
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_ads&page=1','_self');
                    },2000);
                </script>";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>