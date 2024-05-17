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
    // public function index()
    // {
    //     $search = null;
    //     $count = [];
    //     $perm = Auth::user()->hasPermission('Owner') ?? false;

    //     $result = Address::sortable();
    //     $companies = Company::where('active', 1);

    //     if (Auth::user()->hasPermission('Admin')) {
    //         $companies = $companies->get();
    //     } else {
    //         if ($perm) {
    //             $companies = $companies->where('owner', Auth::user()->email);
    //             $result = $result->whereIn('company_id', $companies->select('id'));
    //             $companies = $companies->get();
    //         } else {
    //             $companies = null;
    //             $result = $result->where('managers', Auth::user()->email);
    //         }
    //     }

    //     $result = $result->paginate(10);

    //     return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    // }

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

        if (!$perm) {
            return back();
        }

        $count = [];

        if (Auth::user()->hasPermission('Admin')) {
            $companies = Company::where('active', 1)->get();
            $result = Address::where('address','LIKE', "%$search%")->sortable()->paginate(10);
        } else {
            $companies = Company::with('addresses')->where('owner', Auth::user()->email)->where('active', 1)->get();
            $companiesIds = Company::select('id')->where('owner', Auth::user()->email)->where('active', 1);

            $result = Address::whereIn('company_id', $companiesIds)
                             ->where('address','LIKE', "%$search%")
                             ->sortable()
                             ->paginate(10);
        }

        return view('panel.addresses.index', compact('result', 'companies', 'search', 'perm', 'count'));
    }

    /**
     * Edit address
     */
    public function edit(Address $address)
    {
        $perm = Auth::user()->hasPermission('Owner') ?? false;
        $result = $address;

        if (Auth::user()->hasPermission('Owner')) {
            $exists = Company::where('id', $address->company_id)
                             ->where('active', 1)
                             ->exists();
        } elseif ($perm) {
            $exists = Company::where('id', $address->company_id)
                             ->where('owner', Auth::user()->email)
                             ->where('active', 1)
                             ->exists();
        } else {
            return redirect()->route('panel.addresses.index');
        }

        if (!$exists) {
            return back();
        }

        return view('panel.addresses.edit', compact('result', 'perm'));
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
        $perm = Auth::user()->hasPermission('Owner') ?? false;

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
}
