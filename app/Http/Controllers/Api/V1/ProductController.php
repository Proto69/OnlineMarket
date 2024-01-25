<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\V1\ProductFilter;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Response;


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
    public function store(StoreProductRequest $request)
    {
        $name = $request->name;
        $description = $request->description;
        $quantity = $request->quantity;
        $price = $request->price;
        $bought_quantity = 0;
        $currency = "eur";
        $active = 1;
        $product_key = getProductKey();
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
        $newState = $request->state;

        $product = Product::where('id', $productId)->first();

        if ($product) {
            $product->quantity = $newQuantity;
            $product->name = $newName;
            $product->description = $newDescription;
            $product->price = $newPrice;
            $product->active = $newState;

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
    public function getProductKey() : string
    {

        return "";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
