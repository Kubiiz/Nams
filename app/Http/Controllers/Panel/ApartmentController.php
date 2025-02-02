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
use App\Http\Requests\Apartments\CreateApartmentRequest;

class ApartmentController extends Controller
{
    /**
     * Show apartments
     */
    public function index(SearchRequest $request = null)
    {
        $search = null;

        $result = Apartment::with('addresses');

        if ($request) {
            $search = $request->input('search');

            $result = $result->where('address', 'LIKE', "%$search%")->sortable();
        }

        if (!Auth::user()->isAdmin()) {
            $email = Auth::user()->email;

            $companies = Company::with('addresses')->where('owner', $email)->get();
            $addresses = Address::whereIn('company_id', $companies->select('id'))->orWhere('managers', 'LIKE', "%$email%");

            $result = $result->whereIn('address_id', $addresses->select('id'));
        } else {
            $result = $result->withTrashed();
        }

        $result = $result->sortable()->paginate(10);

        return view('panel.apartments.index', compact('result', 'search'));
    }

    /**
     * Search apartments
     */
    public function search(SearchRequest $request)
    {
        return $this->index($request);
    }

    /**
     * Store apartments
     */
    public function store(CreateApartmentRequest $request)
    {
        $settings = [
            'counter' => null,
            'counter_from' => null,
            'counter_to' => null,
        ];

        $address = Address::create($request->merge([
            'company_id' => $request->company,
            'settings' => json_encode($settings)
        ])->toArray());

        Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Created address ($address->address)");

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
        Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Updated address ($address->address)");

        return back()->with('status', 'address-updated');
    }

    // Delete/Restore address
    public function status($address)
    {
        $address = Address::withTrashed()->findOrFail($address);

        if ($address->trashed()) {
            $address->restore();
            Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Restored address ($address->address)");
        } else {
            Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Deleted address ($address->address)");
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
            'counter' => $request->counter,
            'counter_from' => $request->counter_from,
            'counter_to' => $request->counter_to,
        ];

        $address->update([
            'settings' => json_encode($settings),
        ]);

        Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Changed address settings ($address->address)");

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

        Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Added manager to address ($address->address)");

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

        Auth::user()->createLog(route('panel.addresses.edit', $address->id), "Removed address manager ($address->address)");

        return back()->with('status', 'manager-removed')->withInput();
    }
}
