<div class="might-like-section " style="padding-bottom: 5%;padding-top: 4%; margin-bottom: -25px">
    <div class="container">
        <h4 style="text-transform: uppercase; text-align: center; margin-bottom: 25px"><b>Mohlo by sa vám tiež páčiť:</b></h4>
        <div class="row text-center">
            @foreach ($mightAlsoLike as $product)
                <div class="col-lg-3 col-6 col-sm-6" style="margin-bottom: 30px;">
                    <div class="welcomePageImageWindow" style=" border: 1px solid #979797">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img class="welcomePageImages" src="{{ productImage($product->product_image) }}" alt="product">
                            <hr>
                            <div><b>{{ $product->product_name }}</b></div>
                            <div>{{ your_money_format($product->product_price) }} </div>
                        </a>
                    </div>
                </div>
                <div class="spacer"></div>
            @endforeach
        </div>
    </div>
</div>
