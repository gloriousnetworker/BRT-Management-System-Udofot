/**
 * First, we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';  // Make sure to import bootstrap.js (if required for your project)



/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

function App() {
    return (
        <div className="App">
            <h1>Welcome to BRT Management</h1>
            <Notifications />
        </div>
    );
}

// Get the root element where React will be rendered
const root = ReactDOM.createRoot(document.getElementById('app'));

// Render the React app into the root div
root.render(<App />);
