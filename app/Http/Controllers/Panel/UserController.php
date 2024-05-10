<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Notifications\NewPassword;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

        $users = User::sortable()->paginate(5);

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
        $permissions = Permission::list();

        return view('panel.users.edit', compact('user', 'permissions'));
    }

    /**
     * Update user
     */
    public function update(User $user, Request $request)
    {
        if (!Auth::user()->hasPermission('users')) {
            return back();
        }

        $request->validate([
            'name'      => ['required', 'string', 'min:3', 'max:15'],
            'surname'   => ['required', 'string', 'min:3', 'max:100'],
            'phone'     => ['phone:LV'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        if ($request->verify) {
            $user->markEmailAsVerified();
        }

        // if ($request->email != $user->email) {
        //     $request->merge([
        //         'email_verified_at' => null,
        //     ])->toArray();
        // }

        $user->update($request->all());

        return back()->with('status', 'information-updated');
    }

    /**
     * Update user password
     */
    public function password(User $user, Request $request)
    {
        if (!Auth::user()->hasPermission('users') || $user->id == Auth::user()->id) {
            return back();
        }

        $password = Str::random(10);

        $user->update([
            'password' => Hash::make($password)
        ]);

        $user->notify(new NewPassword($password, $user->name));

        return back()->with('status', 'password-updated');
    }

    /**
     * Update user permissions
     */
    public function permissions(User $user, Request $request)
    {
        if (!Auth::user()->hasPermission('users_perm') || $user->id == Auth::user()->id) {
            return back();
        }

        // Delete existing permissions
        Permission::where('type', 'user')
                  ->where('id', $user->id)
                  ->where('permission', '!=' , 'admin')
                  ->delete();

        // Create new permissions if is added new
        if($request->permission) {
            foreach ($request->permission as $key => $value) {
                if (isset(Permission::list()[$value])) {
                    Permission::where('type', 'user')
                              ->where('id', $user->id)
                              ->where('permission', '!=' , 'admin')
                              ->create([
                                'type'       => 'user',
                                'id'         => $user->id,
                                'permission' => $value,
                              ]);
                }
            }
        }

        return back()->with('status', 'permissions-updated');
    }
}
