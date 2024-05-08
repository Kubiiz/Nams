<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Company;
use App\Models\Apartment;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show users
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('users')) {
            return back();
        }

        $users = User::paginate(5);

        return view('panel.users.index', compact('users'));
    }

    /**
     * Edit user
     */
    public function edit($user)
    {
        if (!Auth::user()->hasPermission('users')) {
            return back();
        }

        $user = User::findOrFail($user);

        return view('panel.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $user)
    {
        if (!Auth::user()->hasPermission('users')) {
            return back();
        }

        $user = User::findOrFail($user);

        return view('panel.users.edit', compact('user'));
    }

    /**
     * Update user permissions
     */
    public function permissions(Request $user)
    {
        if (!Auth::user()->hasPermission('users_perm')) {
            return back();
        }

        $user = User::findOrFail($user);

        return view('panel.users.edit', compact('user'));
    }
}
