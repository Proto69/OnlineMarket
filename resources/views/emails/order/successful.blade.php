<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детайли на поръчката</title>
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    @php
    use App\Models\Product;
    @endphp
    <div class="container mx-auto p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-4">Детайли на поръчката</h1>

        <div class="mx-0 border-y border-lime-500 dark:border-lime-400 py-3">
            <div class="receipt-section">
                @foreach($logs as $log)
                @php
                $product = Product::where('id', $log->product)->first();
                @endphp
                <p class="ps-3 dark:text-gray-400 text-gray-900">
                    <strong>{{ $product->name }}</strong> x <strong>{{ $log->quantity }}</strong> = <strong>{{ $product->price * $log->quantity}}</strong>
                </p>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col items-center justify-end px-4 mb-4">
            <h1 class="total-sum ps-3 dark:text-lime-200 text-lime-600 font-bold text-2xl mt-2 mb-6">
                Обща сума: {{ $order->total_price }}лв
            </h1>
        </div>
        <br />
        <h1 class="text-xl font-semibold mt-6">Информация за доставка:</h1>
        <p class="mb-2"><strong>Получател:</strong> {{ $order->full_name }}</p>
        <p class="mb-2"><strong>Телефонен номер:</strong> {{ $order->phone }}</p>
        <p class="mb-2"><strong>Адрес за доставка:</strong> {{ $order->address }}</p>
    </div>
</body>

</html>