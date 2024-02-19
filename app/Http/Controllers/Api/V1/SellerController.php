<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreSellerRequest;
use App\Models\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function dash()
    {
        $user = Auth::user();
        $userId = $user->id;
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            return response()->json(['error' => 'Не си продавач'], 401);
        }

        $products = Product::where('seller_user_id', $userId)->get();

        return response()->json($products);
    }

    public function createProduct()
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|min:1',
            'price' => 'required|min:0',
            'image' => 'image'
        ], [
            'name.required' => __('Полето за име е задължително.'),
            'name.string' => __('Полето за име трябва да бъде текст.'),
            'name.min' => __('Името трябва да бъде поне 3 символа.'),
            'name.max' => __('Името не може да бъде по-дълго от 40 символа.'),
            'description.required' => __('Полето за описание е задължително.'),
            'description.string' => __('Полето за описание трябва да бъде текст.'),
            'description.min' => __('Описанието трябва да бъде поне 5 символа.'),
            'description.max' => __('Описанието не може да бъде по-дълго от 255 символа.'),
            'quantity.required' => __('Полето за количество е задължително.'),
            'quantity.numeric' => __('Количеството трябва да бъде число.'),
            'quantity.min' => __('Количеството трябва да бъде поне 1.'),
            'price.required' => __('Полето за цена е задължително.'),
            'price.numeric' => __('Цената трябва да бъде число.'),
            'price.min' => __('Цената не може да бъде по-малка от 0.'),
            'image.image' => __('Файлът трябва да бъде изображение.'),
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

        return response()->json(['message' => 'Продуктът е създаден'], 201);
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
            return response()->json(['error' => 'Не си продавач'], 401);
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
        ], [
            'name.required' => __('Полето за име е задължително.'),
            'name.string' => __('Полето за име трябва да бъде текст.'),
            'name.min' => __('Името трябва да бъде поне 3 символа.'),
            'name.max' => __('Името не може да бъде по-дълго от 40 символа.'),
            'description.required' => __('Полето за описание е задължително.'),
            'description.string' => __('Полето за описание трябва да бъде текст.'),
            'description.min' => __('Описанието трябва да бъде поне 5 символа.'),
            'description.max' => __('Описанието не може да бъде по-дълго от 255 символа.'),
            'quantity.required' => __('Полето за количество е задължително.'),
            'quantity.numeric' => __('Количеството трябва да бъде число.'),
            'quantity.min' => __('Количеството трябва да бъде поне 1.'),
            'price.required' => __('Полето за цена е задължително.'),
            'price.numeric' => __('Цената трябва да бъде число.'),
            'price.min' => __('Цената не може да бъде по-малка от 0.'),
            'image.image' => __('Файлът трябва да бъде изображение.'),
        ]);

        $validated['id'] = $request->product_id;
        $validated['quantity'] = $request->quantity;
        $validated['name'] = $request->name;
        $validated['description'] = $request->description;
        $validated['price'] = $request->price;

        $product = Product::where('id', $request->product_id)->first();

        if ($product) {

            if ($request->remove_existing_image == 'true') {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $validated['image'] = null;
            }
            if (request()->has('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $imagePath = request()->file('image')->store('product', 'public');
                $validated['image'] = $imagePath;
            }

            $product->update($validated);

            return response()->json($product, 200);
        }

        return response()->json(['message' => 'Продуктът не е намерен'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            return response()->json(['error' => 'Не си продавач'], 401);
        }

        $product = Product::where('id', $request->product_id)->first();

        if ($product) {
            $product->delete();

            return response()->json(['message' => 'Продуктът е изтрит'], 200);
        }

        return response()->json(['error' => 'Продуктът не е намерен'], 404);
    }
}
