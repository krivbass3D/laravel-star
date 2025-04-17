<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $total = number_format($this->order->total_amount, 2);
        
        return (new MailMessage)
            ->subject('Заказ #' . $this->order->id . ' успешно создан')
            ->greeting('Здравствуйте, ' . $this->order->name . '!')
            ->line('Спасибо за ваш заказ. Мы получили его и начали обработку.')
            ->line('Детали заказа:')
            ->line('Номер заказа: #' . $this->order->id)
            ->line('Сумма заказа: €' . $total)
            ->line('Адрес доставки: ' . $this->order->address)
            ->action('Просмотреть заказ', url('/orders/' . $this->order->id))
            ->line('Если у вас есть вопросы, пожалуйста, свяжитесь с нами.');
    }
} 