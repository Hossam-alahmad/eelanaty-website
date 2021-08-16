<?php include 'Includes/Components/header.php'; ?>
    <!-- Start Register Box -->
    <div class="register" id="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="offset-md-1 col-md-5">
                    <h2>إنشاء حساب جديد</h2>
                    <form autocomplete="on" method="POST" enctype="multipart/form-data" onsubmit="return check();">
                        <div class="form-group">
                            <label>الاسم الأول:</label>
                            <input type="text" class="form-control" name="firstname" id="firstname">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>اسم العائلة:</label>
                            <input type="text" class="form-control" name="lastname" id="lastname">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>البريد الالكتروني:</label>
                            <input type="email" class="form-control" name="email" id="email">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور:</label>
                            <input type="password" class="form-control" name="pass" id="pass">
                            <span></span>
                            <i class="fa fa-eye-slash" id="pass-eye"></i>
                        </div>
                        <div class="form-group">
                            <label>تأكيد كلمة المرور:</label>
                            <input type="password" class="form-control" name="conf_pass" id="conf-pass">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <p class="pull-right">بتسجيلك في المنصة فإنك توافق على شروط الاستخدام وسياسة الخصوصية</p>
                            <input type="submit" class="btn btn-primary pull-left" value="إنشاء الحساب" name="register" id="register">
                        </div>
                    </form>
                    <hr>
                    <div class="other-reg">
                        <p>يمكنك إنشاء حساب عن طريق</p>
                        <div class="row">
                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-box">
                        <img class="img-responsive" src="Layout/Images/register.jpg" alt="register-image">
                    </div>
                </div>
            </div>
            <?php 
                    $content = "تم ارسال رسالة الى بريدك الالكتروني لتفعيل حسابك";
                    $class = "fa-check-circle";
                    $error_class= "";
                    include "Includes/Components/notification.php";
            ?>
        </div>
    </div>
    <!-- Finished Register Box -->
<?php include 'Includes/Components/footer.php'; ?>
<script src="Layout/Js/register-validation.js"></script>
<script src="Layout/Js/password-eye.js"></script>
<script src="Layout/Js/google-api-signIn.js"></script>
</body>
</html>