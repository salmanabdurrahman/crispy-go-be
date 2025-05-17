<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required_if:order_type,pengiriman|string',
            'order_type' => 'required|in:pengiriman,ambil_di_tempat',
            'notes' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->messages(),
                'data' => null,
            ], 422);
        }

        $data = $validator->validated();

        $order = Order::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'order_type' => $data['order_type'],
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($data['items'] as $item) {
            $menu = Menu::findOrFail($item['menu_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price * $item['quantity'],
            ]);
        }

        return response()->json([
            'code' => 201,
            'message' => 'Order created successfully',
            'data' => $order->load('items'),
        ], 201);
    }
}
