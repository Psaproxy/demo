window._ = require('lodash');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let csrfTokenEl = document.head.querySelector('meta[name="csrf-token"]');
if (csrfTokenEl) {
    window.csrfToken = csrfTokenEl.content;
    window.axios.defaults.headers.common['X-CSRF-Token'] = csrfTokenEl.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// require('./webSocket.js');
