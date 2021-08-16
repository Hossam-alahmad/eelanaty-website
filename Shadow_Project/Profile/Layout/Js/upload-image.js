// this script for upload profile image
var user_image = document.getElementById("user-image");

// onclick event 
user_image.onclick = function(){
    var interval = setInterval(function(){
        if(user_image.value != ""){
            uploadImage();
            clearInterval(interval);
        }
    },2000);
}
function uploadImage(){
    // ajax function for send data to php file upload-image.php
    var fd = new FormData();
    var files = $("#user-image")[0].files[0];
    fd.append('user_image',files);
    $.ajax({
        url:'Includes/Components/upload-image.php',
        type:'POST', 
        data:fd,
        contentType:false,
        processData:false,
        success:function(response){
            if(response.search("Success") > -1){
                window.open(document.URL,"_self");
            }
            else{
                alert(response);
            }
        }
    });
}