$(document).ready(function(){
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


});
