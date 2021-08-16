// this script for show and hide navbar
var nav = document.getElementById("navbar");
var dropdown = document.getElementById("dropdown");
var notify_drop      = document.getElementById("notify-dropdown"); 
var page_wrapper = document.getElementById("page-wrapper");
    new_top  = 0,
    old_top = 0;
window.onscroll = function(){
    new_top = document.documentElement.scrollTop;
    if(document.documentElement.scrollTop > 80){
        nav.classList.add("nav-fixed");
        nav.classList.add("nav-top");
        if(dropdown){
            dropdown.classList.add("dropdown-scroll");
        }
        if(notify_drop){
            notify_drop.classList.add("dropdown-scroll");
        }
        page_wrapper.classList.add("page-fixed");
    }
    if(old_top > new_top){
        nav.classList.remove("nav-top");
        if(dropdown){
            dropdown.classList.remove("dropdown-scroll");
        }
        if(notify_drop){
            notify_drop.classList.remove("dropdown-scroll");
        }
    }
    if(document.documentElement.scrollTop <10){
        nav.classList.remove("nav-fixed");
        nav.classList.remove("nav-top");
        if(dropdown){
            dropdown.classList.remove("dropdown-scroll");
        }
        if(notify_drop){
            notify_drop.classList.remove("dropdown-scroll");
        }
        page_wrapper.classList.remove("page-fixed");
    }
    old_top = new_top;
}