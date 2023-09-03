<!DOCTYPE html>
<html>
<head>
    <title>Feedback Mail Template</title>
</head>
<body>
    <h2>Получено сообщение с формы обратной связи из приложения "TK"</h2>
    @empty($details['email'])
    @else
        <p><b>E-mail:</b> {{ $details['email'] }}</p>
    @endempty
    @empty($details['name'])
    @else
        <p><b>Имя:</b> {{ $details['name'] }}</p>
    @endempty
    <p><b>Сообщение:</b> {{ $details['message'] }}</p>
</body>
</html>