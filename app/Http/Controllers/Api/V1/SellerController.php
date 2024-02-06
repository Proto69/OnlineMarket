<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Models\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function dash()
    {
        $user = Auth::user();
        $userId = $user->id;
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            return response()->json(['error' => 'You are not a seller'], 401);
        }

        $products = Product::where('seller_user_id', $userId)->get();

        return response()->json($products);
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
    public function store(StoreSellerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product_id)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            return response()->json(['error' => 'You are not a seller'], 401);
        }

        $product = Product::where('id', $product_id)->first();

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|min:1',
            'price' => 'required|min:0',
            'image' => 'image'
        ]);

        $validated['id'] = $request->product_id;
        $validated['quantity'] = $request->quantity;
        $validated['name'] = $request->name;
        $validated['description'] = $request->description;
        $validated['price'] = $request->price;

        $product = Product::where('id', $request->product_id)->first();

        if ($product) {
            if (request()->has('image')) {
                $imagePath = request()->file('image')->store('product', 'public');
                $validated['image'] = $imagePath;

                Storage::disk('public')->delete($product->image);
            }

            $product->update($validated);

            return response()->json($product, 200);
        }

        return response()->json(Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            return response()->json(['error' => 'You are not a seller'], 401);
        }

        $product = Product::where('id', $request->product_id)->first();

        if ($product) {
            $product->delete();

            return response()->json(['message' => 'Product deleted'], 200);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }
}
