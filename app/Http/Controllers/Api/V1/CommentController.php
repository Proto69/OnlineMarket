<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Log;
use App\Models\Product;

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
    public function store($product_id)
    {
        $validated = request()->validate([
            'rating' => 'required|integer|min:0|max:5',
            'comment' => 'required|string',
        ], [
            'rating.required' => 'Полето за оценка е задължително.',
            'rating.integer' => 'Оценката трябва да бъде цяло число.',
            'rating.min' => 'Оценката не може да бъде по-малка от 0.',
            'rating.max' => 'Оценката не може да бъде по-голяма от 5.',
            'comment.required' => 'Полето за коментар е задължително.',
            'comment.string' => 'Полето за коментар трябва да бъде текст.',
        ]);


        $userId = Auth::user()->id;
        $product = Product::find($product_id);

        $oldComment = Comment::where('user_id', $userId)->where('product_id', $product_id)->first();

        if ($oldComment) {
            $oldComment->update($validated);
        } else {
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
        }

        $allComments = Comment::where('product_id', $product_id)->get();

        $rating = 0;

        foreach ($allComments as $comment) {
            $rating += $comment->rating;
        }

        $rating /= count($allComments);

        $rating = round($rating, 2);

        $product->rating = $rating; 

        $product->update();

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
