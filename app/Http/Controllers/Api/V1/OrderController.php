<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function editOrder($orderId, Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'quantity.*' => 'required|numeric|min:0', // Assuming the quantity is an array
        ]);
    
        // Retrieve the logs associated with the order
        $logs = Log::where('order_id', $orderId)->get();
    
        // Loop through each log and update its quantity
        foreach ($logs as $log) {
            // Get the updated quantity from the request data
            $updatedQuantity = $request->input('quantity.' . $log->id);
    
            // Update the log's quantity
            $log->quantity = $updatedQuantity;
            $log->save();
        }
    
        // Redirect back to the edit order page with a success message
        return redirect()->route('previous-purchases');
    }
    
}
