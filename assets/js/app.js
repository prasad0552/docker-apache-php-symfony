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
// mode: "clike",

// CodeMirror.fromTextArea(document.getElementById("form_code"), {
//     lineNumbers: true,
//     theme: 'cobalt'
// });

document.addEventListener('DOMContentLoaded', (event) => {
    function handleDragStart(event) {
        console.log(event.target.getAttribute("data-codesnippet"));
        event.dataTransfer.effectAllowed = 'move';
        event
            .dataTransfer
            .setData('text/plain', event.target.getAttribute("data-codesnippet"));
    }

    let items = document.querySelectorAll('.menu-item');
    items.forEach(function (item) {
        item.addEventListener('dragstart', handleDragStart, false);
        // item.addEventListener('dragover', handleDragOver, false);
        // item.addEventListener('dragenter', handleDragEnter, false);
        // item.addEventListener('dragleave', handleDragLeave, false);
        // item.addEventListener('dragend', handleDragEnd, false);
    });
});
