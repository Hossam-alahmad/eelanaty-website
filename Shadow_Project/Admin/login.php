<?php include "Includes/Components/header.php";?>
    <body>    
        <div class="login-box">
            <div class="header">
                <h4>تسجيل دخول المسؤول</h4>
            </div>
            <form action="" method="POST" class="form-login" onsubmit="return check();" autocomplete="on">
                <div class="form-group">
                    <label for="admin_email">البريد الإلكتروني</label>
                    <input type="email" class="form-control" name="admin_email" id="email">
                    <span>
                    </span>
                </div>
                <div class="form-group">
                    <label for="admin_pass">كلمة المرور</label>
                    <input type="password" class="form-control" name="admin_pass" id="pass">
                    <span>
                    </span>
                    <i class="fa fa-eye-slash" aria-hidden="true" id="pass-eye"></i>
                </div>
                <input type="submit" class="btn btn-primary form-control" value="تسجيل الدخول">
            </form>
        </div>
        <?php
            $error_class = "";
            $content = "تم تسجيل الدخول بنجاح";
            $class = "fa-check-circle";
            include "Includes/Components/notification.php"
        ?>
        <script src="Layout/Js/jquery-3.4.1.min.js"></script>
        <script src="Layout/Js/popper.min.js"></script>
        <script src="Layout/Js/bootstrap.min.js"></script>
        <script src="Layout/Js/login-validation.js"></script>
        <script src="Layout/Js/password-eye.js"></script>
    </body>
</html>
