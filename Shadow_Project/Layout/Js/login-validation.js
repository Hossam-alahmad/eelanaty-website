// this scipt for test validation of inputs when login into website
var email    = document.getElementById("email"),
    pass     = document.getElementById("pass"),
    input    = [email,pass],
    valid_input = [false,false];

    email.onblur = function(){
        if(email.value.length === 0){
            email.classList.add("error");
            email.nextElementSibling.textContent = "الرجاء ملئ الحقل";
            valid_input[0] = false;
        }
        else if(email.value.search(/\S+@\S+\.\S+/) > -1){
            email.classList.remove("error");
            email.nextElementSibling.textContent = "";
            valid_input[0] = true;
        }
        else{
            email.classList.add("error");
            email.nextElementSibling.textContent = "الايميل غير صحيح";
            valid_input[0] = false;
        }
    }
    pass.onblur = function(){
        if(pass.value.length == 0){
            pass.classList.add("error");
            pass.nextElementSibling.textContent = "الرجاء ملئ الحقل";
            valid_input[1] = false;
        }
        else{
            pass.classList.remove("error");
            pass.nextElementSibling.textContent = "";
            valid_input[1] = true;
        }
        
    }
    function check(){
        // this script for send data use ajax to login-validation.php file
        if(valid_input[0] == true && valid_input[1]){
            $.ajax({
                type: 'POST',
                url: 'Includes/Components/login-validation.php',
                data:{
                    email:email.value,
                    password:pass.value
                },
                success:function(response){
                    if(response.search("not found") > -1){
                        email.classList.add("erorr");
                        email.nextElementSibling.textContent = "هذا الايميل غير موجود";
                    }
                    else if(response.search("invalid password") > -1){
                        pass.classList.add("erorr");
                        pass.nextElementSibling.textContent = "كلمة المرور غير صحيحة";
                    }
                    else{
                        window.open("Profile/personal-profile.php?account","_self");
                    }
                }
            })
        }
        else{
            for(var i = 0;i<input.length;i++){
                if(input[i].value.length == 0){
                    input[i].focus();
                    input[i].classList.add("error");
                    input[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";
                }
            }
        }
        return false;
    }