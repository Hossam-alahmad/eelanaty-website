<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-users"></i> المستخدمين</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم / المستخدمين
            </li>
        </ul>
        <div class="alert alert-primary">ملاحظة: يتم البحث حسب (اسم المستخدم - البريد الالكتروني - الجنس - مكان الاقامة - تاريخ الانشاء - الحالة)</div>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="table-product table-responsive">
                <form method="get" class="search" onsubmit="return searchValues();">
                    <input type="search" name="search" class="form-control" placeholder="بحث عن مستخدم" id="search-inp" data-text="view_users">
                    <button type="submit" class="fa" id="search-btn">&#xf002;</button>
                </form>
                <table class="table table-bordered table-hover">
                    <thead align="center">
                        <th>الرقم:</th>
                        <th>اسم المستخدم:</th>
                        <th>البريد الالكتروني:</th>
                        <th>الجنس:</th>
                        <th>مكان الإقامة:</th>
                        <th>تاريخ الإنشاء:</th>
                        <th>الحالة:</th>
                        <th>حظر:</th>
                    </thead>
                    <tbody align="center" id="tbody" data-text = "<?php echo $_GET['page']; ?>" data-value="<?php if(isset($_GET['search'])) echo $_GET['search']; else echo ""; ?>">
                        <?php 
                            $per_page = 10;
                            if(!isset($_GET['search'])){
                                viewUsers($per_page);
                            }
                            else{
                                viewSearch($_GET['search'],"users",$per_page,"user_id");
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="pagintation">
                <?php pagantition($per_page,"users","view_users","user_id"); ?>
            </div>
        </div>
        <?php 
            $error_class = "";
            $content = "تم فك حظر المستخدم";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>
<?php 
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        try{
            
            $query = $con->prepare("SELECT status FROM users where user_id = '$user_id'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if($result['status'] == "panned"){
                // panned out from user
                $query = "UPDATE users SET status='' where user_id = '$user_id'";
                $con->exec($query);
                echo "<script>
                var notify = document.getElementById('notify');
                    notify.classList.add('show-notify');
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_users&page=1','_self');
                    },2000);
                </script>";
            }
            else{
                // panned user from website
                $query = "UPDATE users SET status='panned' where user_id = '$user_id'";
                $con->exec($query);

                echo "<script>
                var notify = document.getElementById('notify');
                    notify.classList.add('show-notify','notify-error');
                    notify.firstElementChild.classList.remove('fa-check-circle');
                    notify.firstElementChild.classList.add('fa-exclamation-circle');
                    
                    notify.lastElementChild.textContent = 'تم حظر المستخدم';
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?view_users&page=1','_self');
                    },2000);
                </script>";
            }
            
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

       
    }

?>