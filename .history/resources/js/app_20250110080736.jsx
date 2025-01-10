import './bootstrap';  // Make sure to import bootstrap.js (if required for your project)
import React from 'react';
import ReactDOM from 'react-dom/client';  // React 18 compatibility

function App() {
    return (
        <div className="App">
            <h1>Welcome to BRT Management</h1>
        </div>
    );
}

// Get the root element where React will be rendered
const root = ReactDOM.createRoot(document.getElementById('app'));

// Render the React app into the root div
root.render(<App />);
