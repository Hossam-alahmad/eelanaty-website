<!-- Start My-Info -->
<div class="col-md-8">
    <form method="POST" enctype="multipart/form-data" onsubmit="return check();">
        <div class="form-group">
            <label>الاسم الأول:</label>
            <input type="text" class="form-control" name="first_name" id="first_name" <?php if($user_firstname != "")  echo "value = '$user_firstname'"; ?>>
            <span></span>
        </div>
        <div class="form-group">
                                    <label>اسم العائلة:</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" <?php if($user_lastname !="")  echo "value = '$user_lastname'"; ?>>
                                    <span></span>
        </div>
        <div class="form-group">
            <label>مكان السكن:</label>
            <input type="text" class="form-control" name="location" id="location" placeholder="مثال: سوريا - إدلب المدينة" <?php if($user_location != "")  echo "value = '$user_location'"; ?>>
            <span></span>
        </div>
        <div class="form-group">
            <label>رقم الهاتف <span>(اختياري)</span>:</label>
            <input type="text" class="form-control" name="phone" id="phone" <?php if($user_phone != "0")  echo "value = '0$user_phone'"; ?>>
            <span></span>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-1">
                <div class="form-group">
                    <label>الجنس <span>(اختياري)</span>:</label>
                    <select class="form-control" name="gender" id="gender">
                        <option selected disabled></option>
                        <option <?php if($user_gender == 'ذكر')  echo "selected"; ?> value="ذكر">ذكر</option>
                        <option <?php if($user_gender == 'انثى')  echo "selected"; ?>  value="انثى">انثى</option>
                    </select>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label>تاريخ الميلاد <span>(اختياري)</span>:</label>
                    <?php 
                        // for days
                        $user_birthday = explode("-",$user_birthday);

                        echo "
                            <select class='form-control' name='days' id='days'>
                                <option selected disabled value = 'اليوم'>اليوم</option>
                            ";
                            for($i = 1 ;$i <= 31;$i++){
                                if($user_birthday[2] == $i){
                                    echo "<option selected value=$i>$i</option>";
                                }
                                else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        echo "
                            </select>
                            ";
                        // for months
                        echo "
                            <select class='form-control' name='months' id='months'>
                                <option selected disabled value = 'الشهر'>الشهر</option>
                            ";
                            for($i = 1 ;$i <= 12;$i++){
                                if($user_birthday[1] == $i){
                                    echo "<option selected value=$i>$i</option>";
                                }
                                else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        echo "
                            </select>
                        ";
                        // for Years
                        echo "
                            <select class='form-control' name='years' id='years'>
                                <option selected disabled value = 'السنة'>السنة</option>
                        ";
                        for($i = 1950 ;$i <= 2020;$i++){
                            if($user_birthday[0] == $i){
                                echo "<option selected value=$i>$i</option>";
                            }
                            else{
                                echo "<option value=$i>$i</option>";
                            }
                        }
                        echo "
                            </select>
                        ";
                    ?>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary pull-left" name="save_change" id="save-change" value="حفظ التغييرات">
    </form>
</div>
<!-- Finished My-Info -->