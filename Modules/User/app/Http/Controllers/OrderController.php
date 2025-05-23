<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Product;
use Modules\User\Models\Order;
use Modules\User\Models\OrderItem;

class OrderController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cash_on_delivery,credit_card',
        ]);

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $total = 0;

            // Calculate total
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->quantity < $item['quantity']) {
                    return response()->json(['error' => "Insufficient stock for product: {$product->name}"], 400);
                }

                $total += $product->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'status' => 'pending',
                ]);

                // Optional: decrease product stock
                $product->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order failed', 'message' => $e->getMessage()], 500);
        }
    }
}