var table;
var base_url = window.location.origin+"/votuca/";

$(document).ready(function(){
    // var o;
    // $ajax({
    //     url: "php/identidades.php",
    //     success : function(data) {
    //         o = JSON.parse(data);//A la variable le asigno el json decodificado
    //     }
    // });
    table = $('#voto_usuario').DataTable({
        "dom": '<"bottom"p><"clear">',
        "scrollY":        false,
        "scrollX": false,
        "scrollCollapse": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "paging":         false,
        "ordering": false
    });
    $("#logo-btn").css("cursor","pointer");
});

$("#logo-btn").click(function(){
    window.location.replace(base_url+"Elector_controller/");
});

$("#cerrar-ses-voto").unbind().click(function(){
    window.location.replace(base_url+"login_controller/logout");
});