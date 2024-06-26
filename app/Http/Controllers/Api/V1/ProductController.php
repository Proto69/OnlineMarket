<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Characteristic;
use App\Models\Category;
use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\V1\ProductFilter;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
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

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|gt:0',
            'category' => 'required'
        ], [
            'name.required' => __('Полето за име е задължително.'),
            'name.min' => __('Името трябва да съдържа поне 3 символа.'),
            'name.max' => __('Името трябва да съдържа най-много 40 символа.'),
            'description.required' => __('Полето за описание е задължително.'),
            'description.min' => __('Описанието трябва да съдържа поне 5 символа.'),
            'description.max' => __('Описанието трябва да съдържа най-много 255 символа.'),
            'quantity.required' => __('Полето за количество е задължително.'),
            'quantity.min' => __('Количеството трябва да бъде поне 1.'),
            'quantity.numeric' => __('Цената трябва да бъде число.'),
            'price.required' => __('Полето за цена е задължително.'),
            'price.numeric' => __('Цената трябва да бъде число.'),
            'price.gt' => __('Цената трябва да бъде по-голяма от 0.'),
            'category.required' => __('Категорията е задължителна.')
        ]);

        $validated['bought_quantity'] = 0;
        $validated['currency'] = "bgn";
        $validated['active'] = 1;
        $validated['rating'] = 0;
        $validated['seller_user_id'] = Auth::user()->id;

        $product = Product::create($validated);

        $paths = [];

        if ($request->has('images')) {
            $files = $request->file('images'); // This will get all the files as an array

            foreach ($files as $file) {
                $path = $file->store('product', 'public'); // Store the file and get the path
                $paths[] = $path;

                // Create a new Image record in the database
                $image = new Image();
                $image->product_id = $product->id; // Set the product ID
                $image->image = $path; // Set the file path
                $image->save(); // Save the record
            }
            
            $product->image = $paths[0];
            $product->save();
        }



        foreach ($request->characteristics as $index => $characteristic) {
            // Check if the name and description keys exist
            if (isset($characteristic['name-c']) && isset($request->characteristics[$index + 1]['description-c'])) {
                // Create a new Characteristic model instance
                $characteristicModel = new Characteristic;
                $characteristicModel->name = $characteristic['name-c'];
                $characteristicModel->description = $request->characteristics[$index + 1]['description-c'];
                $characteristicModel->product_id = $product->id; // Assuming you have a relation to Product
                $characteristicModel->save();
            }
        }

        return redirect()->route('dashboard')->with('success', 'Product created successfully.')->json(['paths' => $paths]);
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
    public function edit($productId)
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'description' => 'required|min:5|max:255',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'required'
        ], [
            'name.required' => __('Полето за име е задължително.'),
            'name.min' => __('Името трябва да бъде поне 3 символа.'),
            'name.max' => __('Името трябва да бъде най-много 40 символа.'),
            'description.required' => __('Полето за описание е задължително.'),
            'description.min' => __('Описанието трябва да бъде поне 5 символа.'),
            'description.max' => __('Описанието трябва да бъде най-много 255 символа.'),
            'quantity.required' => __('Полето за количество е задължително.'),
            'quantity.numeric' => __('Количеството трябва да бъде число.'),
            'quantity.min' => __('Количеството трябва да бъде поне 0.'),
            'price.required' => __('Полето за цена е задължително.'),
            'price.numeric' => __('Цената трябва да бъде число.'),
            'price.min' => __('Цената не може да бъде по-малка от 0.'),
            'category.required' => __('Категорията е задължителна.')
        ]);

        $product = Product::find($productId);

        if ($product) {

            $categoryCountUpdate = $product->category == request()->category;

            $product->update($validated);

            if (request()->has('image')) {
                $imagePath = request()->file('image')->store('product', 'public');
                Storage::disk('public')->delete($product->image);
                $product->image = $imagePath;
                $product->save();
            }

            if (!$categoryCountUpdate) {
                $category = Category::find(request()->category);
                $category->products_count += 1;
                $category->save();
            }

            if (request()->characteristics !== null) {
                Characteristic::where('product_id', $productId)->delete();

                foreach (request()->characteristics as $index => $characteristic) {
                    // Check if the name and description keys exist
                    if (isset($characteristic['name-c']) && isset(request()->characteristics[$index + 1]['description-c'])) {
                        // Create a new Characteristic model instance
                        $characteristicModel = new Characteristic;
                        $characteristicModel->name = $characteristic['name-c'];
                        $characteristicModel->description = request()->characteristics[$index + 1]['description-c'];
                        $characteristicModel->product_id = $product->id; // Assuming you have a relation to Product
                        $characteristicModel->save();
                    }
                }
            }

            return redirect()->route('dashboard');
        }

        return response()->json(['error' => 'Продуктът не е намерен'], 404);
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
