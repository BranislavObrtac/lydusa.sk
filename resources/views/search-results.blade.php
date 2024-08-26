
@extends('layouts.app')

@section('title', 'Výsledky hľadania')

@section('extra-css')

    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Hľadať</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="search-results-container container">
        <h1>Výsledky hľadania:</h1>
        <p class="search-results-count">{{ $products->total() }} výsledkov pre '{{ request()->input('query') }}'</p>

        @if ($products->total() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Obrázok</th>
                    <th>Meno</th>
                    <th>Veľkosť</th>
                    <th>Farba</th>
                    <th>Popis</th>
                    <th>Cena</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th><a href=" {{ route('shop.show', $product->slug) }} "><img src="{{ productImage($product->product_image) }}" alt="item" class="cart-table-img" style="height: 50px"></a></th>
                        <th><a href="{{ route('shop.show', $product->slug) }}">{{ $product->product_name }}</a></th>
                        <td>{{ $product->product_size }}</td>
                        <td>{{ $product->product_color }}</td>
                        <td>{!! \Illuminate\Support\Str::limit($product->product_details, 80) !!}</td>
                        <td>{{ your_money_format($product->product_price) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $products->appends(request()->input())->links() }}
        @endif
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
