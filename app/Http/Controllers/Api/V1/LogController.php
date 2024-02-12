<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Models\Log;
use App\Models\Product;
use App\Http\Controllers\Controller;

class LogController extends Controller
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
    public function store(StoreLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLogRequest $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($logId)
    {
        Log::find($logId)->delete();
    }

    public function editQuantity($logId, $newQuantity)
    {
        $log = Log::find($logId);

        $log->quantity = $newQuantity;

        $log->save();

        $logs = Log::where('order_id', $log->order_id)->get();

        $products = [];

        foreach($logs as $log){
            $product = Product::find($log->product);
            $products[$product->id] = $product;
        }

        return response()->json($products);
    }
}
