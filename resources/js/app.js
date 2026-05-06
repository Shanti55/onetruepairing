import './bootstrap';
import Alpine from 'alpinejs'   // ✅ ADD THIS
window.Alpine = Alpine
Alpine.start()    

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import $ from 'jquery';
window.$ = window.jQuery = $;

/* ✅ CSRF FIX */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content')
    }
});

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;

import 'datatables.net-responsive-bs5';
import "./easyAjax.js"
import "./easyDelete.js"
import 'parsleyjs'

document.addEventListener('livewire:navigated', function () {
    $('.form-select').each(function (i, element) {
        $(element).select2({
            dropdownParent: $(element).parent(),
            theme: 'bootstrap-5'
        })
    });
});

// Quill editor
document.addEventListener("DOMContentLoaded", function () {
    const editorExists = document.getElementById('editor');
    if (editorExists) {
        new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: '1' }, { header: '2' }, { font: [] }],
                    [{ size: ['small', false, 'large', 'huge'] }],
                    [{ list: 'ordered'}, { list: 'bullet' }],
                    ['bold', 'italic', 'underline'],
                    [{ align: [] }],
                    ['link', 'image'],
                    [{ color: [] }, { background: [] }]
                ],
            }
        });
    }
});
