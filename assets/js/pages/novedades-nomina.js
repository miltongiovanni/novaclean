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


import DataTable from 'datatables.net-bs5';
// import 'datatables.net-buttons-bs5';
// import jsZip from 'jszip';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
// import 'datatables.net-buttons/js/buttons.html5.min.mjs';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';

// This line was the one missing
// window.JSZip = jsZip;
const DOMINGO_COMPENSADO = '7';
const DOMINGO_SIN_COMPENSAR = '8';
$(function () {

    let novedadesNominaDatatable = $("#novedadesNominaDatatable").DataTable({
        ajax: {
            url: $("#novedadesNominaDatatable").attr("data-url"),
            type: "POST",
            dataType: "json"
        },
        processing: true,
        search: {
            return: true
        },
        serverSide: true,
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
                data: 'f_creacion',
                width: '10%',
                className: 'dt-body-center'
            },
            {
                data: 'f_actualizacion',
                width: '10%',
                className: 'dt-body-center'
            },
            {
                data: 'null',
                render: function (data, type, row) {
                    return '<div class="dropdown">\n' +
                        '    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink"\n' +
                        '       data-bs-toggle="dropdown" aria-expanded="false">\n' +
                        '        Acciones\n' +
                        '    </a>\n' +
                        '    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">\n' +
                        // '            <li>\n' +
                        // (row.activa ? '<a class="dropdown-item" href="/nomina/novedad/'+ row.id +'/desactivar/">Desactivar</a>': '<a class="dropdown-item" href="/personal/'+ row.slug +'/activar/">Activar</a>') +
                        // '            </li>\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/nomina/novedad/'+ row.id +'/editar/">Editar</a>\n' +
                        '        </li>\n' +
                        '    </ul>\n' +
                        '</div>'
                }
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
