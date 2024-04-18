<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Log;

class CommentController extends Controller
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
    public function store(Request $request, $product_id)
    {
        $validated = $request->validate([
            'rating' => 'required',
            'comment' => 'required|string',
        ], [
            'comment.required' => 'Полето за коментар е задължително.',
            'comment.string' => 'Полето за коментар трябва да бъде текст.',
        ]);

        $userId = Auth::user()->id;
        $validated['user_id'] = $userId;
        $validated['product_id'] = $product_id;

        $orders = Order::where('buyers_user_id', $userId)->get();

        $orderIds = $orders->pluck('id')->toArray();

        // Retrieve all logs related to the orders
        $logs = Log::whereIn('order_id', $orderIds)
            ->where('product', $product_id)
            ->get();

        $validated['is_bought'] = $logs->isNotEmpty();;

        Comment::create($validated);

        return redirect()->back()->with('success', 'Comment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
