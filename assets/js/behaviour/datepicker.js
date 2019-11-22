/*$(document).ready(function(){
  $("#fecha_inicio").datepicker({
     todayBtn:  1,
     autoclose: true,
 }).on('changeDate', function (selected) {
     var minDate = new Date(selected.date.valueOf());
     $('#fecha_final').datepicker('setStartDate', minDate);
 });

 $("#fecha_final").datepicker()
     .on('changeDate', function (selected) {
         var maxDate = new Date(selected.date.valueOf());
         $('#fecha_inicio').datepicker('setEndDate', maxDate);
     });


});*/
window.addEventListener("load", () => {

  $(document).ready(function(){
    $('#fecha_inicio').datetimepicker({
      todayBtn:  1,
      todayHighlight: true,
      autoclose: true,
      startDate: '+0d', // Solo puede empezar a partir de hoy
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#fecha_final').datetimepicker('setStartDate', minDate);

    });
    $("#fecha_final").datetimepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#fecha_inicio').datetimepicker('setEndDate', maxDate);
        });
  });
});
