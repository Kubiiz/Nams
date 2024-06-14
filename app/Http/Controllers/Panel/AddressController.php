<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Apartment;
use App\Models\Company;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Addresses\CreateAddressRequest;
use App\Http\Requests\Addresses\UpdateAddressRequest;
use App\Http\Requests\Addresses\CreateManagerRequest;
use App\Http\Requests\Addresses\UpdateSettingsRequest;

class AddressController extends Controller
{
    /**
     * Show addresses
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;
        $count = [];

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

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'count'));
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
    public function store(CreateAddressRequest $request)
    {
        $settings = [
            'counter'       => null,
            'counter_from'  => null,
            'counter_to'    => null,
        ];

        Address::create($request->merge([
            'company_id' => $request->company,
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
        $managers = [];
        $managerList = [];

        if ($isAdmin) {
            $result = Address::with('company')->withTrashed()->findOrFail($address);
        } else {
            $result = Address::with('company')->findOrFail($address);
        }

        if ($result->managers) {
            $managerList = explode('|', $result->managers);
            $managers = User::whereIn('email', $managerList)->get();
        }

        $perm = Auth::user()->isOwner($result->company_id);
        $settings = json_decode($result->settings, true);

        if (!$isAdmin && !$perm) {
           return back();
        }

        return view('panel.addresses.edit', compact('result', 'perm', 'isAdmin', 'managers', 'settings'));
    }

    /**
     * Update address
     */
    public function update(Address $address, UpdateAddressRequest $request)
    {
        if (!Auth::user()->isOwner($address->company_id)) {
            return back();
        }

        $address->update($request->except(['company_id']));

        return back()->with('status', 'address-updated');
    }

    // Delete/Restore address
    public function status($address)
    {
        $address = Address::withTrashed()->findOrFail($address);

        if ($address->trashed()) {
            $address->restore();
        } else {
            $address->delete();
        }

        return back()->with('status', 'address-status');
    }

    /**
     * Update settings
     */
    public function settings(Address $address, UpdateSettingsRequest $request)
    {
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
    public function managerCreate(Address $address, CreateManagerRequest $request)
    {
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
