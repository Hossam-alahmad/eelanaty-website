// this script for show and hide navbar
var nav = document.getElementById("nav");
var dropdown = document.getElementById("dropdown-menu");
var sidebar = document.getElementById("sidebar");
var page_wrapper = document.getElementById("page-wrapper");
window.onscroll = function(){
    if(document.documentElement.scrollTop > 0){
        nav.classList.add("fixed");
        page_wrapper.classList.add("page-fixed");
    }
    else{
        nav.classList.remove("fixed");
        page_wrapper.classList.remove("page-fixed");
    }

}