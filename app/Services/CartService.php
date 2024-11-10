<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        return session()->get('cart', []);
    }

    public function addProductToCart($productId, $quantity)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        // Verificar si el producto ya está en el carrito
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);
    }

    public function removeProductFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
    }
}
