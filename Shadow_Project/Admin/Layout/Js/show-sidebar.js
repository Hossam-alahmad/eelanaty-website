var bars = document.getElementById("bars"),
    sidebar = document.getElementById("sidebar"),
    overlay = document.getElementById("overlay");

bars.onclick = function(){
    sidebar.classList.toggle("show-sidebar");
    overlay.classList.toggle("show-overlay");
}
overlay.onclick = function(){
    sidebar.classList.remove("show-sidebar");
    overlay.classList.remove("show-overlay");
}