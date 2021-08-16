var about_me = document.getElementById('about-me');

function check(){
    // this script for send data use ajax to php file for change about user
        $.ajax({
            url:'Includes/Components/change-about-me.php',
            type:'POST',
            data:{about_me:about_me.value},
            success:function(response){
                if(response.search("Successfully") > -1){
                        var notify = document.getElementById('notify');
                            notify.classList.add('show');
                        setTimeout(function(){
                            notify.classList.remove('show');
                            window.open(document.URL,'_self');
                        },2000);
                }
                else{
                    alert(response);
                }
            }
            
        });
    return false;
}