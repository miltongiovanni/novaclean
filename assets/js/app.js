
import $ from 'jquery';
// things on "window" become global variables
window.$ = $;
window.jQuery = $;

import 'bootstrap';
import "bootstrap-icons/font/bootstrap-icons.min.css"



// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons
import featherIcons from "feather-icons"
featherIcons.replace()

// Mazer internal JS. Include this in your project to get
// the sidebar running.
// require("./components/dark")
// require("./mazer")
import './components/dark.js';
import './mazer.js';