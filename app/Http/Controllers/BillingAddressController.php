<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use Illuminate\Http\Request;

class BillingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data with custom messages
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Полето за име е задължително.',
            'phone.required' => 'Полето за телефонен номер е задължително.',
            'address.required' => 'Полето за адрес е задължително.',
            'name.string' => 'Полето за име трябва да бъде текст.',
            'phone.string' => 'Полето за телефонен номер трябва да бъде текст.',
            'address.string' => 'Полето за адрес трябва да бъде текст.',
            'name.max' => 'Полето за име не може да бъде по-дълго от 255 символа.',
            'phone.max' => 'Полето за телефонен номер не може да бъде по-дълго от 20 символа.',
            'address.max' => 'Полето за адрес не може да бъде по-дълго от 255 символа.',
        ]);

        BillingAddress::create($validated);

        return redirect()->route('billing-addresses')->with('success', 'Billing address created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillingAddress $billingAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillingAddress $billingAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillingAddress $billingAddress)
    {
        //
    }
}
