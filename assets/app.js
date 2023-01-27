/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery';
//global.$ = global.jQuery = $;
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons
import featherIcons from "feather-icons"
featherIcons.replace()

// Mazer internal JS. Include this in your project to get
// the sidebar running.
require("./js/components/dark")
require("./js/mazer")
//import DataTable from 'datatables.net';
// Datatable (plugin jquery) pour bootstrap
// import 'datatables.net/js/jquery.dataTables.js';
// import 'datatables.net-bs5/js/dataTables.bootstrap5';
// import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
// window.JSZip = require( 'jszip' );
// const pdfMake = require( 'pdfmake/build/pdfmake' );
// const pdfFonts  = require( 'pdfmake/build/vfs_fonts' );
// pdfMake.vfs = pdfFonts.pdfMake.vfs;
// var dt = require( 'datatables.net' )(window, $);
// require( 'datatables.net-bs5' )(window, $);
// require( 'datatables.net-buttons/js/dataTables.buttons.min' )(window, $);
// require( 'datatables.net-buttons-bs5' )(window, $);
// require( 'datatables.net-buttons/js/buttons.flash' )(window, $);
// require( 'datatables.net-buttons/js/buttons.html5' )(window, $);

// import 'datatables.net-bs5';
// import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
// import jsZip from 'jszip';
// This line was the one missing
// window.JSZip = jsZip;
// import pdfMake from "pdfmake/build/pdfmake";
// import pdfFonts from "pdfmake/build/vfs_fonts";
// pdfMake.vfs = pdfFonts.pdfMake.vfs;
// import 'datatables.net-buttons-bs5';
// import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.css';
// import 'datatables.net-buttons/js/buttons.colVis.min';
// import 'datatables.net-buttons/js/buttons.print.js';
// import 'datatables.net-buttons/js/buttons.html5.min';


$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});