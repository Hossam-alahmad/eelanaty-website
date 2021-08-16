var p_title = document.getElementById("p_title"),
    p_desc  = document.getElementById("p_desc"),
    p_price = document.getElementById("p_price"),
    p_currency = document.getElementById("p_currency"),
    p_location = document.getElementById("p_location"),
    p_category = document.getElementById("p_category"),
    add_ads = document.getElementById("add_ads"),
    p_status = document.getElementById("p_status"),
    p_input = [p_title,p_desc,p_price,p_currency,p_location,p_category,p_status];
    

    add_ads.onclick = function(){
        // this script for send data use ajax to add-new-ads.php file
        var p_input_check = new Array(false,false,false,false,false,false,false);
        // this code for check if all input felds not empty
        for(var i=0; i<p_input.length;i++){
            if(p_input[i].value != ""){
                p_input_check[i] = true;
            }
            else{
                p_input_check[i] = false;
                p_input[i].classList.add("error");
                p_input[i].nextElementSibling.textContent = "الرجاء ملئ الحقل";

            }
        }
        if(p_input[2].value <= 0){
            p_input_check[2] = false;
            p_input[2].classList.add("error");
            p_input[2].nextElementSibling.textContent = "الرجاء وضع السعر";
        }
        // clear all error notification
        setTimeout(function(){
            for(var i=0; i<p_input.length;i++){
                p_input[i].classList.remove("error");
                p_input[i].nextElementSibling.textContent = "";
            }
        }, 2000);
        
        if(p_input_check[0] == true && p_input_check[1] == true && p_input_check[2] == true && p_input_check[3] == true && p_input_check[4] == true && p_input_check[5] == true && p_input_check[6] == true  ){
            return true;
        }
        
        return false;
    }