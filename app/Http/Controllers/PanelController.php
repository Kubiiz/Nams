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

class PanelController extends Controller
{
    /**
     * Show control panel index page
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('panel')) {
            return back();
        }

        return view('panel.index');
    }
}
