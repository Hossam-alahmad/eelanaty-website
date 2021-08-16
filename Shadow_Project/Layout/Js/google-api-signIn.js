// this script for login and sign using google api
function onSignIn(googleUser){
    var profile = googleUser.getBasicProfile(),
        username = profile.getName(), // username,
        email    = profile.getEmail(), // email,
        firstname = profile.getGivenName(), // firstname,
        lastname  = profile.getFamilyName(); // lastname;  
        
        $.ajax({
            type:'post',
            url:"Includes/Components/sign-in-using-google.php",
            data:{
                user_name:username,
                user_email:email,
                first_name:firstname,
                last_name:lastname
            },
            success:function(response){
                if(response.search("success") > -1){
                    window.open("Profile/personal-profile.php?account","_self");
                }
                else{
                    alert(response);
                }
            }
        });
}