<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        /* Styles for centering content and background color */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
            /* Choose your preferred background color */
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            /* Choose your preferred background color */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
            /* Choose your preferred text color */
        }

        p {
            margin-bottom: 10px;
            color: #666666;
            /* Choose your preferred text color */
        }

        strong {
            color: #007bff;
            /* Choose your preferred text color */
        }
    </style>
</head>

<body>
    @php
    use App\Models\Product;
    @endphp
    <div class="container">
        <h1>Поръчка № {{ $order->id }}</h1>

        <table>
            <tr>
                <th>Продукт</th>
                <th>Количество</th>
                <th>Дата на закупуване</th>
                <th>Цена</th>
            </tr>
            @foreach($logs as $log)
            <tr>
                <td>{{ Product::where('id', $log->product)->first()->name }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->created_at }}</td>
                <td>{{ Product::where('id', $log->product)->first()->price * $log->quantity }}лв.</td>
            </tr>
            @endforeach
        </table>

        <h1>Информация за доставка:</h1>
        <p>Получател: <strong>{{ $order->full_name }}</strong></p>
        <p>Телефонен номер: <strong>{{ $order->phone }}</strong></p>
        <p>Адрес за доставка: <strong>{{ $order->address}}</strong></p>
        <p>Обща сума: <strong>{{ $order->total_price }}лв</strong></p>
    </div>
</body>

</html>