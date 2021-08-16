var first_name = document.getElementById("first_name"),
    last_name  = document.getElementById("last_name"),
    admin_location   = document.getElementById("location"),
    gender     = document.getElementById("gender"),
    days       = document.getElementById("days"),
    months     = document.getElementById("months"),
    years      = document.getElementById("years"),
    inputs     = [first_name,last_name,admin_location];

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
// this event for validation user admin_location 
admin_location.onblur = function(){
    if(admin_location.value.search(/^[0-9]/) > -1){
        admin_location.classList.add("error");
        admin_location.nextElementSibling.textContent = "مكان السكن يجب الا يبدأ برقم";
    }
    else{
        admin_location.classList.remove("error");
        admin_location.nextElementSibling.textContent = "";
    }
}
function changeProfile(){
    /*  
        this function for send data use ajax to change-profile.php
        to save change of user profile information in database
    */
    
    if(first_name.value.length != 0 && last_name.value.length != 0 && admin_location.value.length != 0){
        if(!first_name.classList.contains("error") && !last_name.classList.contains("error") &&  !admin_location.classList.contains("error")){
            $.ajax({
                url:'Includes/Components/change-profile.php',
                type:'POST',
                data:{
                    first_name:first_name.value,
                    last_name:last_name.value,
                    location:admin_location.value,    
                    gender:gender.value,
                    days:days.value,
                    months:months.value,
                    years:years.value
                },
                success:function(response){
                    if(response.search("Successfully") > -1){
                        var notify = document.getElementById('notify');
                            notify.classList.add('show-notify');
                            setTimeout(function(){
                                notify.classList.remove('show-notify');
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