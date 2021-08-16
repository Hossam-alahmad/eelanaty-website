<!-- Start all ads -->
<div class="col-md-9">
    <div class="all-ads">
        <h4>نتائج البحث</h4>
        <div class="content">
            <div class="row">
                <?php
                    /*
                        This code for get ads by search or by category
                        if we have post data of search then get ads by search
                        else then get ads by categories
                    */
                    
                    $found = false;
                    $id = "";
                    if($_GET['result'] != ""){
                        $found = true;
                        $id = $_GET['result'];
                    }
                    getUsersAdsBySearch($page,$found,$id);
                ?>
            </div>
        </div>
    </div>
    <div class="pagintation">
            <?php pagantition($page,$found,$id);?>
    </div>
</div>
<!-- Finised all ads -->