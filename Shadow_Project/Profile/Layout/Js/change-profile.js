var first_name = document.getElementById("first_name"),
    last_name  = document.getElementById("last_name"),
    user_location   = document.getElementById("location"),
    phone      = document.getElementById("phone"),
    gender     = document.getElementById("gender"),
    days       = document.getElementById("days"),
    months     = document.getElementById("months"),
    years      = document.getElementById("years"),
    inputs     = [first_name,last_name,user_location,phone];

// this event for validation user firstname 
first_name.onblur = function(){
    if(first_name.value.search(/^[0-9]/) > -1){
        first_name.classList.add("error");
        first_name.nextElementSibling.textContent = "الاسم يجب الا يبدأ برقم";
    }
    else{
        first_name.classList.remove("error");
        first_name.nextElementSibling.textContent = "";
    }
}
// this event for validation user lastname 
last_name.onblur = function(){
    if(last_name.value.search(/^[0-9]/) > -1){
        last_name.classList.add("error");
        last_name.nextElementSibling.textContent = "اسم العائلة يجب الا يبدأ برقم";
    }
    else{
        last_name.classList.remove("error");
        last_name.nextElementSibling.textContent = "";
    }
}
// this event for validation user location 
user_location.onblur = function(){
    if(user_location.value.search(/^[0-9]/) > -1){
        user_location.classList.add("error");
        user_location.nextElementSibling.textContent = "مكان السكن يجب الا يبدأ برقم";
    }
    else{
        user_location.classList.remove("error");
        user_location.nextElementSibling.textContent = "";
    }
}
// this event for validation user phone
phone.onblur = function(){
        if(phone.value.length != 0){
            if(phone.value.search(/^[0+]{1}[0-9]*$/g) > -1 && (phone.value.length >= 10 && phone.value.length <= 13)){
                phone.nextElementSibling.textContent = "";
                phone.classList.remove("error");
            }
            else{
                phone.classList.add("error");
                phone.nextElementSibling.textContent = "الرجاء ادخال رقم هاتف صحيح";
            }
        }
        else{
            phone.nextElementSibling.textContent = "";
                phone.classList.remove("error");
        }
}

function check(){
    /*  
        this function for send data use ajax to change-profile.php
        to save change of user profile information in database
    */
    
    if(first_name.value.length != 0 && last_name.value.length != 0 && user_location.value.length != 0){
        if(!first_name.classList.contains("error") && !last_name.classList.contains("error") && !phone.classList.contains("error") && !user_location.classList.contains("error")){
            $.ajax({
                type:'POST',
                url:"Includes/Components/change-profile.php",
                data:{
                    first_name:first_name.value,
                    last_name:last_name.value,
                    phone:phone.value,
                    location:user_location.value,    
                    gender:gender.value,
                    days:days.value,
                    months:months.value,
                    years:years.value
                },
                success:function(response){
                    if(response.search("Successfully") > -1){
                        var notify = document.getElementById('notify');
                            notify.classList.add('show');
                        setTimeout(function(){
                            notify.classList.remove('show');
                            window.open(document.URL,'_self');
                        },2000);
                    }
                    else{
                        alert(response);
                    }
                }
            });
        }
    }
    else{
        for(var i=0;i<3;i++){
            if(inputs[i].value.length == 0){
                inputs[i].classList.add("error");
                inputs[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";
            }
        }
    }
    return false;
}