<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Company;
use App\Models\Apartment;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PollController extends Controller
{
    /**
     * Finds which page to display on the home page
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('polls')) {
            return back();
        }

        return view('polls.index');
    }
}
