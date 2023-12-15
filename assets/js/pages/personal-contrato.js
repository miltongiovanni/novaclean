import 'select2/dist/js/select2.full.min';
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/i18n/es';




$(document).ready(function () {
    $('.select2-personal').select2(
        {
            placeholder: 'Seleccione un empleado',
            allowClear: true,
            //dropdownParent: $('#personalContratoModal'),
            ajax: {
                url: '/buscar-personal',
                type: 'post',
                lenguage: 'es',
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

// $(document).on('click', '#submit_contrato_personal', function () {
//     let form = document.getElementById('addEditPersonalContratoForm');
//
//     console.log(formValidate.isValid());
//     let url = form.getAttribute('action');
//     let formData = new FormData(form);
//     if (formValidate.isValid()){
//         $.ajax({
//             url: url,
//             type: 'POST',
//             data: formData,
//             dataType: 'json',
//             processData: false,
//             contentType: false,
//             success: function (response) {
//
//             },
//             error: function () {
//                 alert("Vous avez un GROS problème");
//             }
//         });
//     }
//
//
//
// });
