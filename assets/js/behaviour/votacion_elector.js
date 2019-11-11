var table;
var base_url = window.location.origin+"/Proyectopinf/";
var select = false;

$(document).ready(function(){
    var o;
    // $ajax({
    //     url: "php/identidades.php",
    //     success : function(data) {
    //         o = JSON.parse(data);//A la variable le asigno el json decodificado
    //     }
    // });
    table = $('#votaciones_usuario').DataTable({
        dom: 'Bfrtip',
        scrollY:        '50vh',
        scrollCollapse: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        paging:         true,
        // data: o,
        // columns:[
        //     {"data": "o.titulo"},
        //     {"data": "o.descripcion"},
        //     {"data": "o.fechaInicio"},
        //     {"data": "o.fechaFin"},
        // ],
        buttons: [
            {
                text: 'Seleccionar votación',
                action: function ( e, dt, node, config ) {
                    console.log(select);
                    if(select == true){
                        html="";
                        html+='<div id="modal_vot" class="modal" tabindex="-1" role="dialog" style="width:auto;height:auto;align:center;">'+
                            '<div class="modal-dialog" role="document">'+
                            '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<h5 class="modal-title">Votación</h5>'+
                                '<button id="btn-md-cls" type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<form>'+
                                    '<input type="radio" name="voto" value="si">&nbsp;si<br>'+
                                    '<input type="radio" name="voto" value="no">&nbsp;no<br>'+
                                    '<input type="radio" name="voto" value="abstencion">&nbsp;voto en blanco<br>'+
                                '</form>'+
                                '<i style="float:right;margin-top: -18%;margin-right: 16%;display:inline-block;" class="fa-5x fas fa-person-booth"></i>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button id="guardar_voto" onclick="votar()" type="button" class="btn btn-primary">Guardar Votación</button>'+
                                '<button id="btn_md_cls" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                    +'</div>';
                    $('#modal-content').html(html);
                    $('#modal_vot').modal('show');
                    }else{
                        alert("Debe seleccionar una votacion para poder votar");
                    }
                }
            }
        ]
    });
});

$('#votaciones_usuario > tbody').on( 'click', 'tr' ,function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        select = false;
    }
    else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        select = true;
    }
});

function about(){
    html="";
    html+='<div id="modal_vot" class="modal" tabindex="-1" role="dialog" style="width:auto;height:auto;align:center;">'+
            '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
            '<div class="modal-header">'+
                '<h5 class="modal-title">About us</h5>'+
                '<button id="btn-md-cls" type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
            '</div>'+
            '<div class="modal-body">'+
                '<p>&nbsp;&nbsp;Universidad de Cádiz - ESI</p>'+
                '<p>&nbsp;&nbsp;Proyectos Informáticos</p>'+
                '<p>&nbsp;&nbsp;Grupo 5</p>'+
                '<i style="float:right;margin-top: -22%;margin-right: 16%;display:inline-block;" class="fa-5x fas fa-university"></i>'+
            '</div>'+
            '<div class="modal-footer">'+

                '<button id="btn_md_cls" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
            '</div>'+
            '</div>'+
            '</div>'+
    +'</div>';
    $('#modal-content').html(html);
    $('#modal_vot').modal('show');
}

function contact(){
    html="";
    html+='<div id="modal_vot" class="modal" tabindex="-1" role="dialog" style="width:auto;height:auto;align:center;">'+
            '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
            '<div class="modal-header">'+
                '<h5 class="modal-title">Contact us</h5>'+
                '<button id="btn-md-cls" type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
            '</div>'+
            '<div class="modal-body">'+
                '<p>&nbsp;&nbsp;<b>Jefa de grupo:</b>&nbsp;&nbsp;Miriam Corchero</p>'+
                '<p>&nbsp;&nbsp;<b>Teléfono:</b>&nbsp;&nbsp;617299195</p>'+
                '<p>&nbsp;&nbsp;<b>Email:</b>&nbsp;&nbsp;miriamcorbla@gmail.com</p>'+
                '<i style="float:right;margin-top: -22%;margin-right: 16%;display:inline-block;" class="fa-5x fas fa-id-card"></i>'+
            '</div>'+
            '<div class="modal-footer">'+

                '<button id="btn_md_cls" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
            '</div>'+
            '</div>'+
            '</div>'+
    +'</div>';
    $('#modal-content').html(html);
    $('#modal_vot').modal('show');
}

function votar(){
    let voto = $('input:radio[name=voto]:checked').val();
    $('#modal_vot').modal('hide');
}