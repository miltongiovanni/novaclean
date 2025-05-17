import 'select2/dist/js/select2.full.min';
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/i18n/es';

import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';

jQuery(function () {

    let personalContratoDatatable = $("#personalContratoDatatable").DataTable({
        ajax: {
            url: $("#personalContratoDatatable").attr("data-url"),
            type: "POST",
            dataType: "json"
        },
        columns: [
            {data: 'nombre'},
            {data: 'apellido'},
            {data: 'cargo'},
            {
                data: 'salario',
                render: function (data, type) {
                    var number = DataTable.render
                        .number(',', '.', 0, '$')
                        .display(data);

                    if (type === 'display') {
                        let color = 'green';
                        if (data < 250000) {
                            color = 'red';
                        } else if (data < 500000) {
                            color = 'orange';
                        }
                        return `<span style="color:${color}">${number}</span>`;
                    }

                    return number;
                }
            },
            {data: 'bono'},
            {data: 'tipo_nomina'},
            {data: 'fechaIngreso'},
            {data: 'fechaRetiro'},
            {data: 'actions'}
        ],
        "columnDefs":
            [
                {
                    "targets": [8],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [2],
                    "orderable": false,
                    "className": 'col-2'
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        language: languageEsCol,
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
});

$(document).on('change', '#personal_id', function () {
    let slug_contrato = document.getElementById('updatePersonalContratoForm').dataset.contratoSlug;
    let formData = new FormData();
    formData.append('personal_id', $(this).val());
    $.ajax({
        url: '/buscar-personal-slug',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            document.getElementById('updatePersonalContratoForm').action = '/contrato/' + slug_contrato + '/personal/' + response.slug + '/actualizar';
        },
        error: function () {
            alert("Vous avez un GROS problème");
        }
    });
});

$(document).on('change', '#fecha_retiro', function () {
    let slug_contrato = document.getElementById('retirarPersonalContrato').dataset.contratoSlug;
    let personal_id = document.getElementById('id_personal').value;
    let formData = new FormData();
    formData.append('personal_id', personal_id);
    $.ajax({
        url: '/buscar-personal-slug',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            document.getElementById('retirarPersonalContrato').action = '/contrato/' + slug_contrato + '/personal/' + response.slug + '/retirar';
            $('#submit_retirar_contrato_personal').prop('disabled', false);
        },
        error: function () {
            alert("Vous avez un GROS problème");
        }
    });
});
