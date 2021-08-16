// this script for show and hide menu bar
var bar = document.getElementById("bars"),
    menu_bar = document.getElementById("menu-bar"),
    overlay = document.getElementById("overlay-body"),
    dropdown_support = document.getElementById("support-collapse"),
    dropdown_list = document.getElementById("dropdown-list"),
    angle_left    = document.getElementById("angle-left"),
    notify_drop      = document.getElementById("notify-dropdown"),
    dropdown = document.getElementById("dropdown");

bar.onclick = function(){
    document.body.classList.add("shift-body");
    notify_drop.classList.add("shift-notify");
    if(dropdown){
        dropdown.classList.add("shift-dropdown");
    }
    menu_bar.classList.add("show-menu");
    overlay.classList.add("show-overlay");
}
overlay.onclick = function(){
    document.body.classList.remove("shift-body");
    menu_bar.classList.remove("show-menu");
    if(dropdown){
        dropdown.classList.remove("shift-dropdown");
    }
    overlay.classList.remove("show-overlay");
    notify_drop.classList.remove("shift-notify");
}
dropdown_support.onclick = function(){
    angle_left.classList.toggle("down");
    dropdown_list.classList.toggle("show-other");
}