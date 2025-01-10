import React, { useState, useEffect } from "react";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Assuming this is your API key, cluster, and URL
const PUSHER_APP_KEY = "fd7cc9ca454f87cc9526"; // Replace with your actual Pusher key
const PUSHER_APP_CLUSTER = "mt1"; // Replace with your actual Pusher cluster

const Notifications = () => {
    const [notifications, setNotifications] = useState([]);

    useEffect(() => {
        // Make sure Echo is initialized correctly
        const echo = new Echo({
            broadcaster: "pusher",
            key: PUSHER_APP_KEY,
            cluster: PUSHER_APP_CLUSTER,
            forceTLS: true,
        });

        // Subscribe to the 'brts' channel and listen for the 'brt.created' event
        echo.channel("brts")
            .listen(".brt.created", (data) => {
                console.log("BRT Created: ", data.brt);
                setNotifications((prev) => [...prev, data.brt]);
            })
            .listen(".brt.updated", (data) => {
                console.log("BRT Updated: ", data.brt);
                setNotifications((prev) => [...prev, data.brt]);
            });

        // Clean up when the component unmounts
        return () => {
            echo.disconnect();
        };
    }, []); // Empty dependency array to run the effect only once when component mounts

    return (
        <div>
            <h2>Real-Time Notifications</h2>
            <ul>
                {notifications.map((notification, index) => (
                    <li key={index}>
                        {notification.brt_code} - {notification.reserved_amount} Blume Coins
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default Notifications;
