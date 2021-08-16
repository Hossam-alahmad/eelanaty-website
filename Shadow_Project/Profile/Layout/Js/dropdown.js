// this script for dropdown menu show and hide
var user_avatar = document.getElementById("user-avatar"),
    dropdown    = document.getElementById("dropdown"),
    notify_bell      = document.getElementById("notify-bell"),
    notify_drop      = document.getElementById("notify-dropdown"); 

    user_avatar.onclick = function(){
        dropdown.classList.toggle("dropdown-show");
        notify_drop.classList.remove("dropdown-show");
    }
    notify_bell.onclick = function(){
        notify_drop.classList.toggle("dropdown-show");
        dropdown.classList.remove("dropdown-show");
    }