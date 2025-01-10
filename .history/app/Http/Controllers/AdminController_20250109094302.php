<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only authenticated users can access this controller
        $this->middleware('auth');
    }

    public function index()
    {
        // Check if the logged-in user is the admin (using the 'is_admin' column)
        if (Auth::user()->is_admin !== true) {
            return redirect('/home'); // Redirect non-admin users to the home page
        }

        // If the user is the admin, show the admin dashboard
        return view('admin.dashboard');
    }
}
