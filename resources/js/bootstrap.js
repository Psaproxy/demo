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

window.Pusher = require('pusher-js');
import Echo from "laravel-echo";
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: process.env.MIX_PUSHER_APP_OUTER_PORT,
    wssPort: process.env.MIX_PUSHER_APP_OUTER_PORT,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws'],
    auth: {
        headers: {
            'X-App-ID': process.env.MIX_PUSHER_APP_ID,
        }
    },
});
