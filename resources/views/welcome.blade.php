@extends('layouts.app')

@section('title','Obchod s detským oblečením')

@section('content')

    <div class="jumbotron jumbotron-fluid" style="
        background-image:url('{{ Voyager::image(setting('jumbotron.Jumbotron_image')) }}');
        ">
    </div>


        <div class="container">
            <div class="mohlo-by-sa-pacit">
                <b>MOHLO BY SA VÁM PÁČIŤ</b>
            </div>
            <div class="row text-center">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-6 col-sm-6" style="margin-bottom: 30px;">
                            <div class="welcomePageImageWindow" style=" border: 1px solid #979797">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img class="welcomePageImages"  src="{{ productImage($product->product_image) }}" alt="product">
                                    <hr>
                                    <div><b>{{ $product->product_name }}</b></div>
                                    <div>{{ your_money_format($product->product_price) }} </div>
                                </a>
                            </div>
                        </div>
                        <div class="spacer"></div>
                    @endforeach
            </div>

            <div class="text-center button-container">
                <a href="{{ route('shop.index') }}" class="button"><b>VIAC TOVARU</b></a>
            </div>
        </div>


@endsection
