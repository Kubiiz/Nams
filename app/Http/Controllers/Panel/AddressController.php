<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Permission;
use App\Notifications\NewCompany;
use App\Notifications\CompanyStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Show companies
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $search = null;
        $perm = Auth::user()->hasPermission('Admin') ?? false;

        if ($perm) {
            $result = Company::sortable()->paginate(10);
        } else {
            $result = Company::where('owner', Auth::user()->email)
                             ->where('active', 1)
                             ->sortable()
                             ->paginate(10);
        }

        return view('panel.companies.index', compact('result', 'search', 'perm'));
    }

    /**
     * Create company
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        return view('panel.addresses.create');
    }

    /**
     * Store company
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'name'              => 'required|min:3|unique:companies,name',
            'owner'             => 'required|email|exists:user,email',
        ]);

        $company = Company::create($request->all());
        $owner = User::where('email', $company->owner)->first();

        Permission::create('user', $owner->id, ['owner']);

        $owner->notify(new NewCompany($company, $owner));

        return redirect()->route('panel.companies.edit', $company->id);
    }

    /**
     * Search companies
     */
    public function search(Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'search'      => 'required|string',
        ]);

        $search = $request->input('search');
        $perm = Auth::user()->hasPermission('Admin') ?? false;

        if ($perm) {
            $result = Company::whereAny([
                'name',
                'owner',
                'email',
                'address',
            ], 'LIKE', "%$search%")
            ->sortable()->paginate(10);
        } else {
            $result = Company::where('owner', Auth::user()->email)
                             ->where('active', 1)
                             ->whereAny([
                                'name',
                                'owner',
                                'email',
                                'address',
                            ], 'LIKE', "%$search%")
                            ->sortable()->paginate(10);
        }

        return view('panel.companies.index', compact('result', 'search', 'perm'));
    }

    /**
     * Edit company
     */
    public function edit($company)
    {
        $admin = Auth::user()->hasPermission('Admin') ?? false;

        $exists = Company::where('owner', Auth::user()->email)
                         ->where('active', 1)
                         ->exists();

        if (!Auth::user()->hasPermission('Owner') || !$exists) {
            return back();
        }

        if ($admin) {
            $result = Company::findOrFail($company);
        } else {
            $result = Company::where('owner', Auth::user()->email)
                             ->where('active', 1)
                             ->findOrFail($company);
        }

        return view('panel.companies.edit', compact('result', 'admin'));
    }

    /**
     * Update company
     */
    public function update(Company $company, Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'name'              => ['required', 'min:3', Rule::unique('companies', 'name')->ignore($company->id)],
            'email'             => 'required|email|string|lowercase',
            'address'           => 'required|min:3',
            'invoice_number'    => 'required|min:3',
            'reg_number'        => 'required|min:3',
            'bank_name'         => 'required|min:3',
            'bank_number'       => 'required|min:3',
        ]);

        if (Auth::user()->hasPermission('Admin')) {
            $request->validate([
                'owner'             => 'required|email|string|lowercase|exists:user,email',
            ]);

            $req = $request->all();
        } else {
            $req = $request->except(['owner', 'active']);
        }

        $company->update($req);

        return back()->with('status', 'information-updated');
    }

    /**
     * Activate/Deactivate company
     */
    public function status(Company $company, Request $request)
    {
        if (!Auth::user()->hasPermission('Admin')) {
            return back();
        }

        $status = $company->active == 1 ? null : 1;

        $company->update([
            'active' => $status
        ]);

        $owner = User::where('email', $company->owner)->first();
        $owner->notify(new CompanyStatus($company, $owner));

        return back()->with('status', 'company-updated');
    }
}
