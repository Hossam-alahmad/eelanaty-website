var service_title = document.getElementById("service_title"),
    service_desc = document.getElementById("service_desc"),
    service_icon = document.getElementById("service_icon"),
    input = [service_title,service_desc,service_icon];


function serviceValidation(){
    if(service_title.value != "" && service_icon.value != "" && service_desc.value != "" ){
        return true;
    }
    else{
        for(var i=0;i<input.length;i++){
            if(input[i].value == ""){
                input[i].classList.add("error");
                input[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";
            }
        }
        setTimeout(function(){
            for(var i=0;i<input.length;i++){
                if(input[i].value == ""){
                    input[i].classList.remove("error");
                    input[i].nextElementSibling.textContent = "";
                }
            } 
        }, 2000);
    }
    return false;    
}