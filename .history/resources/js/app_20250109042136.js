import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your_pusher_app_key', // Replace with your Pusher key
    cluster: 'your_pusher_cluster', // Replace with your Pusher cluster
    forceTLS: true,
});

// Listen for the 'brt-event' event on the 'brt-channel' channel
window.Echo.channel('brt-channel')
    .listen('BRTNotification', (event) => {
        console.log('BRT Notification:', event);
        alert(event.message); // Display the notification message
    });