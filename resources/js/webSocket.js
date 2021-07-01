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
