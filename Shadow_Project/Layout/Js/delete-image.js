// this script for delete image of proudct in edit-ads.php
var delete_img = document.querySelectorAll(".swiper-slide span");
function deleteImage(i){

    var product_image = delete_img[i].getAttribute("data-text");
        product_id    = delete_img[i].getAttribute("data-value");
    $.ajax({
        type:'POST',
        url:'Includes/Components/delete-image.php',
        data:{
            image:product_image,
            product_id:product_id
        },
        success:function(response){
            if(response.search('success') > -1){
                window.open(document.URL,'_self');
            }
            else{
                alert(response);
            }
        }
    });
}