<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Requests\UpdateShoppingListRequest;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ShoppingListController extends Controller
{
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
    public function store(StoreShoppingListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingListRequest $request, ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $shoppingList)
    {
        //
    }

    public function addToShoppingList(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::user()->id;



        // Retrieve the product based on the provided ID
        $product = Product::find($productId);

        // Check if the product exists and is active
        if ($product && $product->active) {

            $shoppingListItem = ShoppingList::where('buyers_user_id', $userId)->where('products_id', $productId)->first();


            if ($shoppingListItem) {

                $newQuantity = $shoppingListItem->quantity + 1;

                $shoppingListItem->quantity = $newQuantity;

                $shoppingListItem->save();

                return response()->json(['message' => 'Quantity updated successfully']);
            } else {

                ShoppingList::create([
                    'buyers_user_id' => $userId,
                    'products_id' => $productId,
                    'quantity' => 1,
                ]);

                // Return a success response
                return response()->json(['message' => 'Продуктът беше добавен успешно към количката']);
            }
        }

        // Return an error response
        return response()->json(['message' => 'Invalid product or inactive']);
    }

    public function editShoppingQuantity(Request $request)
    {
        $productId = $request->product_id;
        $newBoughtQuantity = $request->new_bought_quantity;
        $userId = Auth::user()->id;

        // Validate and authorize the user
        $shoppingListItem = ShoppingList::where('buyers_user_id', $userId)
            ->where('products_id', $productId)
            ->firstOrFail(); // Fail if item not found or unauthorized

        // Update quantity and save
        $shoppingListItem->quantity = $newBoughtQuantity;
        $shoppingListItem->save();

        // Fetch updated product list and total sum
        $products = [];
        $sum = 0.00;

        $shoppingList = ShoppingList::where('buyers_user_id', $userId)->get();

        foreach ($shoppingList as $item) {
            $product = Product::find($item->products_id);

            if ($product) {
                $product->bought_quantity = $item->quantity;
                $price = $product->price * $item->quantity;
                $sum += $price;
                $products[] = $product;
            }
        }

        // Prepare data to return
        $data = [
            'products' => $products,
            'sum' => $sum
        ];

        // Return a JSON response with the updated data
        return response()->json($data, Response::HTTP_OK);
    }

    public function editProduct(Request $request)
    {
        $productId = $request->product_id;
        $newQuantity = $request->new_quantity;
        $newName = $request->new_name;
        $newDescription = $request->new_description;
        $newPrice = $request->new_price;

        $product = Product::where('id', $productId)->get();

        if ($product) {
            $product->quantity = $newQuantity;
            $product->name = $newName;
            $product->description = $newDescription;
            $product->price = $newPrice;

            return response()->json(Response::HTTP_OK);
        }

        return response()->json(Response::HTTP_NOT_MODIFIED);

    }

    public function removeProduct(Request $request)
    {
        $user = Auth::user();

        $productId = $request->product_id;

        $shoppingList = ShoppingList::where('buyers_user_id', $user->id)->where('products_id', $productId)->delete();

        $shoppingList = ShoppingList::where('buyers_user_id', $user->id)->get();

        $products = [];

        $sum = 0.00;

        foreach ($shoppingList as $item) {
            $product = Product::find($item->products_id);

            if ($product) {
                $product->bought_quantity = $item->quantity;
                $price = $product->price * $item->quantity;
                $sum += $price;
                $products[] = $product;
            }
        }

        return view('buyer.shopping-cart', [
            'products' => $products,
            'sum' => $sum
        ]);
    }
}
