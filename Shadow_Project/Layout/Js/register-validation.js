// this scipt for test validation of inputs when register into website
var firstname = document.getElementById("firstname"),
    lastname = document.getElementById("lastname"),
    email    = document.getElementById("email"),
    pass     = document.getElementById("pass"),
    conf_pass = document.getElementById("conf-pass"),
    notify = document.getElementById('notify');
    checked  = 0,
    input    = [firstname,lastname,email,pass,conf_pass],
    valid_input = [false,false,false,false,false];


firstname.onblur = function(){
    if(firstname.value.length == 0){
        firstname.classList.add("error");
        firstname.nextElementSibling.textContent = "الرجاء ملئ الحقل";
        valid_input[0] = false;
    }
}
firstname.onkeyup = function(){
    if(firstname.value.search("^[0-9]") > -1){
        firstname.classList.add("error");
        firstname.nextElementSibling.textContent = "لا يمكن البدء برقم";
        valid_input[0] = false;
    }
    else{
        firstname.classList.remove("error");
        firstname.nextElementSibling.textContent = "";
        valid_input[0] = true;
    }
}
lastname.onblur = function(){
    if(lastname.value.length == 0){
        lastname.classList.add("error");
        lastname.nextElementSibling.textContent = "الرجاء ملئ الحقل";
        valid_input[1] = false;
    }
}
lastname.onkeyup = function(){
    if(lastname.value.search("^[0-9]") > -1){
        lastname.classList.add("error");
        lastname.nextElementSibling.textContent = "لا يمكن البدء برقم";
        valid_input[1] = false;
    }
    else{
        lastname.classList.remove("error");
        lastname.nextElementSibling.textContent = "";
        valid_input[1] = true;
    }
}
email.onblur = function(){
    if(email.value.search(/\S+@\S+\.\S+/) > -1){
        email.classList.remove("error");
        email.nextElementSibling.textContent = "";
        valid_input[2] = true;
    }
    else{
        email.classList.add("error");
        email.nextElementSibling.textContent = "الايميل غير صحيح";
        valid_input[2] = false;
    }
    if(email.value.length == 0){
        email.classList.add("error");
        email.nextElementSibling.textContent = "الرجاء ملئ الحقل";
        valid_input[2] = false;
    }
}
pass.onblur = function(){
    if(pass.value.length < 5){
        pass.classList.add("error");
        pass.nextElementSibling.textContent = "كلمة المرور ضعيفة";
        valid_input[3] = false;
    }
    else if(pass.value.length > 5){
        if(pass.value.search("[a-z]") > -1 && pass.value.search("[0-9]" > -1 && pass.value.search("[A-Z]") > -1)){
            pass.classList.remove("error");
            pass.nextElementSibling.textContent = "";
            valid_input[3] = true;
        }
        else{
            pass.classList.add("error");
            pass.nextElementSibling.textContent = "كلمة المرور يجب ان تحتوي على الاقل حرف صغير،حرف كبير،ارقام";
            valid_input[3] = false;
        }
    }
    if(pass.value.length == 0){
        pass.classList.add("error");
        pass.nextElementSibling.textContent = "الرجاء ملئ الحقل";
        valid_input[3] = false;
    }
    
}
conf_pass.onblur = function(){
    if(pass.value !== conf_pass.value){
        conf_pass.classList.add("error");
        conf_pass.nextElementSibling.textContent = "كلمة المرور غير مطابقة";
        valid_input[4] = false;
    }
    else{
        conf_pass.classList.remove("error");
        conf_pass.nextElementSibling.textContent = "";
        valid_input[4] = true;
    }
    if(conf_pass.value.length === 0){
        conf_pass.classList.add("error");
        conf_pass.nextElementSibling.textContent = "الرجاء ملئ الحقل";
        valid_input[4] = false;
    }
}
conf_pass.onkeyup = function(){
    if(conf_pass.value.length > 0){
        conf_pass.classList.remove("error");
        conf_pass.nextElementSibling.textContent = "";
    }
}

function check(){
    // this script for send data use ajax to reg-validation.php file
    if(valid_input[0] == true && valid_input[1] == true && valid_input[2] == true && valid_input[3] == true && valid_input[4] == true){
        $.ajax({
            type: 'POST',
            url: 'Includes/Components/reg-validation.php',
            data:{
                firstname:firstname.value,
                lastname:lastname.value,
                email:email.value,
                password:pass.value
            },
            success:function(response){
                if(response.search("exist") > -1){
                    email.classList.add("erorr");
                    email.nextElementSibling.textContent = "هذا الايميل مستخدم";
                }
                else if(response.search("success")>-1){
                    var notify = document.getElementById('notify');
                            notify.classList.add('show');
                            setTimeout(function(){
                                notify.classList.remove('show');
                                window.open('login.php','_self');
                            },2000);
                    //window.open("Profile/personal-profile.php?account","_self");
                }
                else{
                    alert("لم يتم انشاء الحساب ");
                }
            }
        })
    }
    else{
        for(var i = 0;i<5;i++){
            if(input[i].value.length == 0){
                input[i].focus();
                input[i].classList.add("error");
                input[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";
            }
        }
    }
    return false;
}