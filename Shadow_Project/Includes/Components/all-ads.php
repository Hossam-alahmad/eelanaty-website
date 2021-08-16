<!-- Start all ads -->
<div class="col-md-9">
    <div class="all-ads">
        <h4><?php getTitleOfAds(); ?></h4>
        <div class="content">
            <div class="row">
                <?php
                    /*
                        This code for get ads by search or by category
                        if we have post data of search then get ads by search
                        else then get ads by categories
                    */
                    getAds($page);
                    
                ?>
            </div>
        </div>
    </div>
    <div class="pagintation">
            <?php pagantition($page,null,null);?>
    </div>
</div>
<!-- Finised all ads -->