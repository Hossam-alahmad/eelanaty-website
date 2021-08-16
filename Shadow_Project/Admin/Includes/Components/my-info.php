<!-- Start My-Info -->
<div class="col-md-8">
    <form method="POST" enctype="multipart/form-data" onsubmit="return changeProfile();">
        <div class="form-group">
            <label>الاسم الأول:</label>
            <input type="text" class="form-control" name="first_name" id="first_name" <?php if($admin_first != "")  echo "value = '$admin_first'"; ?>>
            <span></span>
        </div>
        <div class="form-group">
            <label>اسم العائلة:</label>
            <input type="text" class="form-control" name="last_name" id="last_name" <?php if($admin_last !="")  echo "value = '$admin_last'"; ?>>
            <span></span>
        </div>
        <div class="form-group">
            <label>مكان السكن:</label>
            <input type="text" class="form-control" name="location" id="location" placeholder="مثال: سوريا - إدلب المدينة" <?php if($admin_location != "")  echo "value = '$admin_location'"; ?>>
            <span></span>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-2">
                <div class="form-group">
                    <label>الجنس <span>(اختياري)</span>:</label>
                    <select class="form-control" name="gender" id="gender">
                        <option selected disabled></option>
                        <option <?php if($admin_gender == 'ذكر')  echo "selected"; ?> value="ذكر">ذكر</option>
                        <option <?php if($admin_gender == 'انثى')  echo "selected"; ?>  value="انثى">انثى</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ الميلاد <span>(اختياري)</span>:</label>
                    <?php 
                        //for days
                        $admin_birth = explode("-",$admin_birth);

                        echo "
                            <select class='form-control' name='days' id='days'>
                                <option selected disabled value = 'اليوم'>اليوم</option>
                            ";
                            for($i = 1 ;$i <= 31;$i++){
                                if($admin_birth[2] == $i){
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
                                if($admin_birth[1] == $i){
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
                            if($admin_birth[0] == $i){
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