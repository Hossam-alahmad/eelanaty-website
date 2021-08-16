var span = document.getElementById("show-hide-cat"),
    ul_list = document.getElementById("category-list");


if(span){
    span.onclick = function(){
        if(span.classList.contains("show-cat")){
            span.textContent = "إخفاء";
            span.classList.remove("show-cat");
            span.classList.add("hide-cat");
            ul_list.classList.remove("hide-list");
        }
        else{
            span.textContent = "إظهار";
            span.classList.remove("hide-cat");
            span.classList.add("show-cat");
            ul_list.classList.add("hide-list");
        }
    }
}