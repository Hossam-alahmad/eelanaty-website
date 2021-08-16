<?php 
    include 'Includes/Components/header.php';
    if(!isset($_COOKIE['user_login']) || !isset($_SESSION['user_email']))
        echo "<script>window.open('register.php','_self');</script>";    
?>
    <!-- Started Insert-ads Box  -->
        <div class="insert-ads" id="page-wrapper">
            <div class="container-fluid">
                <div class="content">
                    <div class="head">
                        <h5 class="text-right">إضافة إعلان</h5>
                    </div>
                    <form class="row" enctype="multipart/form-data" method="POST" >
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>ضع عنوان مناسب لإعلانك</label>
                                <input type="text" class="form-control" name="ads_title" maxlength="50" placeholder="مثال: سيارة كيا ريو 2005" id="p_title">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label>ضع وصف مناسب لإعلانك</label>
                                <textarea class="form-control" class="desc" name="ads_desc" rows="18" id="p_desc"></textarea>
                                <span></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>سعر المنتج المعلن:</label>
                                <input type="number" class="form-control" name="ads_price" placeholder="مثال: 1000" id="p_price">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>نوع العملة:</label>
                            <select class="form-control" name="ads_currency" id="p_currency">
                                <option selected disabled></option>
                                <option value="$">دولار امريكي</option>
                                <option value="TL">ليرة تركية</option>
                            </select>
                            <span></span>
                            </div>
                            <div class="form-group">
                                <label>مكان تواجد المنتج:</label>
                                <input type="text" class="form-control" name="ads_location" placeholder="مثال: مدينة إدلب" id="p_location">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label>القسم:</label>
                                <select class="form-control" name="ads_category" id="p_category">
                                <option selected disabled></option>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM categories");
                                    $query->execute();
                                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                        $cat_title = $result["cat_title"];
                                        $cat_id    = $result["cat_id"];
                                        echo "
                                            <option value='$cat_id'>$cat_title</option>
                                        ";
                                    }
                                ?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label>حالة الإعلان:</label>
                                <select class="form-control" name="ads_status" id="p_status">
                                    <option selected disabled></option>
                                    <option value="إعلان">إعلان</option>
                                    <option value="مستعمل">مستعمل</option>
                                    <option value="جديد">جديد</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group">
                                <label>رفع صور حول المنتج (اختياري):</label>
                                <input type="file" class="form-control" name="ads_images[]" multiple id="p_images" accept="image/*">
                                <span></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" name="insert_ads" value="أضف الإعلان" id="add_ads">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
                $error_class = "";
                $content = "تم اضافة الإعلان بنجاح";
                $class = "fa-check-circle";
                include "Includes/Components/notification.php"; 
            ?>
        </div>
        <!--Finished Insert-ads Box  -->
        <?php 
            // insert ads to database
            if(isset($_POST['insert_ads'])){
                $ads_title = $_POST['ads_title'];
                $ads_desc = $_POST['ads_desc'];
                $ads_price = $_POST['ads_price'];
                $ads_currency = $_POST['ads_currency'];
                $ads_location = $_POST['ads_location'];
                $ads_category = $_POST['ads_category'];
                $ads_status = $_POST['ads_status'];
                $ads_desc2 = $ads_desc;
                // this code for find every link in description
                    $pattern = '~[a-z]+://\S+~';
                    if($num_found = preg_match_all($pattern, $ads_desc2, $out))
                    {
                        for($i =0;$i< count($out[0]);$i++){
                            $links = "<a href='" . $out[0][$i] . "' target='_blank'>" . $out[0][$i] ."</a>";
                            $ads_desc2 = str_replace($out[0][$i],$links,$ads_desc2);
                        }
                    }
                    
                $ads_images = [];
                $ads_temp   = [];
                $all_images = "";
                for($i = 0;$i<count($_FILES['ads_images']['name']);$i++){
                    $ads_images[$i] = $_FILES['ads_images']['name'][$i];
                    $ads_temp[$i] = $_FILES['ads_images']['tmp_name'][$i];
                    
                    // Move the upload image to Image Folder In Admin Area
                    move_uploaded_file($ads_temp[$i],'Layout/Images/products/' . $ads_images[$i] . '');

                    if($i != (count($_FILES['ads_images']['name']) - 1)){
                        $all_images .= $ads_images[$i] . ",";
                    }
                    else{
                        $all_images .= $ads_images[$i];
                    }
                }
                try{
                    
                    if(isset($_COOKIE['user_login'])){
                        $user_email = $_COOKIE['user_login'];
                        $query = $con->prepare("SELECT * FROM users where user_email = '$user_email'");
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        $user_id = $result['user_id'];
                    }
                    else{
                        $user_id = $_SESSION['user_id'];
                    }
                    $query = $con->prepare("INSERT INTO products (p_cat_id,user_id,product_title,product_price,product_currency,product_images,product_location,product_date,product_desc,product_desc2,product_status)
                                    VALUES ('$ads_category','$user_id','$ads_title','$ads_price','$ads_currency','$all_images','$ads_location',NOW(),'$ads_desc',?,'$ads_status')");
                    $store_in_dB = $query->execute([$ads_desc2]);
                    if($store_in_dB){
                        echo "
                            <script>
                                    var notify = document.getElementById('notify');
                                        notify.classList.add('show');
                                    setTimeout(function(){
                                        notify.classList.remove('show');
                                        window.open(document.URL,'_self');
                                    },2000);
                            </script>";
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
                

            }
        ?>
        
        <?php include 'Includes/Components/footer.php'; ?>
        <script src="Layout/Js/add-ads.js"></script>
    </body>
</html>