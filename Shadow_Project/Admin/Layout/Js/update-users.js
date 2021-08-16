

function updateUsersStatus(){
    $.ajax({
        type:"POST",
        url:"Includes/Components/update-users-status.php",
        data:{page:$("tbody").attr('data-text'),
            ids:$("tbody").attr('data-value')},
        success:function(response){
            $("tbody").html(response);
        }
    });
}
setInterval(function(){
    updateUsersStatus();
},2000);