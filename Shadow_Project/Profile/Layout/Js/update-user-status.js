// this script for check user status 
function updateStatus(){
    $.ajax({
        url:'Includes/Components/update-status.php',
        success:function(){
        }
    });
}
setInterval(function(){
    updateStatus();
},5000);