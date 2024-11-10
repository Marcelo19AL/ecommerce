<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function index()
    {
        return response()->json(Shipping::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|string|max:255|unique:shippings',
            'cost' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shipping = Shipping::create($request->all());
        return response()->json(['shipping' => $shipping], 201);
    }

    public function update(Request $request, Shipping $shipping)
    {
        $shipping->update($request->all());
        return response()->json(['message' => 'Shipping updated successfully', 'shipping' => $shipping]);
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
        return response()->json(['message' => 'Shipping deleted successfully']);
    }
}
