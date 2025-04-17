<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        // Получаем статистику
        $stats = [
            'users' => User::count(),
            'products' => Product::where('is_active', true)->count(),
            'orders' => Order::count(),
            'total_income' => Order::sum('total_amount'),
        ];

        // Логируем статистику
        Log::info('Dashboard Stats:', $stats);

        // Получаем последние заказы
        $latestOrders = Order::with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Логируем количество заказов
        Log::info('Latest Orders Count: ' . $latestOrders->count());

        $mappedOrders = $latestOrders->map(function ($order) {
            return [
                'id' => $order->id,
                'name' => $order->name,
                'email' => $order->email,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'created_at' => $order->created_at->format('d.m.Y H:i'),
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_title' => $item->product->title,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                }),
            ];
        });

        // Получаем последних клиентов
        $latestCustomers = User::where('is_admin', false)
            ->latest()
            ->take(3)
            ->get();

        // Логируем количество клиентов
        Log::info('Latest Customers Count: ' . $latestCustomers->count());

        $mappedCustomers = $latestCustomers->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
            ];
        });

        $data = [
            'stats' => $stats,
            'latestOrders' => $mappedOrders,
            'latestCustomers' => $mappedCustomers,
        ];

        // Логируем финальные данные
        Log::info('Dashboard Data:', $data);

        return Inertia::render('Admin/Dashboard', $data);
    }
} 