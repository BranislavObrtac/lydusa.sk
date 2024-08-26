@extends('layouts.app')

@section('title', 'Oblečenie')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Oblečenie</span>
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


    <div class="products-section container">
        <div class="sidebar">
            <h3>Kategórie:</h3>
                <ul>
                    @foreach($categories as $category)
                        <li class="{{ setActiveCategory($category -> category_slug) }}">
                            <a href="{{ route('shop.index',['category' => $category -> category_slug]) }}">{{ $category->category }}</a>
                        </li>
                    @endforeach
                </ul>
        </div>
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div>
                   <strong>Zoradiť podľa ceny: </strong>&emsp;
                    <a href="{{ route('shop.index',['category' => request()->category, 'sort' => 'low_high']) }}"> vzostupne |</a>
                    <a href="{{ route('shop.index',['category' => request()->category, 'sort' => 'high_low']) }}"> zostupne </a>
                </div>
            </div>
        <div class="products text-center">
            @forelse($products as $product)
                <div class="product">
                    <a href="{{ route('shop.show', $product->slug) }}" >
                        <img src="{{ productImage($product->product_image) }}" alt="product" style="max-height: 150px">
                    </a>
                    <a href="{{ route('shop.show', $product->slug) }}" ><div class="product-name">{{ $product->product_name }}</div></a>
                    <div class="product-price">{{ your_money_format($product->product_price) }} </div>
                    <div>{!! getStockLevel($product->product_quantity) !!}  </div>

                </div>
            @empty
                <div style="text-align: left">Momentálne nie su žiadne produkty v tejto kategórii.</div>
            @endforelse
        </div>

            <div class="spacer"></div>
            {{--{{ $products->links() }}--}}
            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>




@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
