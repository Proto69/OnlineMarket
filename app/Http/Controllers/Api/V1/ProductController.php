<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\V1\ProductFilter;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductFilter();
        $queryItems = $filter->transform($request); // ['column', 'operator', 'value']

        $products = Product::query();

        if (count($queryItems) > 0) {
            $products->where($queryItems);
        }

        return new ProductCollection($products->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|min:1',
            'price' => 'required|min:0',
            'image' => 'image'
        ]);

        $bought_quantity = 0;
        $currency = "eur";
        $active = 1;
        $seller_user_id = Auth::user()->id;
        $product_key = ProductController::getProductKey();

        // Add additional fields to $validated array
        $validated['bought_quantity'] = $bought_quantity;
        $validated['currency'] = $currency;
        $validated['active'] = $active;
        $validated['product_key'] = $product_key;
        $validated['seller_user_id'] = $seller_user_id;

        if (request()->has('image')) {
            $imagePath = request()->file('image')->store('product', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $productId = $request->product_id;
        $newQuantity = $request->quantity;
        $newName = $request->name;
        $newDescription = $request->description;
        $newPrice = $request->price;

        $product = Product::where('id', $productId)->first();

        if ($product) {
            $product->quantity = $newQuantity;
            $product->name = $newName;
            $product->description = $newDescription;
            $product->price = $newPrice;

            $product->save();

            return response()->json(Response::HTTP_OK);
        }

        return response()->json(Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->checkIfAuthorized($product);
        $product->update($request->all());
    }

    // Function for getting product key from stripe API
    public function getProductKey(): string
    {

        return "";
    }

    public function changeStatus($product_id, $status)
    {
        $product = Product::where('id', $product_id)->first();
        
        $product->active = $status;

        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
