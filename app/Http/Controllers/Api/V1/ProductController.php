<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\V1\ProductFilter;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
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

    public function listAllAvailableProducts()
    {
        $products = Product::where('active', 1)->get();

        return response()->json($products);
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

        $validated['bought_quantity'] = 0;
        $validated['currency'] = "bgn";
        $validated['active'] = 1;
        $validated['seller_user_id'] = Auth::user()->id;

        if (request()->has('image')) {
            $imagePath = request()->file('image')->store('product', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Product created successfully.');
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
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|min:1',
            'price' => 'required|min:0',
            'image' => 'image'
        ]);

        $product = Product::find($request->product_id);

        if ($product) {
            $product->update($validated);

            if (request()->has('image')) {
                $imagePath = request()->file('image')->store('product', 'public');
                Storage::disk('public')->delete($product->image);
                $product->image = $imagePath;
                $product->save();
            }

            return redirect()->route('dashboard');
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function changeStatus($product_id, $status)
    {
        $product = Product::where('id', $product_id)->first();
        $product->active = $status;
        $product->save();
    }
}
