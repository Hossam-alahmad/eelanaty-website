<?php 
    include 'Includes/Components/header.php';

    /* this code if user try to get into this page 
    * without have any account then transfer him to another page
    */
    if(!isset($_COOKIE['user_login']) || !isset($_SESSION['user_email']))
        echo "<script>window.open('register.php','_self');</script>";
    // this code if we get in url p_id then get product information use his id    
    else{
        if(isset($_GET['p_id'])){
            try{
                $p_id = $_GET['p_id'];
                $query = $con->prepare("SELECT * FROM products WHERE product_id = '$p_id'");
                $query->execute();
                if($query->rowCount() > 0){
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $p_cat_id           = $result['p_cat_id'];
                    $user_id            = $result['user_id'];
                    $product_title      = $result['product_title'];
                    $product_price      = $result['product_price'];
                    $product_currency   = $result['product_currency'];
                    $product_location   = $result['product_location'];
                    $product_desc       = $result['product_desc']; 
                    $product_status     = $result['product_status'];
                    if($result['product_images'] != ""){
                        $product_images = explode(",",$result['product_images']);
                    }
                    else{
                        $product_images = "";
                    }
                }
                else{
                    echo "<script>window.open('ads.php?cat_id=all&page=1','_self');</script>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        else{
            echo "<script>window.open('ads.php?cat_id=all&page=1','_self');</script>";
        }
    }
?>
    <!-- edit-ads Box Started -->
    <div class="edit-ads" id="page-wrapper">
        <div class="container-fluid">
            <div class="content">
                <div class="head">
                    <h5 class="text-right">تعديل الإعلان</h5>
                </div>
                <form class="row" enctype="multipart/form-data" method="POST">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>ضع عنوان مناسب لإعلانك</label>
                            <input type="text" class="form-control" name="ads_title" placeholder="مثال: سيارة كيا ريو 2005" id="p_title" value="<?php echo $product_title;?>">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>ضع وصف مناسب لإعلانك</label>
                            <textarea class="form-control" name="ads_desc" rows="18" id="p_desc"><?php echo $product_desc;?></textarea>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سعر المنتج المعلن:</label>
                            <input type="number" class="form-control" name="ads_price" placeholder="مثال: 1000" id="p_price" value="<?php echo $product_price;?>">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>نوع العملة:</label>
                            <select class="form-control" name="ads_currency" id="p_currency">
                                <option selected disabled></option>
                                
                                <option <?php if($product_currency == "$") echo "selected"; ?> value="$">دولار امريكي</option>
                                <option <?php if($product_currency == "TL") echo "selected";?> value="TL">ليرة تركية</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>مكان تواجد المنتج:</label>
                            <input type="text" class="form-control" name="ads_location" placeholder="مثال: مدينة إدلب" id="p_location" value="<?php echo $product_location;?>">
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
                                    if($p_cat_id == $cat_id){
                                        echo "
                                            <option selected value='$cat_id'>$cat_title</option>
                                            ";
                                    }
                                    else{
                                        echo "
                                            <option value='$cat_id'>$cat_title</option>
                                        ";
                                    }                                            
                                }
                            ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group">
                                <label>حالة الإعلان:</label>
                                <select class="form-control" name="ads_status" id="p_status">
                                    <option <?php if($product_status == 'إعلان') echo 'selected '; ?>value="إعلان">إعلان</option>
                                    <option <?php if($product_status == 'مستعمل') echo 'selected '; ?>value="مستعمل">مستعمل</option>
                                    <option <?php if($product_status == 'جديد') echo 'selected '; ?>value="جديد">جديد</option>
                                </select>
                                <span></span>
                        </div>
                        <div class="form-group">
                            <label>رفع صور حول المنتج (اختياري):</label>
                            <input type="file" class="form-control" name="ads_images[]" multiple id="p_images" accept="image/*">
                            <span></span>
                            <?php
                                if($product_images != ""){
                                    echo ' <!-- Swiper -->
                                        <div class="swiper-container edit-swiper">
                                        <div class="swiper-wrapper">';
                                        for($i = 0;$i < count($product_images);$i++){
                                            echo "
                                                <div class='swiper-slide'>
                                                    <img src='Layout/Images/ads-images/$product_images[$i]' alt='$product_images[$i]'>
                                                    <span data-text='$product_images[$i]' data-value='$p_id' onclick='deleteImage($i);'>X</span>
                                                </div>
                                                ";
                                            }
                                    echo '</div>
                                        <!-- Add Pagination -->
                                        <div class="swiper-pagination"></div>
                                    </div>
                                    ';
                                } 
                            ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" name="edit_ads" value="تعديل الإعلان" id="edit-ads">
                            </div>
                    </div>
                </form>
            </div>
        </div>
        <?php 
            $content = "تم تعديل الإعلان بنجاح";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php"; 
        ?>
    </div>
    <!-- edit-ads Box Finished -->
    <?php 
            // edit ads to database
            if(isset($_POST['edit_ads'])){
                $ads_title = $_POST['ads_title'];
                $ads_desc = $_POST['ads_desc'];
                $ads_price = $_POST['ads_price'];
                $ads_currency = $_POST['ads_currency'];
                $ads_location = $_POST['ads_location'];
                $ads_category = $_POST['ads_category'];
                $ads_status = $_POST['ads_status'];
                // this code for find every link in description
                $ads_desc2 = $ads_desc;
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
                    $query = $con->prepare("SELECT product_images FROM products where product_id = '$p_id'");
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $old_images = "";
                    if($result['product_images'] != ""){
                        $old_images = explode(",",$result['product_images']);
                        //$old_images = (array)$old_images;
                        if($all_images != ""){
                            $all_images .= ",";
                        }
                        for($i = 0;$i < count($old_images);$i++){
                            if($i != (count($old_images) - 1)){
                                $all_images .=  $old_images[$i] . ",";
                            }
                            else{
                                $all_images .= $old_images[$i];
                            }
                        }
                    }
                    //echo $all_images;
                    $query2 = $con->prepare("UPDATE products SET p_cat_id = '$ads_category',
                                            product_title = '$ads_title',
                                            product_price = '$ads_price',
                                            product_currency = '$ads_currency',
                                            product_images = '$all_images',
                                            product_location = '$ads_location',
                                            product_desc = '$ads_desc',
                                            product_desc2 = ?,
                                            product_status = '$ads_status'
                                        where product_id = '$p_id'");
                    $store_in_dB = $query2->execute([$ads_desc2]);
                    if($store_in_dB){
                        echo "
                            <script>
                                    var notify = document.getElementById('notify');
                                        notify.classList.add('show');
                                    setTimeout(function(){
                                        notify.classList.remove('show');
                                        window.open('show-ads.php?p_id=$p_id','_self');
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
    <script src="Layout/Js/swiper.min.js"></script>
    <script src="Layout/Js/delete-image.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
            },
        });
    </script>
    <script src= "Layout/Js/edit-ads.js"></script>
    </body>
</html>