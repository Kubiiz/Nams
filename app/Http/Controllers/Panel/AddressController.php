<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Company;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Http\Requests\SearchRequest;

class AddressController extends Controller
{
    /**
     * Show addresses
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;
        $count = [];
        $perm = Auth::user()->isOwner();

        $result = Address::with('company')->sortable();
        $companies = Company::with('addresses')->select(['id', 'name', 'count']);

        if ($request) {
            $search = $request->input('search');

            $result = Address::with('company')->where('address', 'LIKE', "%$search%")->sortable();
        }

        if (!Auth::user()->isAdmin()) {
            $email = Auth::user()->email;

            $companies = $companies->where('owner', $email)->get();
            $result = $result->whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");
        } else {
            $companies = $companies->get();
            $result = $result->withTrashed();
        }

        $result = $result->paginate(10);

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    }

    /**
     * Search addresses
     */
    public function search(SearchRequest $request)
    {
        return $this->index($request);
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

        $settings = [
            'counter'       => null,
            'counter_from'  => null,
            'counter_to'    => null,
        ];

        Address::create($request->merge([
            'company_id' => $company->id,
            'settings' => json_encode($settings)
            ])->toArray());

        return back()->with('status', 'address-created')->withInput();
    }

    /**
     * Edit address
     */
    public function edit($address)
    {
        $isAdmin = Auth::user()->isAdmin();

        if ($isAdmin) {
            $result = Address::with('company')->withTrashed()->findOrFail($address);
        } else {
            $result = Address::with('company')->findOrFail($address);
        }

        $managers = $result->managers ? explode('|', $result->managers) : [];

        $isManager = in_array(Auth::user()->email, $managers);
        $perm = Auth::user()->isOwner($result->company_id);
        $settings = json_decode($result->settings, true);

        if (!$isAdmin && !$isManager && !$perm) {
           return back();
        }

        return view('panel.addresses.edit', compact('result', 'perm', 'isAdmin', 'managers', 'settings'));
    }

    /**
     * Update address
     */
    public function update(Address $address, Request $request)
    {
        if (!Auth::user()->isOwner($address->company_id)) {
            return back();
        }

        $request->validate([
            'address'           => 'required|min:3',
        ]);

        $address->update($request->except(['company_id']));

        return back()->with('status', 'address-updated');
    }

    // Delete/Restore address
    public function status($address)
    {
        $address = Address::withTrashed()->findOrFail($address);
        $apartment = Apartment::where('address_id', $address->id);

        if ($address->trashed()) {
            $address->restore();
            $apartment->restore();
        } else {
            $address->delete();
            $apartment->delete();
        }

        return back()->with('status', 'address-status');
    }

    /**
     * Update settings
     */
    public function settings(Address $address, Request $request)
    {
        $request->validate([
            'counter'       => 'required|in:number,number_photo,random,without',
            'counter_from'  => 'required|numeric|min:1|max:31',
            'counter_to'    => 'required|numeric|min:1|max:31',
        ]);

        $settings = [
            'counter'       => $request->counter,
            'counter_from'  => $request->counter_from,
            'counter_to'    => $request->counter_to,
        ];

        $address->update([
            'settings' => json_encode($settings),
        ]);

        return back()->with('status', 'settings-updated');
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
