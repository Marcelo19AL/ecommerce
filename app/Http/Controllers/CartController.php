<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function show(Cart $cart)
    {
        return response()->json($cart->load('items.product'));
    }

    public function addItem(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cartItem = $cart->items()->create($request->all());
        return response()->json(['cartItem' => $cartItem], 201);
    }

    public function updateItem(Request $request, Cart $cart, CartItem $item)
    {
        $item->update($request->only('quantity'));
        return response()->json(['message' => 'Cart item updated successfully', 'item' => $item]);
    }

    public function removeItem(Cart $cart, CartItem $item)
    {
        $item->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
