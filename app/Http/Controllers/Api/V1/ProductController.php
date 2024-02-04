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
use App\Models\Seller;
use Stripe\StripeClient;

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
        $currency = "bgn";
        $active = 1;
        $seller_user_id = Auth::user()->id;
        $product_key = ProductController::getProductStripeId(request()->name, request()->description, request()->price * 100);

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

            $priceInCents = $request->price * 100;

            $stripe_key = Seller::where('user_id', Auth::user()->id)->first()->stripe_key;
            $stripe = new StripeClient($stripe_key);

            $newPrice = false;

            if ($product->price != $request->price) {
                $priceResponse = $stripe->prices->create([
                        'currency' => 'bgn',
                        'unit_amount' => $priceInCents,
                        'product' => $product->product_key
                    ]);

                $priceId = $priceResponse->id;
                $newPrice = true;
            }

            if ($newPrice){
                $stripe->products->update(
                    $product->product_key,
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'default_price' => $priceId
                    ]
                );

                $stripe->prices->update(
                    $product->price_key,
                    [
                        'active' => false
                    ]
                );

                $validated['price_key'] = $priceId;
            }
            else {
                $stripe->products->update(
                    $product->product_key,
                    [
                        'name' => $request->name,
                        'description' => $request->description
                    ]
                );
            }


            $product->update($validated);

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

        $stripe_key = Seller::where('user_id', Auth::user()->id)->first()->stripe_key;
        $stripe = new StripeClient($stripe_key);

        $stripe->products->update(
            $product->product_key,
            [
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price
            ]
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    // Function for getting product key from stripe API
    private function getProductStripeId($name, $description, $price): string
    {
        $stripe_key = Seller::where('user_id', Auth::user()->id)->first()->stripe_key;
        $stripe = new StripeClient($stripe_key);
        $product = $stripe->products->create([
            'name' => $name,
            'default_price_data' => [
                'unit_amount' => $price,
                'currency' => 'bgn'
            ],
            'description' => $description
        ]);

        $id = $product->id;


        return $id;
    }

    // Function to change the status of the product
    public function changeStatus($product_id, $status)
    {
        $product = Product::where('id', $product_id)->first();

        $product->active = $status;

        $product->save();

        $stripe_key = Seller::where('user_id', Auth::user()->id)->first()->stripe_key;

        $stripe = new StripeClient($stripe_key);

        $active = false;
        if ($status == 1) {
            $active = true;
        }
        $product = $stripe->products->update(
            $product->product_key,
            [
                'active' => $active,
            ]
        );
    }
}
