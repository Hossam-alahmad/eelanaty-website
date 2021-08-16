<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-handshake-o"></i> عرض الخدمات</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / عرض الخدمات
            </li>
        </ul>
        <div class="alert alert-primary">ملاحظة: يتم البحث حسب (اسم الخدمة - شرح الخدمة)</div>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="table-product table-responsive">
                <form method="get" class="search" onsubmit="return searchValues();">
                    <input type="search" name="search" class="form-control" placeholder="بحث عن خدمة" id="search-inp" data-text="view_services">
                    <button type="submit" class="fa" id="search-btn">&#xf002;</button>
                    
                </form>
                <table class="table table-bordered table-hover">
                    <thead align="center">
                        <th>الرقم:</th>
                        <th>ايقونة الخدمة:</th>
                        <th>اسم الخدمة:</th>
                        <th>شرح الخدمة:</th>
                        <th>تعديل:</th>
                        <th>حذف:</th>
                    </thead>
                    <tbody align="center" id="tbody" data-text = "<?php echo $_GET['page']; ?>">
                        <?php 
                            $per_page = 10;
                            if(!isset($_GET['search'])){
                                viewServices($per_page);
                            }
                            else{
                                viewSearch($_GET['search'],"services",$per_page,"service_id");
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagintation">
                <?php pagantition($per_page,"services","view_services","service_id"); ?>
            </div>
        </div>
        <?php 
            $content = "تم حذف الخدمة بنجاح";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_GET['service_id'])){
        
        try{
            $service_id = $_GET['service_id'];
            $query = "DELETE FROM services WHERE service_id = '$service_id'";
            $con->exec($query);

            $query = "ALTER TABLE services AUTO_INCREMENT = 1";
            $con->exec($query);

            echo "<script>
                    var notify = document.getElementById('notify');
                    notify.classList.add('show-notify');
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_services&page=1','_self');
                    },2000);
                </script>";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>