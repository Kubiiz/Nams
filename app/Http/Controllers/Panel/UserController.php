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
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Show users
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;
        $result = User::sortable()->paginate(10);

        if ($request) {
            $search = $request->input('search');

            $result = User::whereAny([
                    'name',
                    'surname',
                    'email',
                ], 'LIKE', "%$search%");
        }

        return view('panel.users.index', compact('result', 'search'));
    }

    /**
     * Search users
     */
    public function search(SearchRequest $request)
    {
        return $this->index($request);
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
    public function update(User $user, UserUpdateRequest $request)
    {
        if ($request->verify) {
            $user->markEmailAsVerified();
        }

        $user->update($request->validated());

        Auth::user()->createLog(route('panel.users.edit', $user->id), "Updated user ($user->name $user->surname)");

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

        Auth::user()->createLog(route('panel.user.edit', $user->id), "Changed users password ($user->name $user->surname)");

        return back()->with('status', 'password-updated');
    }
}
