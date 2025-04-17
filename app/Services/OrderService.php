<?php

namespace App\Services;

use App\Models\Order;
use App\Notifications\OrderCreated;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getPaginatedOrders(int $perPage = 10, string $search = ''): LengthAwarePaginator
    {
        return $this->orderRepository->getPaginatedOrders($perPage, $search);
    }

    public function createOrder(array $data): Order
    {
        try {
            DB::beginTransaction();

            $orderData = [
                'user_id' => auth()->id(),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'total_amount' => $data['total'],
                'status' => 'pending'
            ];

            $order = $this->orderRepository->createOrder($orderData, $data['items']);

            DB::commit();

            // Отправляем уведомление
            try {
                Notification::route('mail', $order->email)
                    ->notify(new OrderCreated($order));
            } catch (\Exception $e) {
                Log::error('Failed to send order notification: ' . $e->getMessage());
            }

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateOrderStatus(Order $order, string $status): bool
    {
        return $this->orderRepository->update($order->id, ['status' => $status]);
    }

    public function deleteOrder(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
} 