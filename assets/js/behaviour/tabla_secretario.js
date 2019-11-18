var base_url = window.location.origin+"/votuca/";

$(document).ready(function(){
    $('#votaciones_admin').DataTable({
      serverSide: false,
      paging: true,
      "scrollY": 300,
      ordering: false,
      "language": {
            "lengthMenu": "Muestra _MENU_ votaciones por pagina",
            "zeroRecords": "Votación no encontrada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Votaciones no disponible",
            "infoFiltered": "(Filtrando desde _MAX_ votaciones totales)",
            "search": "Buscar",
            "paginate": {
                "first": "Primera página",
                "previous": "Página anterior",
                "next": "Página posterior",

            }
        }

    });
});
