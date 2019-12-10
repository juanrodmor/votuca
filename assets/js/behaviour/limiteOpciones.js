console.log("HRY");
var limit =  <?= echo $opc; ?> ;
console.log(limit);
$('input.single-checkbox').on('click', function (evt) {
    if ($('.single-checkbox:checked').length > limit) {
        this.checked = false;
    }
});