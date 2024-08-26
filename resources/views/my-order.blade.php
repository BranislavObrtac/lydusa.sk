@extends('layouts.app')

@section('title', 'Objednávka')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{ route('orders.index') }}">Objednávky</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Objednávka</span>
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
            </ul>
        </div>
        {{--koniec sidebaru--}}

        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">ID objednávky: {{ numberOfInvoice($order->created_at,$order->id) }}</h1>
            </div>

            <div>
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
                            </div><div>
                                <div class="uppercase font-bold">Celková suma: </div>
                                <div>{{ $order->billing_total }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="order-products">
                        <table class="table" style="width:50%">
                            <tbody>
                            <tr>
                                <td>Meno:</td>
                                <td>{{ $order->user->user_first_name }} {{ $order->user->user_second_name }}</td>
                            </tr>
                            <tr>
                                <td>Adresa:</td>
                                <td>{{ $order->billing_address }}, {{ $order->billing_postalcode }} {{ $order->billing_city }}, {{ $order->billing_province }}</td>
                            </tr>
                            <tr>
                                <td>Tel. číslo:</td>
                                <td>{{ $order->billing_phone }}</td>
                            </tr>
                            <tr>
                                <td>Hmotnosť objednávky:</td>
                                <td>{{ $order->cart_weight }}</td>
                            </tr>
                            <tr>
                                <td>Suma bez DPH:</td>
                                <td>{{ $order->billing_subtotal_no_dis }}</td>
                            </tr>
                            @if ($order->billing_discount_code != null)
                                <tr>
                                    <td>Zľavový kupón:</td>
                                    <td>{{ $order->billing_discount_code }}</td>
                                </tr>
                                <tr>
                                    <td>Zľava:</td>
                                    <td>-{{ $order->billing_discount }}</td>
                                </tr>
                                <tr>
                                    <td>Nová suma bez DPH:</td>
                                    <td>{{ $order->billing_subtotal }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>DPH:</td>
                                <td>{{ $order->billing_tax }}</td>
                            </tr>
                            <tr>
                                <td>Spôsob dopravy (cena):</td>
                                <td>{{ $order->delivery_optn }} (+{{ $order->delivery_price }})</td>
                            </tr>
                            <tr>
                                <td>Spôsob platby (cena):</td>
                                <td>{{ $order->	payment_optn }} (+{{ $order->payment_price }})</td>
                            </tr>
                            <tr>
                                <td>Celková suma:</td>
                                <td>{{ $order->billing_total }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end order-container -->

                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                Objednávka:
                            </div>
                        </div>
                    </div>
                    <div class="order-products">
                        @foreach ($products as $product)
                            <div class="order-product-item">
                                <div><img src="{{ productImage($product->product_image) }}" alt="Product Image"></div>
                                <div>
                                    <div>
                                        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                    </div>
                                    <div>Názov prouktu:<b>{{ $product->product_name }}</b> </div>
                                    <div>Cena s DPH: <b>{{ your_money_format($product->product_price) }}</b> / ks</div>
                                    <div>Cena bez DPH: <b>{{ round(vypocetCenyBezDphzCenySDph($product->product_price),2) }}€</b> / ks</div>
                                    <div>DPH: <b>{{ your_money_format_iba_dph(vypocetCenyBezDphzCenySDph($product->product_price)) }}</b> / ks</div>
                                    <div>Počet objednaných kusov: <b>{{ $product->pivot->quantity }}</b></div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div> <!-- end order-container -->
            </div>

            <div class="spacer"></div>
        </div>
    </div>




@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
