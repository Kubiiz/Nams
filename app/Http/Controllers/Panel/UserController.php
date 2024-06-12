<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Notifications\NewPassword;
use App\Models\User;
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
        $search = null;
        $result = User::sortable()->paginate(10);

        return view('panel.users.index', compact('result', 'search'));
    }

    /**
     * Search users
     */
    public function search(Request $request)
    {
        $request->validate([
            'search'      => 'required|string',
        ]);

        $search = $request->input('search');
        $result = User::whereAny([
                            'name',
                            'surname',
                            'email',
                        ], 'LIKE', "%$search%")
                        ->sortable()->paginate(10);

        return view('panel.users.index', compact('result', 'search'));
    }

    /**
     * Edit user
     */
    public function edit($user)
    {
        $user = User::findOrFail($user);
        $permissions = [];

        return view('panel.users.edit', compact('user', 'permissions'));
    }

    /**
     * Update user
     */
    public function update(User $user, Request $request)
    {
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
    public function changePassword(User $user, Request $request)
    {
        $password = Str::random(10);

        $user->update([
            'password' => Hash::make($password)
        ]);

        $user->notify(new NewPassword($password, $user->name));

        return back()->with('status', 'password-updated');
    }
}
