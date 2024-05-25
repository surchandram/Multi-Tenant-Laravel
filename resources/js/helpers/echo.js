import { nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// Initialize Laravel Echo
const initializeEcho = () => {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        disableStats: true,
    });
};

// Function to handle different notification types
const handleNotification = (notification) => {
    switch (notification.type) {
        case 'restore.project.note.created':
            showNotification(
                `Note added by ${notification.message?.user?.name} in project ${notification.project?.name}`,
                notification.url,
            );
            break;

        case 'message':
            // Example: show a toast notification for a new message
            showNotification(notification.message, notification.url);
            break;

        case 'alert':
            // Example: show an alert notification for an alert message
            showNotification(notification.alertMessage, notification.url);
            break;

        // Add more cases for different notification types as needed
        default:
            // Default case: log the notification
            console.log('Received notification:', notification);
    }
};

// Function to show push notification
const showNotification = (message, url) => {
    // Check if the browser supports the Notifications API
    if (!('Notification' in window)) {
        console.error('This browser does not support system notifications');
        return;
    }

    // Check if notifications are allowed
    if (Notification.permission === 'granted') {
        // If they are granted, show the notification
        const notification = new Notification(message);

        // Open url if available when notification is clicked
        if (url) {
            notification.onclick = () => {
                window.open(url);
            };
        }
    } else if (Notification.permission !== 'denied') {
        // If they are not denied, request permission from the user
        Notification.requestPermission().then(function (permission) {
            // If permission is granted, show the notification
            if (permission === 'granted') {
                const notification = new Notification(message);

                // Open url if available when notification is clicked
                if (url) {
                    notification.onclick = () => {
                        window.open(url);
                    };
                }
            }
        });
    }
};

// Listen for user broadcasts on the private channel
const listenForUserBroadcasts = () => {
    window.addEventListener('load', () => {
        nextTick(() => {
            const userChannel = `domain.users.${usePage().props.auth.user.id}`;

            window.Echo.private(userChannel).notification((notification) => {
                // Call the function to handle the received notification
                handleNotification(notification);
            });
        });
    });
};

// Initialize Echo and listen for user broadcasts
initializeEcho();
listenForUserBroadcasts();
