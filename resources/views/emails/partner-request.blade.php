<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$subject}}</title>
</head>
<body>
<h2>Новая заявка на партнёрство на {{config('app.name')}}.</h2>

<h3>Данные клиента</h3>
<p>Имя: {{$name}}</p>
<p>Телефон: {{$phone}}</p>
<p>Почта: {{$email}}</p>
<p>Комментарий: {{$clientMessage}}</p>
</body>
</html>
