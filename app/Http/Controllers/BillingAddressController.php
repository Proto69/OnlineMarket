<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Полето за име е задължително.',
            'phone.required' => 'Полето за телефонен номер е задължително.',
            'address.required' => 'Полето за адрес е задължително.',
            'full_name.string' => 'Полето за име трябва да бъде текст.',
            'phone.string' => 'Полето за телефонен номер трябва да бъде текст.',
            'address.string' => 'Полето за адрес трябва да бъде текст.',
            'full_name.max' => 'Полето за име не може да бъде по-дълго от 255 символа.',
            'phone.max' => 'Полето за телефонен номер не може да бъде по-дълго от 20 символа.',
            'address.max' => 'Полето за адрес не може да бъде по-дълго от 255 символа.',
        ]);

        $validated['user_id'] = Auth::user()->id;

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
    public function destroy($billingAddressId)
    {
        $billingAddress = BillingAddress::find($billingAddressId);
        $billingAddress->delete();

        return redirect()->back();
    }

    public function editBillingAddress($billingAddressId)
    {
        // Validate the incoming request data with custom messages
        $validated = request()->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Полето за име е задължително.',
            'phone.required' => 'Полето за телефонен номер е задължително.',
            'address.required' => 'Полето за адрес е задължително.',
            'full_name.string' => 'Полето за име трябва да бъде текст.',
            'phone.string' => 'Полето за телефонен номер трябва да бъде текст.',
            'address.string' => 'Полето за адрес трябва да бъде текст.',
            'full_name.max' => 'Полето за име не може да бъде по-дълго от 255 символа.',
            'phone.max' => 'Полето за телефонен номер не може да бъде по-дълго от 20 символа.',
            'address.max' => 'Полето за адрес не може да бъде по-дълго от 255 символа.',
        ]);

        // Retrieve the billing address record from the database
        $billingAddress = BillingAddress::find($billingAddressId);

        // Update the billing address record with the validated data and save it
        $billingAddress->update($validated);

        // Optionally, you can redirect the user back with a success message
        return redirect()->back()->with('success', 'Billing address updated successfully.');
    }
}
