<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderService
{
    public function getUserOrders()
    {
        return Auth::user()->orders;
    }

    public function getOrderById($id)
    {
        return Auth::user()->orders()->findOrFail($id);
    }

    public function createOrder(Request $request)
    {
        $order = Auth::user()->orders()->create($request->all());
        return $order;
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Auth::user()->orders()->findOrFail($id);
        $order->update($request->all());
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);
        $order->delete();
    }
}
