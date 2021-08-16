<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-users"></i> اضافة مسؤول جديد</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم /  اضافة مسؤول جديد
            </li>
        </ul>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return adminValidation();">
                            <div class="form-group">
                                <label for="first_name">الاسم الأول:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name">
                                <span></span>
                            </div>  
                            <div class="form-group">
                                <label for="last_name">اسم العائلة:</label>
                                <input type="text" class="form-control" name="last_name" id="last_name">
                                <span></span>
                            </div> 
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني:</label>
                                <input type="email" class="form-control" name="email" id="email">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label for="level">الصلاحيات:</label>
                                <select class="form-control" name='level' id='level'>
                                    <option selected disabled></option>
                                    <?php 
                                        $status = [1,2,3];
                                        if($_SESSION['admin_level'] == 1){
                                            for($i = 0; $i < 3 ;$i++){
                                                $j = $i + 1;
                                                echo "<option value='$j'>$status[$i]</option>";
                                            }
                                        }
                                        else if($_SESSION['admin_level'] == 2){
                                            for($i = 1; $i < 3 ;$i++){
                                                $j = $i + 1;
                                                echo "<option value='$j'>$status[$i]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label for="password">'كلمة المرور:</label>
                                <input type="password" class="form-control" name="password" id="password">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary form-control" value="إضافة مسؤول"> 
                            </div>                                
                        </form>
                    </div>
            </div>
        </div>
        <?php 
            $error_class = "";
            $content = "تم اضافة المسؤول بنجاح";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php";
        ?>
    </div>

    <?php
    if(isset($_POST['submit'])){
        echo 1;
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $admin_name = $first_name . " " . $last_name;
        $email = $_POST['email'];
        $level = $_POST['level'];
        $admin_pass = sha1($_POST['password']);
                    

        try{
                    
            $query = $con->prepare("SELECT admin_email From admins where admin_email = '$email'");
            $query->execute();
            if($query->rowCount() > 0){
                echo "<script>
                var notify = document.getElementById('notify');
                    notify.classList.add('show-notify','notify-error');
                    notify.firstElementChild.classList.remove('fa-check-circle');
                    notify.firstElementChild.classList.add('fa-exclamation-circle');
                    
                    notify.lastElementChild.textContent = 'الايميل موجود مسبقا';
                    setTimeout(function(){
                        notify.classList.remove('show-notify');
                        window.open('index.php?insert_admin','_self');
                    },2000);
                </script>";
            }
            else{
                $query = "INSERT INTO admins (admin_name,first_name,last_name,admin_email,admin_pass,admin_level) 
                VALUES ('$admin_name','$first_name','$last_name','$email','$admin_pass','$level')";
                $store_in_db = $con->exec($query);
                if($store_in_db){
                    echo "
                        <script>
                            var notify = document.getElementById('notify');
                                notify.classList.add('show-notify');
                                setTimeout(function(){
                                    notify.classList.remove('show-notify');
                                    window.open('index.php?insert_admin','_self');
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
