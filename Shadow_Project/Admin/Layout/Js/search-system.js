var search_input = document.getElementById("search-inp");

function searchValues(){
    if(search_input.value != ""){
        //alert(search_input.getAttribute("data-text"));
        $.ajax({
            type:"POST",
            url:"Includes/Components/search-values.php",
            data:{
                search_val:search_input.value,
                table:search_input.getAttribute("data-text")
            },
            success:function(response){
                if(response != ""){
                    window.open("index.php?"+response,'_self');
                }
                else{
                    var notify = document.getElementById('notify');
                        notify.classList.add('show-notify','notify-error');
                        notify.firstElementChild.classList.remove('fa-check-circle');
                        notify.firstElementChild.classList.add('fa-exclamation-circle');
                        
                        notify.lastElementChild.textContent = "لايوجد نتائج بحث";
                        search_input.value = "";
                        setTimeout(function(){
                            notify.classList.remove('show-notify');
                        },2000);
                }
            }
        });
    }
    return false;
}