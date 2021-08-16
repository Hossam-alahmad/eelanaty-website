<?php
    $active = "ads";
    include 'Includes/Components/header.php';
    if(!isset($_GET['cat_id']) || !isset($_GET['page'])){
        echo "<script>window.open('ads.php?cat_id=all&page=1','_self');</script>";
    }
?>
    <!-- Ads Box Started -->
    <div class="ads-box" id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <?php 
                    include 'Includes/Components/sidebar.php'; 
                    $page = 12 ;
                    if(isset($_GET['result'])){
                        include 'Includes/Components/results.php'; 
                    }
                    else{
                        include 'Includes/Components/all-ads.php'; 

                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Ads Box Finished -->
<?php include 'Includes/Components/footer.php'; ?>
<script src="Layout/Js/show-hide-category.js"></script>
</body>
</html>