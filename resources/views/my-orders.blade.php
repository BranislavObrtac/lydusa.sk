@extends('layouts.app')

@section('title', 'Objednávky')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Objednávky</span>
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


    <div class="products-section my-orders container">
        <div class="sidebar">
            <ul>
                <li>
                    <a href="{{ route('users.edit') }}">Profil</a>
                </li>
                <li class="active-profile">
                    <a href="{{ route('orders.index') }}">Objednávky</a>
                </li>
                <li>
                    <a href="{{ route('obchodPodmienky') }}">Zákaznícke centrum</a>
                </li>
            </ul>
        </div>
        {{--koniec sidebaru--}}
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">Objednávky</h1>
            </div>
            <div>
                @foreach ($orders as $order)
                    <div class="order-container">
                        <div class="order-header">
                            <div class="order-header-items">
                                <div>
                                    <div class="uppercase font-bold">Objednávka vytvorená: </div>
                                    <div>{{ presentDate($order->created_at) }}</div>
                                </div>
                                <div>
                                    <div class="uppercase font-bold">ID objednávky: </div>

                                    <div>{{ numberOfInvoice($order->created_at,$order->id) }}</div>
                                </div>
                                <div>
                                    <div class="uppercase font-bold">Celková suma: </div>
                                    <div>{{ $order->billing_total }}</div>
                                </div>
                                <div>
                                    <div class="uppercase font-bold">Zľava: </div>
                                    <div>{{ $order->billing_discount }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="order-header-items">
                                    <div><a href="{{ route('orders.show',$order->id) }}">Detaily objednávky </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="order-products">
                            @foreach ($order->products as $product)
                                <div class="order-product-item">
                                    <div><img src="{{ productImage($product->product_image) }}" alt="Obrázok produktu"></div>
                                    <div>
                                        <div>
                                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->product_name }}</a>
                                        </div>
                                        <div>Cena s DPH: {{ your_money_format_dph($product->product_price) }}</div>
                                        {{--<div class="produkt-dph">DPH: {{ your_money_format_iba_dph($product->product_price) }}</div>--}}
                                        <div>Počet: {{ $product->pivot->quantity }}</div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                        </div>
                    </div> <!-- end order-container -->
                @endforeach
            </div>
            <div class="spacer"></div>

            {{ $orders->appends(request()->input())->links() }}


        </div>
    </div>




@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
