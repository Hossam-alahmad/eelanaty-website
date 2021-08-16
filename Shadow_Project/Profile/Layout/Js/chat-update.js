var chat_content = document.getElementById("chat-content");
function chatUpdate(){
        // this script for update message of chat between sender and recever every 2 second
        $.ajax({
            type:'POST',
            url:'Includes/Components/chat-update.php',
            data:{
                    user2_id:chat_content.getAttribute('data-text'),
                    message_count:chat_content.childElementCount
                },
            success:function(response){
                if(response != ""){
                    $("#chat-content").append(response);
                    chat_content.scrollTop = chat_content.scrollHeight;
                }
                
            }
        });
    return false;
}
setInterval(function(){
    chatUpdate();
},2000);