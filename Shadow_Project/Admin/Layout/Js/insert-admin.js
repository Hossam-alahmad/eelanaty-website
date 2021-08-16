// this scipt for test validation of inputs when register into website
var first_name = document.getElementById("first_name"),
    last_name = document.getElementById("last_name"),
    email    = document.getElementById("email"),
    level    = document.getElementById("level"),
    pass     = document.getElementById("password"),
    input    = [first_name,last_name,email,pass,level],
    valid_input = [false,false,false,false,false];


    first_name.onblur = function(){
        if(first_name.value.length == 0){
            first_name.classList.add("error");
            first_name.nextElementSibling.textContent = "الرجاء ملئ الحقل";
            valid_input[0] = false;
        }
    }
    first_name.onkeyup = function(){
        if(first_name.value.search("^[0-9]") > -1){
            first_name.classList.add("error");
            first_name.nextElementSibling.textContent = "لا يمكن البدء برقم";
            valid_input[0] = false;
        }
        else{
            first_name.classList.remove("error");
            first_name.nextElementSibling.textContent = "";
            valid_input[0] = true;
        }
    }
    last_name.onblur = function(){
        if(last_name.value.length == 0){
            last_name.classList.add("error");
            last_name.nextElementSibling.textContent = "الرجاء ملئ الحقل";
            valid_input[1] = false;
        }
    }
    last_name.onkeyup = function(){
        if(last_name.value.search("^[0-9]") > -1){
            last_name.classList.add("error");
            last_name.nextElementSibling.textContent = "لا يمكن البدء برقم";
            valid_input[1] = false;
        }
        else{
            last_name.classList.remove("error");
            last_name.nextElementSibling.textContent = "";
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
    
    level.onblur = function(){
        if(level.value != ""){
            first_name.classList.remove("error");
            first_name.nextElementSibling.textContent = "";
            valid_input[4] = true;
        }
    }
function adminValidation(){
    if(valid_input[0] == true && valid_input[1] == true && valid_input[2] == true && valid_input[3] == true && valid_input[4] == true){
        return true;
    }
    else{
        for(var i = 0;i<input.length;i++){
            if(input[i].value.length == 0){
                input[i].classList.add("error");
                input[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";
            }
        }
        setTimeout(function(){
            for(var i=0;i<input.length;i++){
                if(input[i].value.length == 0){
                    input[i].classList.remove("error");
                    input[i].nextElementSibling.textContent = "";
                }
            } 
        }, 2000);
    }
    return false;    
}