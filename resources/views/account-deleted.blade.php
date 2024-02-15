<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Баннат акаунт</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
@php
use Illuminate\Support\Facades\Auth;
@endphp

<body class="bg-gray-900 text-white flex items-center justify-center h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md">
        <h1 class="text-2xl font-bold mb-4">Твоят акаунт беше баннат!</h1>
        <p class="text-gray-300 mb-8">От твоя акаунт бяха качени неподходящи продукти и затова, ние предприехме действия!</p>
        @if ($firstAppeal)
        <form action="{{ route('appealing', Auth::user()->id) }}" method="POST">
            @csrf
            <textarea name="text" class="bg-gray-700 text-white w-full p-3 rounded mb-4" rows="4" placeholder="Защити се ако мислиш че е станала грешка..."></textarea>
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 inline-block">Обжалване на наказание</button>
        </form>
        @else
        <x-paid-log>
            Успешно подаде обжалване на наказание! Ще бъде разгледано скоро!
        </x-paid-log>
        @endif
    </div>
</body>

</html>