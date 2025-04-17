@component('mail::message')
# Заказ #{{ $order->id }} успешно создан

Здравствуйте, {{ $order->name }}!

Спасибо за ваш заказ. Мы получили его и начали обработку.

**Детали заказа:**

Номер заказа: #{{ $order->id }}
Сумма заказа: €{{ number_format($order->total_amount, 2) }}
Адрес доставки: {{ $order->address }}

**Товары в заказе:**

@component('mail::table')
| Товар | Количество | Цена |
|:------|:----------:|-----:|
@foreach($order->items as $item)
| {{ $item->product->title }} | {{ $item->quantity }} | €{{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

**Общая сумма: €{{ number_format($order->total_amount, 2) }}**

@component('mail::button', ['url' => url('/orders/' . $order->id)])
Просмотреть заказ
@endcomponent

Если у вас есть вопросы, пожалуйста, свяжитесь с нами.

С уважением,<br>
{{ config('app.name') }}
@endcomponent 