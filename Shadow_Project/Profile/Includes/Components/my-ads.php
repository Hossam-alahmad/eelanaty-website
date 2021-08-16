<!-- Start My-Ads -->
<div class="col-md-9">  
    <div class="my-ads">
        <div class="heading">
            <h4>إعلاناتي</h4>
        </div>
        <div class="content">
            <div class="row">
                <?php
                    // this function for get ads by category
                    $page = 6;
                    getAds($page); 
                ?>
            </div>
        </div>
    </div>
    <div class="pagintation">
            <?php pagantition($page);?>
    </div>
</div>
<!-- Finished My-Ads -->