import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import jsZip from 'jszip';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons/js/buttons.html5.min.mjs';
import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';


// This line was the one missing
window.JSZip = jsZip;

$(function () {
    /* Formatting function for row details - modify as you need */
    function formatPersonal(d) {
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Sexo</th>' + '<th>AFP</th>' + '<th>EPS</th>' + '<th>AFC</th>' + '<th>Tipo de cuenta</th>' + '<th>Número de cuenta</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + d.sexo + '</td>' + '<td>' + d.afp + '</td>' + '<td>' + d.eps + '</td>' + '<td>' + d.afc + '</td>' + '<td>' + d.tipo_cuenta + '</td>' + '<td>' + d.numero_cuenta + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th colspan="2">Correo electrónico</th>' + '<th>Celular</th>' + '<th>Teléfono</th>' + '<th colspan="2">Dirección</th>' + '<th>Fecha nacimiento</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3" colspan="2">' + d.correo_electronico + '</td>' + '<td>' + d.celular + '</td>' + '<td>' + (d.telefono ?? '') + '</td>' + '<td colspan="2">' + d.direccion + '</td>' + '<td>' + d.f_nacimiento + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Talla botas</th>' + '<th>Talla guantes</th>' + '<th>Talla uniforme</th>' + '<th>Talla calzado</th>' + '<th>Talla pantalón</th>' + '<th>Tipo de cuenta</th>' + '<th>Número de cuenta</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + d.talla_botas + '</td>' + '<td>' + d.talla_guantes + '</td>' + '<td>' + d.talla_uniforme + '</td>' + '<td>' + d.talla_calzado + '</td>' + '<td>' + (d.talla_pantalon ?? '') + '</td>' + '<td>' + d.tipo_cuenta + '</td>' + '<td>' + d.numero_cuenta + '</td>' +
            '</tr>' +
            '</table>'
        );
    }

    let personalDatatable = new DataTable("#personalDatatable",{
        ajax: {
            url: '/personal/lista/',
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
            {data: 'nombre'},
            {data: 'apellido'},
            {data: 'identificacion'},
            {data: 'lugar_expedicion'},
            {data: 'f_ingreso'},
            {data: 'cargo'},
            {data: 'estado'},
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
                        (row.activo ? '<a class="dropdown-item" href="/personal/'+ row.slug +'/desactivar/">Desactivar</a>': '<a class="dropdown-item" href="/personal/'+ row.slug +'/activar/">Activar</a>') +
                        '            </li>\n' +
                        '        <li>\n' +
                        '            <a class="dropdown-item" href="/personal/'+ row.slug +'/editar/">Editar</a>\n' +
                        '        </li>\n' +
                        '    </ul>\n' +
                        '</div>'
                }
            }
        ],
        "columnDefs":
            [
                {
                    "targets": [0, 7, 8],
                    "className": 'dt-body-center'
                },
                /* {
                     "targets": [6, 7],
                     "className": 'dt-body-right'
                 },*/
                {
                    "targets": [0, 7, 8],
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
                    columns: [1, 2, 3, 4, 5, 6]
                }
            }
        ]
    });
    // Add event listener for opening and closing details
    $('#personalDatatable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = personalDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            //tr.removeClass('shown');
        } else {
            // Open this row
            row.child(formatPersonal(row.data())).show();
            //tr.addClass('shown');
        }
    });
});

