import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import jsZip from 'jszip';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons/js/buttons.html5.min.mjs';

// This line was the one missing
window.JSZip = jsZip;

$(document).ready(function () {
    let usersDatatable = $("#usersDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [0, 6, 7],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [6, 7],
                    "orderable": false
                }
            ],
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
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
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

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
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
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
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
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
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
    });

    /* Formatting function for row details - modify as you need */
    function formatPersonal(d) {
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Sexo</th>' + '<th>Tipo de nómina</th>' + '<th>AFP</th>' + '<th>EPS</th>' + '<th>AFC</th>' + '<th>Tipo de cuenta</th>' + '<th>Número de cuenta</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + d.sexo + '</td>' + '<td>' + d.tipo_nomina + '</td>' + '<td>' + d.afp + '</td>' + '<td>' + d.eps + '</td>' + '<td>' + d.afc + '</td>' + '<td>' + d.tipo_cuenta + '</td>' + '<td>' + d.numero_cuenta + '</td>' +
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

    let personalDatatable = $("#personalDatatable").DataTable({
        ajax: {
            url: '/personal/lista',
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
            {data: 'nombre'},
            {data: 'apellido'},
            {data: 'identificacion'},
            {data: 'lugar_expedicion'},
            {data: 'f_ingreso'},
            {data: 'cargo'},
            {
                data: 'salario_basico',
                render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 0, '$')
                        .display(data);
                    return number;
                },
            },
            {
                data: 'bono',
                render: function (data, type) {
                    var number = $.fn.dataTable.render
                        .number(',', '.', 0, '$')
                        .display(data);
                    return number;
                },
            },
            {data: 'estado'},
            {data: 'actions'}
        ],
        "columnDefs":
            [
                {
                    "targets": [0, 1, 9, 10],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [8, 9],
                    "className": 'dt-body-right'
                },
                {
                    "targets": [0, 10, 11],
                    "orderable": false,
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        "order": [[1, 'asc']],
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
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
    $('#personalDatatable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = personalDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(formatPersonal(row.data())).show();
            tr.addClass('shown');
        }
    });

    /* Formatting function for row details - modify as you need */
    function formatContrato(d) {
        console.log(d);
        // `d` is the original data object for the row
        return (
            '<table style="padding-left:50px; width: 100%">' +
            '<tr>' +
            '<th>Póliza de cumplimiento</th>' +'<th>Póliza de salario</th>' +'<th>Aseguradora</th>' +'<th>No. de póliza</th>' +'<th>Vencimiento póliza</th>' +
            '</tr>' +
            '<tr>' +
            '<td class="py-3">' + (d.tiene_poliza_cumplimiento === true ? 'SI' : 'NO') + '</td>' +'<td>' + (d.tiene_poliza_salario === true ? 'SI' : 'NO') + '</td>' +'<td>' + d.aseguradora + '</td>' +'<td>' + d.no_poliza + '</td>' +'<td>' + (d.vencimiento_poliza ?? '') + '</td>' +
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
                    "className": 'dt-body-right'
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
        "language": {
            "lengthMenu": "Mostrando _MENU_ datos por página",
            "zeroRecords": "Lo siento no encontró nada",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "search": "Búsqueda:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "infoFiltered": "(Filtrado de _MAX_ en total)"

        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a excel',
                exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7, 8 ]
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
});

