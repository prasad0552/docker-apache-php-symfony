/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

import CodeMirror from 'codemirror';

import 'codemirror/lib/codemirror.css';
import 'codemirror/mode/clike/clike'
import 'codemirror/theme/cobalt.css'

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

CodeMirror.fromTextArea(document.getElementById("form_code"), {
    lineNumbers: true,
    mode: "clike",
    theme: 'cobalt'
});
