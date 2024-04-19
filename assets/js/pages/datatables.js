import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import jsZip from 'jszip';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons/js/buttons.html5.min.mjs';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';


// This line was the one missing
window.JSZip = jsZip;

$(function () {
    let usersDatatable = new DataTable("#usersDatatable",{
        "columnDefs":
            [
                {
                    "targets": [5, 6],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [5, 6],
                    "orderable": false
                }
            ],
        language: languageEsCol,
    });
    let afcDatatable = $("#afcDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 6, 7],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [9],
                    "orderable": false
                }
            ],
        language: {
        url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-CO.json',
    },
    });
    let afpDatatable = $("#afpDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 6, 7],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [9],
                    "orderable": false
                }
            ],
        language: languageEsCol,
    });
    let epsDatatable = $("#epsDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 6, 7],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [9],
                    "orderable": false
                }
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        language: languageEsCol,
    });
    let cargoDatatable = $("#cargoDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 2],
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


    /* Formatting function for row details - modify as you need */
    function formatContrato(d) {
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Póliza de cumplimiento</th>' + '<th>Póliza de salario</th>' + '<th>Aseguradora</th>' + '<th>No. de póliza</th>' + '<th>Vencimiento póliza</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + (d.tiene_poliza_cumplimiento === true ? 'SI' : 'NO') + '</td>' + '<td>' + (d.tiene_poliza_salario === true ? 'SI' : 'NO') + '</td>' + '<td>' + d.aseguradora + '</td>' + '<td>' + d.no_poliza + '</td>' + '<td>' + (d.vencimiento_poliza ?? '') + '</td>' +
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
            {data: 'actions'}
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
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a excel',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                }
            }
        ]
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



    let tiposNovedadesNominaDatatable = $("#tiposNovedadesNominaDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 3, 4, 5],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [5],
                    "orderable": false,
                    "className": 'col-2'
                },
            ],
        lengthMenu: [
            [10, 30, 50, -1],
            [10, 30, 50, 'Todo'],
        ],
        language: languageEsCol,
    });

});

