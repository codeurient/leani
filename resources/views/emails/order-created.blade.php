<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новый заказ LEANI</title>
</head>
<body>
<h2>Новый заказ с сайта {{config('app.name')}}. №{{$order->id}}, дата создания: {{$order->created_at->format('H:i:s d.m.Y')}}</h2>

<p>Состав заказа:
    @foreach($order->cart as $cart)
        {{$cart->product->name}} @if(!$loop->last), @endif
    @endforeach
</p>

<p>Контакты: {{$order->name . ' ' . $order->surname}}, {{$order->email}}, {{$order->phone}}</p>
<p>Адрес доставки: {!! $order->address->fullAddress !!}</p>
<p>Способ доставки: {!! $order->delivery->title !!}</p>

@if($order->comment)
    <p>Комментарий к заказу: {{$order->comment}}</p>
@endif

<h3>Спасибо за ваш заказ!</h3>
</body>
</html>
