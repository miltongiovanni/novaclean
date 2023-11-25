$("#search_personal").keyup(function(){
    buscarPersonal();
    console.log('here');
});

function buscarPersonal() {
    let q = document.getElementById("search_personal").value;
    if (q.length >= 3){
        $.ajax({
            url: '/buscar-personal',
            type: 'POST',
            data: {
                "q": q,
            },
            dataType: 'json',
            success: function (response) {

                var x = document.createElement("OPTION");
                x.setAttribute("value", '');
                var t = document.createTextNode('Seleccione una opción');
                t.selected=true;
                x.appendChild(t);
                document.getElementById("personal_id").appendChild(x);
                for (let personal of response){
                    var x = document.createElement("OPTION");
                    x.setAttribute("value", personal.id);
                    var t = document.createTextNode(personal.nombreCompleto);
                    x.appendChild(t);
                    document.getElementById("personal_id").appendChild(x);
                }
                $('#personal_id').parent().parent().removeClass('d-none');
            },
            error: function () {
                alert("Vous avez un GROS problème");
            }
        });
    }
}

