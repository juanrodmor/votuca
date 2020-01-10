var table;
var base_url = window.location.origin+"/votuca/";

$(document).ready(function(){
    $("#logo-btn").css("cursor","pointer");
});

$("#logo-btn").click(function(){
    window.location.replace(base_url+"Elector_controller/");
});

$("#cerrar-ses-voto").unbind().click(function(){
    window.location.replace(base_url+"login_controller/logout");
});