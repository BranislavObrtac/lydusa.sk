@extends('layouts.app')

@section('title', $product->product_name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')


    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{ route('shop.index') }}">Oblečenie</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->product_name }}</span>
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

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ productImage($product->product_image) }}" alt="product" class="active" id="currentImage">
            </div>

            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ productImage($product->product_image) }}" alt="product">
                </div>
                @if($product->product_images != null)
                    @foreach (json_decode($product->product_images, true) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{ productImage($image) }}" alt="product">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        <div class="product-section-information">
            <h1 class="product-section-title"><b>{{ $product->product_name }}</b></h1>
            <hr>
            {{--where('category',$product -> categories--}}
            <div class="product-section-subtitle">Kategória: {{ $product->categories->pluck('category')->implode(' ') }}</div>
            <div class="product-section-subtitle">Pre: {{ $product->genders->pluck('name')->implode(' ') }}</div>
            <div class="product-section-subtitle">Veľkosť: {{ $product-> product_size }}</div>
            <div class="product-section-subtitle">Hmotnosť:: {{ $product->product_weight_grams }} g</div>
            <hr>
            <div>Dostupnosť: {!! $stockLevel !!}  </div>
            <hr>
            <div class="product-section-price">Cena: {{ your_money_format($product->product_price) }}</div>
            <div class="product-section-subtitle-price">vrátane DPH</div>
            <hr>

            @if (($product -> product_quantity) > 0)
                <form action="{{ route('cart.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                    <input type="hidden" name="product_price" value="{{ $product->product_price }}">
                    <input type="hidden" name="product_weight_grams" value="{{ $product->product_weight_grams }}">
                    <button type="submit" class="button button-plain">VLOŽIŤ DO KOŠÍKA</button>
                </form>
            @endif

            <div class="product-section-price" style="margin-top: 30px;">Popis:</div>
            <p>{!! $product->product_details !!}</p>
        </div>
    </div>


    @include('layouts.particles.might-like')


@endsection

@section('extra-js')
    <script>
        (function(){
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                currentImage.classList.remove('active');
                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })
                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }
        })();
    </script>
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
