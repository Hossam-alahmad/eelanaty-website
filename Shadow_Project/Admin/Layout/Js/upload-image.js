// this script for upload profile image
var admin_image = document.getElementById("admin-image");

// onclick event 
admin_image.onclick = function(){
    var interval = setInterval(function(){
        if(admin_image.value != ""){
            uploadImage();
            clearInterval(interval);
        }
    },2000);
}
function uploadImage(){
    // ajax function for send data to php file upload-image.php
    var fd = new FormData();
    var files = $("#admin-image")[0].files[0];
    fd.append('admin_image',files);
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