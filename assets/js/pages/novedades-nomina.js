import 'select2/dist/js/select2.full.min';
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/i18n/es';

import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import jsZip from 'jszip';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons/js/buttons.html5.min.mjs';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';

// This line was the one missing
window.JSZip = jsZip;
const DOMINGO_COMPENSADO = '7';
const DOMINGO_SIN_COMPENSAR = '8';
$(function () {

    let novedadesNominaDatatable = $("#novedadesNominaDatatable").DataTable({
        ajax: {
            url: $("#novedadesNominaDatatable").attr("data-url"),
            type: "POST",
            dataType: "json"
        },
        columns: [
            {
                data: 'personal',
                width: '18%'
            },
            {
                data: 'tipo_novedad',
                width: '18%'
            },
            {
                data: 'f_inicio',
                width: '8%',
                className: 'dt-body-center'
            },
            {
                data: 'f_fin',
                width: '8%',
                className: 'dt-body-center'
            },
            {
                data: 'observaciones',
                width: '15%'
            },
            {
                data: 'estado',
                width: '5%',
                className: 'dt-body-center'
            },
            {
                data: 'fecha_creacion',
                width: '10%',
                className: 'dt-body-center'
            },
            {
                data: 'fecha_actualizacion',
                width: '10%',
                className: 'dt-body-center'
            },
            {
                data: 'actions',
                width: '8%',
                className: 'dt-body-center'
            }
        ],
        "columnDefs":
            [
                {
                    "targets": [5 ,8],
                    "orderable": false,
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        language: languageEsCol,
        "order": [[2, 'asc']],
    });

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

    $('#tipo_novedad_id').select2(
        {
            placeholder: 'Seleccione un tipo de novedad',
            allowClear: true,
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

$(document).on('change', '#tipo_novedad_id', function () {
    if ($(this).val() === DOMINGO_COMPENSADO || $(this).val() === DOMINGO_SIN_COMPENSAR) {
        document.getElementById("fecha_inicio").type = "datetime-local";
        document.getElementById("fecha_fin").type = "datetime-local";
    } else {
        document.getElementById("fecha_inicio").type = "date";
        document.getElementById("fecha_fin").type = "date";
    }
});
