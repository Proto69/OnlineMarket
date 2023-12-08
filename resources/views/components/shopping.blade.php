@php

use App\Models\Product;
    use Illuminate\Support\Facades\Auth;

    $typeOfAccount = Auth::user()->type;

    $products = Product::all();
@endphp


<div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    
    @foreach($products as $product)
    <form method="POST" action="{{ route('add.to.shopping.list', $product->id) }}">
        @csrf
        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="https://laravel.com/docs">{{ $product->name}}</a>
                </h2>
            </div>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {{ $product->description }}
                <br />
                Available quantity: {{ $product->quantity }}
            </p>

            @if ($product->active)
                <x-button class="mt-3"> Buy</x-button>
            @else
                <x-button class="mt-3" disabled> Buy</x-button>
            @endif
        </div>
    </form>
    @endforeach
</div>


@if (Session::has('message'))

<script>
    toastr.success("{{ Session::get('message') }}")
</script>

@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
