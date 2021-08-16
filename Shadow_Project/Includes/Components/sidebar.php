<!-- Sidebar Started -->
<div class="col-md-3">
    <div class="sidebar">
        <a class="btn btn-primary btn-block" href="insert-ads.php">أضف إعلانك الآن</a>
        <form action="<?php if(isset($_GET['cat_id'])) echo "ads.php?cat_id=" . $_GET['cat_id'] . "&page=1"; else echo "users.php?page=1";?>" method="POST">
            <div class="form-group">
                <input type="search" class="form-control" placeholder="بحث" id="search" name="search">
                <button class="btn btn-primary" href="#" id="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </form>
        <div class="category">
            <div class="hdr">
                <h5 class="pull-right">الأقسام</h5>
                <span class="show-cat pull-left" id="show-hide-cat">إظهار</span>
            </div>
            <hr>
            <ul class="hide-list" id="category-list">
                <?php getSideBarCategory(); ?>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar Finished -->
<?php 
    if(isset($_POST['search'])){
        // we have post use search input
        // Initialize Variables
        $search_value = $_POST['search'];
        $found = false;
        $i = 0;
        $id = "";
        try{
            // if search var not empty
            if($search_value != ""){
                if(isset($_GET['cat_id'])){
                    /* define array for get products id if we 
                    *found any word equal our search input data
                    */
                    $cat_id = $_GET['cat_id'];
                    if($cat_id != "all"){
                        $query = $con->prepare("SELECT * FROM products where p_cat_id = '$cat_id'");
                        $query->execute();
                    }
                    else{
                        $query = $con->prepare("SELECT * FROM products");
                        $query->execute();
                    }
                    $product_id = [];
                    
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $products_id   = $result['product_id'];
                        $product_title = $result['product_title'];
                        $product_desc  = $result['product_desc'];
                        /* compare use search input value and $product_title of product
                        * and compare user search input value and $product_desc of product
                        * if we found any compare true then get product id of this product to products_id array
                        */ 
                        if(strpos($product_title,$search_value) !== false || strpos($product_desc,$search_value) !== false){
                            $found = true;
                            $product_id[$i] = $products_id;
                            $i++;
                        }
                    }
                    for($i=0;$i< count($product_id);$i++){
                        if($i != (count($product_id) - 1)){
                            $id .= $product_id[$i] . ",";
                        }
                        else{
                            $id .= $product_id[$i];
                        }
                    }
                    //$location = "ads.php?result='" . $id . "'&cat_id='" . $_GET['cat_id'] . "'&page='" . $_GET['page'];
                    
                    if($found == true){
                        $location = "ads.php?result=$id&cat_id=" . $_GET['cat_id'] . "&page=1";
                        echo "<script>window.open('$location','_self');</script>";
                    }
                    
                }
                else{
                    $users_id = [];
                    $query = $con->prepare("SELECT * FROM users");
                    $query->execute();
                    while($result = $query->fetch(PDO::FETCH_ASSOC)){
                        $user_id   = $result['user_id'];
                        $user_name = $result['username'];
                        $user_location  = $result['user_location'];
                        /* compare use search input value and $user_name of users
                        * and compare user search input value and $user_location of users
                        * if we found any compare true then get users id of this users to users_id array
                        */ 
                        if(strpos($user_name,$search_value) !== false || strpos($user_location,$search_value) !== false){
                            $found = true;
                            $users_id[$i] = $user_id;
                            $i++;
                        }
                    }
                    for($i=0;$i< count($users_id);$i++){
                        if($i != (count($users_id) - 1)){
                            $id .= $users_id[$i] . ",";
                        }
                        else{
                            $id .= $users_id[$i];
                        }
                    }
                    
                    if($found == true){
                        $location = "users.php?result=$id&page=1";
                        echo "<script>window.open('$location','_self');</script>";
                    }
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>