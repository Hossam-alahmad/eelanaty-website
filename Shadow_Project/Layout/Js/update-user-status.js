// this script for check user status online/offline every 5 second
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