
import jsZip from 'jszip';

import 'datatables.net';
import 'datatables.net-bs5';
// import 'datatables.net-buttons';
// import 'datatables.net-buttons/js/buttons.html5.min.mjs';
// import 'datatables.net-buttons-bs5/js/buttons.bootstrap5.js';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.css';

// This line was the one missing
window.JSZip = jsZip;

$(function () {
    /* Formatting function for row details - modify as you need */
    function formatContrato(d) {
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Póliza de cumplimiento</th>' + '<th>Póliza de salario</th>' + '<th>Aseguradora</th>' + '<th>No. de póliza</th>' + '<th>Vencimiento póliza</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + (d.tiene_poliza_cumplimiento === 1 ? 'SI' : 'NO') + '</td>' + '<td>' + (d.tiene_poliza_salario === 1 ? 'SI' : 'NO') + '</td>' + '<td>' + (d.aseguradora ?? '') + '</td>' + '<td>' + (d.no_poliza ?? '') + '</td>' + '<td>' + (d.vencimiento_poliza ?? '') + '</td>' +
            '</tr>' +
            '</table>'
        );
    }

    let contratosDatatable = $("#contratosDatatable").DataTable({
        ajax: {
            url: '/contrato/lista',
            type: "POST",
            dataType: "json"
        },
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            {data: 'id'},
            {data: 'contrato_id'},
            {data: 'cliente'},
            {data: 'f_inicio'},
            {data: 'f_fin'},
            {data: 'supervisor'},
            {data: 'estado'},
            {data: 'observaciones'},
            {
                data: 'null',
                render: function (data, type, row) {
                    return '<div class="dropdown">\n' +
                        '    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink"\n' +
                        '       data-bs-toggle="dropdown" aria-expanded="false">\n' +
                        '        Acciones\n' +
                        '    </a>\n' +
                        '    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/contrato/'+ row.slug +'/editar/">Editar</a>\n' +
                        '        </li>\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/contrato/'+ row.slug +'/personal/">Personal</a>\n' +
                        '        </li>\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/contrato/'+ row.slug +'/renovar/">Renovar</a>\n' +
                        '        </li>\n' +
                        '    </ul>\n' +
                        '</div>'
                }
            }
        ],
        "columnDefs":
            [
                {
                    "targets": [0, 1, 2, 7, 9],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [8, 9],
                    "className": 'dt-body-left'
                },
                {
                    "targets": [0, 7, 9],
                    "orderable": false,
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        "order": [[1, 'asc']],
        language: languageEsCol,
        // dom: 'Bfrtip',
        // buttons: [
        //     {
        //         extend: 'excelHtml5',
        //         text: 'Exportar a excel',
        //         exportOptions: {
        //             columns: [1, 2, 3, 4, 5, 6, 7, 8]
        //         }
        //     }
        // ]
    });
    // Add event listener for opening and closing details
    $('#contratosDatatable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = contratosDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(formatContrato(row.data())).show();
            tr.addClass('shown');
        }
    });

});

