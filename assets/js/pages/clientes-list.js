
import jsZip from 'jszip';

import 'datatables.net';
import 'datatables.net-bs5';
//import 'datatables.net-buttons';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
// import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.css';
// import 'datatables.net-buttons/js/buttons.html5.min.mjs';
// import 'datatables.net-buttons-bs5/js/buttons.bootstrap5.js';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';


// This line was the one missing
// window.JSZip = jsZip;

$(function () {

    /* Formatting function for row details - modify as you need */
    function formatCliente(d) {
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Contacto</th>' + '<th>Teléfono</th>' + '<th>Teléfono 2</th>' + '<th>Celular</th>' + '<th>Correo electrónico</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + d.contacto + '</td>' + '<td>' + d.telefono + '</td>' + '<td>' + d.telefono2 + '</td>' + '<td>' + d.celular + '</td>' + '<td>' + d.correo_electronico + '</td>' + '<td>' +
            '</tr>' +
            '</table>'
        );
    }

    let clientesDatatable = $("#clientesDatatable").DataTable({
        ajax: {
            url: '/cliente/lista',
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
            {data: 'nit'},
            {data: 'nombre'},
            {data: 'direccion'},
            {data: 'observaciones'},
            {data: 'estado_show'},
            {
                data: 'null',
                render: function (data, type, row) {
                    return '<div class="dropdown">\n' +
                        '    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink"\n' +
                        '       data-bs-toggle="dropdown" aria-expanded="false">\n' +
                        '        Acciones\n' +
                        '    </a>\n' +
                        '    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">\n' +
                        '            <li>\n' +
                        (row.estado ? '<a class="dropdown-item" href="/cliente/'+ row.slug +'/desactivar/">Desactivar</a>': '<a class="dropdown-item" href="/cliente/'+ row.slug +'/activar/">Activar</a>') +
                        '            </li>\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/cliente/'+ row.slug +'/editar/">Editar</a>\n' +
                        '        </li>\n' +
                        '    </ul>\n' +
                        '</div>'
                }
            }
        ],
        "columnDefs":
            [
                {
                    "targets": [0, 5, 6],
                    "className": 'dt-body-center'
                },
                /* {
                     "targets": [6, 7],
                     "className": 'dt-body-right'
                 },*/
                {
                    "targets": [0, 5, 6],
                    "orderable": false,
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        "order": [[2, 'asc']],
        language: languageEsCol,
        // dom: 'Bfrtip',
        // buttons: [
        //     {
        //         extend: 'excelHtml5',
        //         text: 'Exportar a excel',
        //         exportOptions: {
        //             columns: [1, 2, 3, 4]
        //         }
        //     }
        // ],
        // layout: {
        //     topStart: {
        //         buttons: [
        //             'excel'
        //         ]
        //     }
        // }
    });
    // Add event listener for opening and closing details
    $('#clientesDatatable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = clientesDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(formatCliente(row.data())).show();
            tr.addClass('shown');
        }
    });


});

