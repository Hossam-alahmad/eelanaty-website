var user_message = document.getElementById("message");
function sendMessage(){
    // this script for send message when user sender send it to recever 
    if(user_message.value != ""){
        $.ajax({
            type:'POST',
            url:'Includes/Components/send-message.php',
            data:{
                user_id:user_message.getAttribute('data-text'),
                user_message:user_message.value
            },
            success:function(response){
                user_message.value = "";
            }
        });
    }
    return false;
}