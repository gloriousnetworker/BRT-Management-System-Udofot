import React, { useState, useEffect } from "react";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

const Notifications = () => {
    const [notifications, setNotifications] = useState([]);

    useEffect(() => {
        const echo = new Echo({
            broadcaster: "pusher",
            key: "your-app-key", // Replace with your actual Pusher key
            cluster: "mt1",      // Replace with your actual cluster
            forceTLS: true,
        });

        // Listen for the 'brt.created' event on the 'brts' channel
        echo.channel("brts").listen(".brt.created", (data) => {
            console.log("BRT Created: ", data.brt);
            setNotifications((prev) => [...prev, data.brt]);
        });

        // Clean up when the component unmounts
        return () => {
            echo.disconnect();
        };
    }, []);

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
