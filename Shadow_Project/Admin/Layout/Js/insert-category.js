var category_title = document.getElementById("category_title"),
    category_icon = document.getElementById("category_icon"),
    category_keywords = document.getElementById("category_keywords"),
    category_desc = document.getElementById("category_desc"),
    input = [category_title,category_icon,category_keywords,category_desc];


function catValidation(){
    if(category_title.value != "" && category_icon.value != "" && category_keywords.value != "" && category_desc.value != ""){
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