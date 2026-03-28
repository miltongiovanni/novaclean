
import select2 from 'select2';
import 'select2/dist/css/select2.min.css';
select2();
let select2_es = {
    errorLoading: function() {
        return "No se pudieron cargar los resultados"
    },
    inputTooLong: function(e) {
        var n = e.input.length - e.maximum
            , r = "Por favor, elimine " + n + " car";
        return r += 1 == n ? "ácter" : "acteres"
    },
    inputTooShort: function(e) {
        var n = e.minimum - e.input.length
            , r = "Por favor, introduzca " + n + " car";
        return r += 1 == n ? "ácter" : "acteres"
    },
    loadingMore: function() {
        return "Cargando más resultados…"
    },
    maximumSelected: function(e) {
        var n = "Sólo puede seleccionar " + e.maximum + " elemento";
        return 1 != e.maximum && (n += "s"),
            n
    },
    noResults: function() {
        return "No se encontraron resultados"
    },
    searching: function() {
        return "Buscando…"
    }
};


$(document).ready(function () {
    $('.select2-personal').select2(
        {
            placeholder: 'Seleccione un empleado',
            allowClear: true,
            language: select2_es,
            //dropdownParent: $('#personalContratoModal'),
            ajax: {
                url: '/buscar-personal',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true,
                minimumInputLength: 1,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        }
    );
});

// $(document).on('change', '#personal_id', function () {
//     let slug_contrato = document.getElementById('updatePersonalContratoForm').dataset.contratoSlug;
//     let formData = new FormData();
//     formData.append('personal_id', $(this).val());
//     $.ajax({
//         url: '/buscar-personal-slug',
//         type: 'POST',
//         data: formData,
//         dataType: 'json',
//         processData: false,
//         contentType: false,
//         success: function (response) {
//             document.getElementById('updatePersonalContratoForm').action = '/contrato/' + slug_contrato + '/personal/' + response.slug + '/actualizar';
//         },
//         error: function () {
//             alert("Vous avez un GROS problème");
//         }
//     });
// });
//
// $(document).on('change', '#fecha_retiro', function () {
//     let slug_contrato = document.getElementById('retirarPersonalContrato').dataset.contratoSlug;
//     let personal_id = document.getElementById('id_personal').value;
//     let formData = new FormData();
//     formData.append('personal_id', personal_id);
//     $.ajax({
//         url: '/buscar-personal-slug',
//         type: 'POST',
//         data: formData,
//         dataType: 'json',
//         processData: false,
//         contentType: false,
//         success: function (response) {
//             document.getElementById('retirarPersonalContrato').action = '/contrato/' + slug_contrato + '/personal/' + response.slug + '/retirar';
//             $('#submit_retirar_contrato_personal').prop('disabled', false);
//         },
//         error: function () {
//             alert("Vous avez un GROS problème");
//         }
//     });
// });
