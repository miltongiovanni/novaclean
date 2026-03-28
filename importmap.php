<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/js/app.js',
        'entrypoint' => true,
    ],
    'parsley' => [
        'path' => './assets/js/pages/parsley.js',
        'entrypoint' => true,
    ],
    'cliente' => [
        'path' => './assets/js/pages/cliente.js',
        'entrypoint' => true,
    ],
    'contrato' => [
        'path' => './assets/js/pages/contrato.js',
        'entrypoint' => true,
    ],
    'personal' => [
        'path' => './assets/js/pages/personal.js',
        'entrypoint' => true,
    ],
    'personal-list' => [
        'path' => './assets/js/pages/personal-list.js',
        'entrypoint' => true,
    ],
    'contrato-list' => [
        'path' => './assets/js/pages/contrato-list.js',
        'entrypoint' => true,
    ],
    'clientes-list' => [
        'path' => './assets/js/pages/clientes-list.js',
        'entrypoint' => true,
    ],
    'personal-contrato' => [
        'path' => './assets/js/pages/personal-contrato.js',
        'entrypoint' => true,
    ],
    'prestamo-personal' => [
        'path' => './assets/js/pages/prestamo-personal.js',
        'entrypoint' => true,
    ],
    'novedades-nomina' => [
        'path' => './assets/js/pages/novedades-nomina.js',
        'entrypoint' => true,
    ],
    'sweetalert22' => [
        'path' => './assets/js/pages/sweetalert2.js',
        'entrypoint' => true,
    ],
    'datatables' => [
        'path' => './assets/js/pages/datatables.js',
        'entrypoint' => true,
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'bootstrap' => [
        'version' => '5.3.8',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.8',
        'type' => 'css',
    ],
    'bootstrap-icons/font/bootstrap-icons.min.css' => [
        'version' => '1.13.1',
        'type' => 'css',
    ],
    'datatables.net-bs5' => [
        'version' => '2.3.5',
    ],
    'datatables.net' => [
        'version' => '2.3.5',
    ],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => [
        'version' => '2.3.5',
        'type' => 'css',
    ],
    'datatables.net-plugins/i18n/es-CO.mjs' => [
        'version' => '2.3.6',
    ],
    'feather-icons' => [
        'version' => '4.29.2',
    ],
    'perfect-scrollbar' => [
        'version' => '1.5.6',
    ],
    'perfect-scrollbar/css/perfect-scrollbar.min.css' => [
        'version' => '1.5.6',
        'type' => 'css',
    ],
    'select2' => [
        'version' => '4.1.0-rc.0',
    ],
    'select2/dist/css/select2.min.css' => [
        'version' => '4.1.0-rc.0',
        'type' => 'css',
    ],
    'sweetalert2' => [
        'version' => '11.26.24',
    ],
    'jszip' => [
        'version' => '3.10.1',
    ],
    'parsleyjs' => [
        'version' => '2.9.2',
    ],
    'parsleyjs/dist/i18n/es.js' => [
        'version' => '2.9.2',
    ],
    'datatables.net-buttons-bs5' => [
        'version' => '3.2.6',
    ],
    'datatables.net-buttons' => [
        'version' => '3.2.6',
    ],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css' => [
        'version' => '3.2.6',
        'type' => 'css',
    ],
];
