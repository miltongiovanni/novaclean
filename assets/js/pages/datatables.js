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

