<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\PurchaseReceipt;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Testing emails
    public function test($orderId)
    {
        $order = Order::find($orderId);
        $logs = Log::where('order_id', $orderId)->get();
        Mail::to(Auth::user())->send(new PurchaseReceipt($order, $logs));
        return redirect()->route('stats');
    }
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
    public function destroy($orderId)
    {
        $order = Order::find($orderId);
        $order->delete();

        return redirect()->back();
    }

    public function updateFullName($orderId, $fullName)
    {
        $order = Order::find($orderId);
        $order->full_name = $fullName;
        $order->save();
    }

    public function updatePhone($orderId, $phone)
    {
        $order = Order::find($orderId);
        $order->phone = $phone;
        $order->save();
    }

    public function updateAddress($orderId, $address)
    {
        $order = Order::find($orderId);
        $order->address = $address;
        $order->save();
    }

    public function editOrder($orderId, Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'quantity.*' => 'required|numeric|min:0', // Assuming the quantity is an array
        ], [
            'quantity.*.required' => __('Полетата за количество са задължителни.'),
            'quantity.*.numeric' => __('Количеството трябва да бъде числово.'),
            'quantity.*.min' => __('Количеството трябва да бъде поне 0.'),
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

    public function orderSent($orderId)
    {
        $logs = Log::where('order_id', $orderId)->where('sellers_user_id', Auth::user()->id)->get();
        foreach ($logs as $log) {
            $log->is_sent = true;
            $log->save();
        }

        $logs = Log::where('order_id', $orderId)->get();
        $is_sent = true;
        $is_delivered = true;
        foreach ($logs as $log) {
            if (!$log->is_sent) {
                $is_sent = false;
            }
            if (!$log->is_delivered) {
                $is_delivered = false;
            }
        }

        if ($is_sent || $is_delivered) {
            $order = Order::find($orderId);
            $order->is_sent = $is_sent;
            $order->is_delivered = $is_delivered;
            $order->save();
        }

        // TODO: send email to customer for sent products

        return redirect()->route('sells');
    }

    public function logDelivered($logId)
    {
        $log = Log::find($logId);
        $log->is_delivered = true;
        $log->save();

        $logs = Log::where('order_id', $log->order_id)->get();
        $is_sent = true;
        $is_delivered = true;
        foreach ($logs as $log) {
            if (!$log->is_sent) {
                $is_sent = false;
            }
            if (!$log->is_delivered) {
                $is_delivered = false;
            }
        }

        if ($is_sent || $is_delivered) {
            $order = Order::find($log->order_id);
            $order->is_sent = $is_sent;
            $order->is_delivered = $is_delivered;
            $order->save();
        }

        // TODO: send email to customer

        return redirect()->route('previous-purchases');
    }

    public function orderDelivered($orderId)
    {
        $logs = Log::where('order_id', $orderId)->where('sellers_user_id', Auth::user()->id)->get();
        foreach ($logs as $log) {
            $log->is_delivered = true;
            $log->save();
        }

        $order = Order::find($orderId);
        $order->is_sent = true;
        $order->is_delivered = true;
        $order->save();
        
        return redirect()->route('previous-purchases');

    }
}
