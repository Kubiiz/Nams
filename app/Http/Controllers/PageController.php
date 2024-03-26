<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Finds which page to display on the home page
     */
    public function home(): View
    {
        if (Auth::check()) {
            return view('dashboard');
        }
    
        return view('auth.login');
    }
}
