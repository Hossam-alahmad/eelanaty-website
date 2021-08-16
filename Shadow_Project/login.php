<?php include 'Includes/Components/header.php'; ?>
    <!-- Start Login Box s-->
    <div class="login" id="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="offset-md-1 col-md-5">
                    
                    <h2>تسجيل الدخول</h2>
                    <form autocomplete="on" enctype="multipart/form-data" method="POST" onsubmit="return check();">
                        <div class="form-group">
                            <label>البريد الالكتروني:</label>
                            <input type="email" class="form-control" name="email" id="email">
                            <span></span>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور:</label>
                            <input type="password" class="form-control" name="pass" id="pass" id="pass">
                            <span></span>
                            <i class="fa fa-eye-slash" id="pass-eye"></i>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary pull-left" value="تسجيل الدخول" name="register">
                            <!--<a href="#">هل نسيت كلمة المرور؟</a>-->
                        </div>
                    </form>
                    <hr>
                    <div class="other-reg">
                        <p>يمكنك تسجل الدخول عن طريق</p>
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
        </div>
    </div>
    <!-- Finised Login Box -->
    <?php include 'Includes/Components/footer.php'; ?>
    <script src="Layout/Js/login-validation.js"></script>
    <script src="Layout/Js/password-eye.js"></script>
    <script src="Layout/Js/google-api-signIn.js"></script>
</body>
</html>