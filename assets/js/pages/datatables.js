import DataTable from 'datatables.net-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

import languageEsCol from 'datatables.net-plugins/i18n/es-CO.mjs';



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
        language: languageEsCol,
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
    let prestamoPersonalDatatable = $("#prestamoPersonalDatatable").DataTable({
        "columnDefs":
            [
                {
                    "targets": [1, 3, 4],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [8, 9],
                    "orderable": false,
                    "className": ''
                },
            ],
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'Todo'],
        ],
        language: languageEsCol,
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

