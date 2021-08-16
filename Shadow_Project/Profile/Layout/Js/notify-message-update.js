var notify_list = document.getElementById("notify-list"),
    notify_bell = document.getElementById('notify-bell'),
    notify_list = document.getElementById("notify-list");
function notifyMessageUpdate(){
        // this script for update notify message of chat between sender and recever every 2 second
            $.ajax({
                type:'POST',
                url:'Includes/Components/notify-message-update.php',
                data:{
                        user1_ids:notify_list.getAttribute("data-text"),
                        total_ids:notify_list.getAttribute("data-value"),
                        user2_id:notify_list.getAttribute("data-id")
                        //total_notify = bell_notify.textContent
                        //notify_count:notify_list.childElementCount
                    },
                success:function(response){
                    if(response != ""){
                        
                        $("#notify-list").html(response);
                        //alert(response);
                    }
                    
                }
            });
        
    return false;
}
function notifyBellMessageUpdate(){
    // this script for update notify message of chat between sender and recever every 2 second
    $.ajax({
        type:'POST',
        url:'Includes/Components/notify-message-update.php',
        data:{
                total_notify:notify_bell.textContent
                //notify_count:notify_list.childElementCount
            },
        success:function(response){
            if(response != ""){
                //alert(response);
                $("#notify-bell").html(response);
                //alert(response);
            }
            
        }
    });
return false;
}
function notifyUlDataUpdate(){
    // this script for update notify message of chat between sender and recever every 2 second
    $.ajax({
        type:'POST',
        url:'Includes/Components/notify-message-update.php',
        data:{
                total_notify2:notify_bell.textContent
                //notify_count:notify_list.childElementCount
            },
        success:function(response){
            //alert(response);
            if(response != ""){
                //alert(response);
                var x = response.split("-");
                notify_list.setAttribute("data-text",x[0]);
                notify_list.setAttribute("data-value",x[1]);
                notify_list.setAttribute("data-id",x[2]);
                //alert(response);
            }
            
        }
    });
return false;
}
setInterval(function(){

    notifyUlDataUpdate();
    notifyBellMessageUpdate();
    notifyMessageUpdate();
    
    
},2000);