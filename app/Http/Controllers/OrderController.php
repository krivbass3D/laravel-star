<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            $this->orderService->createOrder($request->all());
            return redirect()->route('home')->with('success', 'Order placed successfully! Check your email for confirmation.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
} 