<?php

namespace SAAS\Http\Addresses\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Addresses\Models\Address;
use SAAS\Domain\Countries\Models\Country;
use SAAS\Http\Addresses\Requests\AddressStoreRequest;

class AddressController extends Controller
{
    /**
     * AddressController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->with([
            'country',
        ])->latest()->get();

        return view('account.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();

        return view('account.addresses.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \SAAS\Http\Addresses\Requests\AddressStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreRequest $request)
    {
        $request->user()->addAddress($request->only([
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

        return redirect()->route('account.addresses.index')
            ->withSuccess(__('Address added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
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
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
