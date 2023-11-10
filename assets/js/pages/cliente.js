$("input").keyup(function(){
    nitClientes();
});

function nitClientes() {
    let numero = document.getElementById("numero").value;
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