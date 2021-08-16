<div class="row header">
    <div class="col-lg-12">
        <h1 class="page-header">لوحة التحكم</h1>
        <hr>
        <ul class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> لوحة التحكم
            </li>
        </ul>
    </div>
</div>
<div class="analyse">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card-box">
                <div class="row">
                    <div class="content col-sm-7">
                        <div>
                            <span>الحسابات</span>
                            <span>0</span>
                        </div>
                    </div>
                    <div class="icon col-sm-5">
                        <i class="fa fa-money fa5x"></i>
                    </div>
                </div>
                <a href="index.php?view_products">
                    <div class="footer">
                        <span class="pull-left">
                            <i class="fa fa-arrow-circle-left"></i>
                        </span>
                        <span class="pull-right">
                            عرض التفاصيل
                        </span>
                    </div>
                </a>           
            </div>
        </div>        
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card-box">
                <div class="row">
                    <div class="content col-sm-7">
                        <div>
                            <span>المستخدمين</span>
                            <span><?php echo getTotal("users"); ?></span>
                        </div>
                    </div>
                    <div class="icon col-sm-5">
                        <i class="fa fa-users fa5x"></i>
                    </div>
                </div>
                <a href="index.php?view_users">
                    <div class="footer">
                        <span class="pull-left">
                            <i class="fa fa-arrow-circle-left"></i>
                        </span>
                        <span class="pull-right">
                            عرض التفاصيل
                        </span>
                    </div>
                </a>           
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card-box">
                <div class="row">
                    <div class="content col-sm-7">
                        <div>
                            <span>الاقسام</span>
                            <span><?php echo getTotal("categories");?></span>
                        </div>
                    </div>
                    <div class="icon col-sm-5">
                        <i class="fa fa-tag fa5x"></i>
                    </div>
                </div>
                <a href="index.php?view_cats">
                    <div class="footer">
                        <span class="pull-left">
                            <i class="fa fa-arrow-circle-left"></i>
                        </span>
                        <span class="pull-right">
                            عرض التفاصيل    
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card-box">
                <div class="row">
                    <div class="content col-sm-7">
                        <div>
                            <span>الإعلانات</span>  
                            <span><?php  echo getTotal("products"); ?></span>
                        </div>
                    </div>
                    <div class="icon col-sm-5">
                        <i class="fa fa-briefcase fa5x"></i>
                    </div>
                </div>
                <a href="index.php?view_ads">
                    <div class="footer">
                        <span class="pull-left">
                            <i class="fa fa-arrow-circle-left"></i>
                        </span>
                        <span class="pull-right">
                            عرض التفاصيل
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row ads">
    <div class="new-ads">
        <div class="header">
            <i class="fa fa-briefcase"></i> إعلانات جديدة
        </div>
        <div class="ads-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>الرقم:</th>
                        <th>رقم الإعلان:</th>
                        <th>بريد المعلن:</th>
                        <th>اسم الإعلان:</th>
                        <th>السعر:</th>
                        <th>الموقع:</th>
                        <th>القسم:</th>
                    </tr>
                </thead>
                <?php viewNewAds(); ?>
            </table>
            <a href="index.php?view_ads">
                <spnn class="pull-right">عرض كل الإعلانات <i class="fa fa-arrow-circle-left"></i></spn>
            </a>
        </div>
    </div>
</div>
