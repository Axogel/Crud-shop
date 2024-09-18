<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('products', 'user')->get();

        return response()->json($orders, 200);
    }
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'products' => 'required|array', 
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1', 
        ]);

        // Crear la orden
        $order = Order::create([
            'user_id' => $validatedData['user_id'],
            'amount' => $validatedData['amount'],
        ]);

        // Asociar productos a la orden
        foreach ($validatedData['products'] as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json($order->load('products'), 201); 
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'products' => 'sometimes|array',
            'products.*.id' => 'sometimes|exists:products,id',
            'products.*.quantity' => 'sometimes|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'user_id' => $validatedData['user_id'],
            'amount' => $validatedData['amount'],
        ]);

        if (isset($validatedData['products'])) {
            $order->products()->detach();
            foreach ($validatedData['products'] as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }
        }

        return response()->json($order->load('products'), 200);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->products()->detach();
        $order->delete();

        return response()->json(null, 204);
    }
}
