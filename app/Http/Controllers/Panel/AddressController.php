<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Show addresses
     */
    public function index()
    {
        $search = null;
        $count = [];
        $perm = Auth::user()->hasPermission('Owner') ?? false;

        $result = Address::sortable();
        $companies = Company::where('active', 1);

        if (Auth::user()->hasPermission('Admin')) {
            $companies = $companies->get();
        } else {
            $email = Auth::user()->email;

            if ($perm) {
                $companies = $companies->where('owner', Auth::user()->email);
                $result = $result->whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");
                $companies = $companies->with('addresses')->select(['id', 'name', 'count'])->get();
            } else {
                $companies = null;
                $result = $result->where('managers', 'LIKE', "%$email%");
            }
        }

        $result = $result->paginate(10);

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    }

    /**
     * Create addresses
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        return view('panel.addresses.create');
    }

    /**
     * Store addresses
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'company'           => 'required|numeric|exists:companies,id',
            'address'           => 'required|min:3',
        ]);

        $company = Company::find($request->company);

        if ($company->addresses->count() >= $company->count) {
            return back()
                 ->withInput()
                 ->withErrors(['company' => __('":company" company has reached the limit of :count addresses', ['company' => $company->name, 'count' => $company->count])]);
        }

        if (!Auth::user()->hasPermission('Admin') && $company->owner != Auth::user()->email) {
            return back()
                 ->withInput()
                 ->withErrors(['company' => __('":company" company does not belong to You!', ['company' => $company->name])]);
        }

        Address::create($request->merge(['company_id' => $company->id])->toArray());

        return back()->with('status', 'address-created')->withInput();
    }

    /**
     * Search addresses
     */
    public function search(Request $request)
    {
        $perm = Auth::user()->hasPermission('Owner') ?? false;

        $request->validate([
            'search'      => 'required|string',
        ]);

        $search = $request->input('search');
        $count = [];

        $result = Address::where('address','LIKE', "%$search%")->sortable();
        $companies = Company::where('active', 1);

        if (Auth::user()->hasPermission('Admin')) {
            $companies = $companies->get();
        } else {
            $email = Auth::user()->email;

            if ($perm) {
                $companies = $companies->where('owner', Auth::user()->email);
                $result = $result->whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");
                $companies = $companies->with('addresses')->select(['id', 'name', 'count'])->get();
            } else {
                $companies = null;
                $result = $result->where('managers', 'LIKE', "%$email%");
            }
        }

        $result = $result->paginate(10);

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    }

    /**
     * Edit address
     */
    public function edit(Address $address)
    {
        $result = $address;
        $managers = $result->managers ? explode('|', $result->managers) : [];
        $email = Auth::user()->email;

        $isManager = in_array($email, $managers);
        $perm = Company::where('id', $address->company_id)
                         ->where('owner', $email)
                         ->where('active', 1)
                         ->exists();

        if (!Auth::user()->hasPermission('Admin') && !$isManager && !$perm) {
            return back();
        }

        return view('panel.addresses.edit', compact('result', 'perm', 'managers'));
    }

    /**
     * Update address
     */
    public function update(Address $address, Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'address'           => 'required|min:3',
        ]);

        $address->update($request->except(['company_id']));

        return back()->with('status', 'address-updated');
    }

    // Delete address
    public function destroy(Address $address)
    {
        if (Auth::user()->hasPermission('Owner')) {
            $exists = Company::where('id', $address->company_id)
                             ->where('owner', Auth::user()->email)
                             ->where('active', 1)
                             ->exists();
        } else if (Auth::user()->hasPermission('Admin')) {
            $exists = Company::where('id', $address->company_id)
                             ->where('active', 1)
                             ->exists();
        } else {
            return redirect()->route('panel.addresses.index');
        }

        if ($exists) {
            $address->delete();
        }

        return redirect()->route('panel.addresses.index');
    }

    /**
     * Add manager to address
     */
    public function managerCreate(Address $address, Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return back();
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $managers = explode('|', $address->managers);

        if (in_array($request->email, $managers)) {
            return back()
                ->withInput()
                ->withErrors(['email' => __('This manager already exists to this address.')]);
        }

        $address->update([
            'managers' => $address->managers ? $address->managers . '|' . $request->email : $request->email,
        ]);

        $user = User::where('email', $request->email)->first();

        // Create new permissions to manager
        Permission::create('user', $user->id, ['Manager']);

        return back()->with('status', 'manager-added');
    }

    // Remove manager from address
    public function managerDestroy(Address $address, Request $request)
    {
        if (!Auth::user()->hasPermission('Owner')) {
            return redirect()->route('panel.addresses.index');
        }

        $managers = explode('|', $address->managers);

        if (!in_array($request->manager, $managers)) {
            return back()->with('status', 'manager-error');
        }

        unset($managers[array_search($request->manager, $managers)]);

        // Remove manager permission
        Permission::remove('user', User::where('email', $request->manager)->first()->id, ['Manager']);

        $managers = implode('|', $managers);

        $address->update([
            'managers' => $managers,
        ]);

        return back()->with('status', 'manager-removed')->withInput();
    }
}
