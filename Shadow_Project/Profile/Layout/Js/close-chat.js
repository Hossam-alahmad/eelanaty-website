var close_chat = document.getElementById("close-chat");

close_chat.onclick = function(){
    $.ajax({
        type:'POST',
        url:'Includes/Components/close-chat.php',
        data:{user2_id:close_chat.getAttribute("data-text")},
        success:function(response){
            
        }
    });
}