<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Notifications\NewCompany;
use App\Notifications\CompanyStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Http\Requests\SearchRequest;

class CompanyController extends Controller
{
    /**
     * Show companies
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;
        $perm = Auth::user()->isAdmin() ?? false;
        $result = Company::query();

        if ($request) {
            $search = $request->input('search');

            $result = Company::whereAny([
                'name',
                'owner',
                'email',
                'address',
            ], 'LIKE', "%$search%");
        }

        if (!$perm) {
            $result = $result->where('owner', Auth::user()->email);
        } else {
            $result = $result->withTrashed();
        }

        $result = $result->sortable()->paginate(10);

        return view('panel.companies.index', compact('result', 'search', 'perm'));
    }

    /**
     * Search companies
     */
    public function search(SearchRequest $request)
    {
        return $this->index($request);
    }

    /**
     * Create company
     */
    public function create()
    {
        return view('panel.companies.create');
    }

    /**
     * Store company
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|min:3|unique:companies,name',
            'owner'             => 'required|email|exists:users,email',
        ]);

        $company = Company::create($request->all());
        //$owner->notify(new NewCompany($company, $owner));

        return redirect()->route('panel.companies.edit', $company->id);
    }

    /**
     * Edit company
     */
    public function edit($company)
    {
        $admin = Auth::user()->isAdmin();

        if (!Auth::user()->isOwner($company)) {
            return back();
        }

        if ($admin) {
            $result = Company::withTrashed()->findOrFail($company);
        } else {
            $result = Company::findOrFail($company);
        }

        return view('panel.companies.edit', compact('result', 'admin'));
    }

    /**
     * Update company
     */
    public function update(Company $company, Request $request)
    {
        if (!Auth::user()->isOwner($company->id)) {
            return back();
        }

        $request->validate([
            'name'              => ['required', 'min:3', Rule::unique('companies', 'name')->ignore($company->id)],
            'email'             => 'required|email|string|lowercase',
            'address'           => 'required',
            'reg_number'        => 'required',
            'bank_name'         => 'required',
            'bank_number'       => 'required',
        ]);

        if (Auth::user()->isAdmin()) {
            $request->validate([
                'owner'             => 'required|email|string|lowercase|exists:users,email',
                'count'             => 'required|numeric|min:1',
            ]);

            $req = $request->all();
        } else {
            $req = $request->except(['owner', 'count']);
        }

        $company->update($req);

        return back()->with('status', 'information-updated');
    }

    /**
     * Activate/Deactivate company
     */
    public function status($company, Request $request)
    {
        $company = Company::withTrashed()->findOrFail($company);

        if ($company->trashed()) {
            $company->restore();
        } else {
            $company->delete();
        }

        //$owner = User::where('email', $company->owner)->first();
        //$owner->notify(new CompanyStatus($company, $owner));

        return back()->with('status', 'company-updated');
    }
}
