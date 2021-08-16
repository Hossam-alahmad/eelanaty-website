// this script for show and hide password
var pass_eye = document.getElementById("pass-eye");
pass_eye.onclick = function(){
    if(pass_eye.classList.contains("fa-eye-slash")){
        pass_eye.classList.remove("fa-eye-slash");
        pass_eye.classList.add("fa-eye");
        pass.setAttribute("type","text");
    }
    else{
        pass_eye.classList.add("fa-eye-slash");
        pass_eye.classList.remove("fa-eye");
        pass.setAttribute("type","password");
    }
}