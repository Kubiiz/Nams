<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
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
        $perm = Auth::user()->isOwner();

        $result = Address::with('company')->sortable();
        $companies = Company::with('addresses')->select(['id', 'name', 'count']);

        if (!Auth::user()->isAdmin()) {
            $email = Auth::user()->email;

            $companies = $companies->where('owner', $email)->get();
            $result = $result->whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");
        } else {
            $companies = $companies->get();
        }

        $result = $result->paginate(10);

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    }

    /**
     * Create addresses
     */
    public function create()
    {
        return view('panel.addresses.create');
    }

    /**
     * Store addresses
     */
    public function store(Request $request)
    {
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

        if (!Auth::user()->isAdmin() && $company->owner != Auth::user()->email) {
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
        $perm = Auth::user()->isOwner();

        $request->validate([
            'search'      => 'required|string',
        ]);

        $search = $request->input('search');
        $count = [];

        $result = Address::with('company')->where('address','LIKE', "%$search%")->sortable();
        $companies = Company::with('addresses')->select(['id', 'name', 'count']);

        if (!Auth::user()->isAdmin()) {
            $email = Auth::user()->email;

            if ($perm) {
                $companies = $companies->where('owner', Auth::user()->email);
                $result = $result->whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");
            } else {
                $companies = null;
                $result = $result->where('managers', 'LIKE', "%$email%");
            }
        }

        $result = $result->paginate(10);
        $companies = $companies->get();

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
                         ->exists();

        if (!Auth::user()->isAdmin() && !$isManager && !$perm) {
            return back();
        }

        return view('panel.addresses.edit', compact('result', 'perm', 'managers'));
    }

    /**
     * Update address
     */
    public function update(Address $address, Request $request)
    {
        $perm = Company::where('id', $address->company_id)
            ->where('owner', Auth::user()->email)
            ->where('active', 1)
            ->exists();

        if (!Auth::user()->isOwner() && !$perm) {
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
        $perm = Company::where('id', $address->company_id)
            ->where('owner', Auth::user()->email)
            ->exists();

        if (!$perm) {
            return back();
        }

        // Remove manager(s) permission
        $managers = explode('|', $address->managers);

        if (count($managers) > 0) {
            foreach ($managers as $manager) {
                Permission::remove('company', User::where('email', $manager)->first()->id, ['Manager']);
            }
        }

        $address->update([
            'active' => 0,
        ]);

        return redirect()->route('panel.addresses.index');
    }

    /**
     * Add manager to address
     */
    public function managerCreate(Address $address, Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $managers = explode('|', $address->managers);


        if (in_array($request->email, $managers)) {
            return back()
                ->withInput()
                ->withErrors(['email' => __('This manager already exists to this address.')]);
        }

        if ($request->email == $address->company->owner) {
            return back()
                ->withInput()
                ->withErrors(['email' => __('Company owner cannot be manager of this address.')]);
        }

        $address->update([
            'managers' => $address->managers ? $address->managers . '|' . $request->email : $request->email,
        ]);

        return back()->with('status', 'manager-added');
    }

    // Remove manager from address
    public function managerDestroy(Address $address, Request $request)
    {
        $managers = explode('|', $address->managers);

        if (!in_array($request->manager, $managers)) {
            return back()->with('status', 'manager-error');
        }

        unset($managers[array_search($request->manager, $managers)]);

        $managers = implode('|', $managers);

        $address->update([
            'managers' => $managers,
        ]);

        return back()->with('status', 'manager-removed')->withInput();
    }
}
