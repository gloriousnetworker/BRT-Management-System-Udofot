import React, { useState, useEffect } from "react";
import Echo from "laravel-echo";
import Pusher

const Notifications = () => {
    const [notifications, setNotifications] = useState([]);

    useEffect(() => {
        // Initialize Echo instance with proper settings
        const echo = new Echo({
            broadcaster: "pusher",
            key: process.env.REACT_APP_PUSHER_APP_KEY, // Make sure to use the correct environment variable
            cluster: "mt1", // Ensure this is the correct cluster
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
