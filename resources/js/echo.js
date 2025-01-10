import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'fd7cc9ca454f87cc9526',
    cluster: 'mt1',
    forceTLS: true
});
