
$(document).on('keyup', '#numero', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
    nitClientes(this.value)
});
function nitClientes(numero) {

    $.ajax({
        url: '/validar-nit',
        type: 'POST',
        data: {
            "numero": numero,
        },
        dataType: 'json',
        success: function (response) {
            $("#nit").val(response.nitValid);
        },
        error: function () {
            alert("Vous avez un GROS problème");
        }
    });
}