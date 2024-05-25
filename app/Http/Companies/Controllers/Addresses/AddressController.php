<?php

namespace SAAS\Http\Companies\Controllers\Addresses;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Addresses\Models\Address;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Countries\Models\Country;
use SAAS\Http\Addresses\Requests\AddressStoreRequest;

class AddressController extends Controller
{
    /**
     * AddressController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['permission:update company,company:'.$request->company])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $addresses = $company->addresses()->with([
            'country',
        ])->latest()->get();

        return view('companies.addresses.index', compact('company', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        $countries = Country::get();

        return view('companies.addresses.create', compact('company', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreRequest $request, Company $company)
    {
        $company->addAddress($request->only([
            'name',
            'address_1',
            'address_2',
            'state',
            'city',
            'postal_code',
            'default',
            'billing',
            'country_id',
        ]));

        return redirect()->route('companies.edit', $company)
            ->withSuccess(__('Address added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, Address $address)
    {
        $address->fill($request->only('default', 'billing'));
        $address->save();

        return back()->withSuccess(
            __('Address #:address updated successfully.', ['address' => $address->id])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Address $address)
    {
        //
    }
}
