@extends('layouts.app')

@section('title', 'Košík')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="{{ route('welcome') }}">Domov</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Košík</span>
@endcomponent

<div class="cart-section container">
    <div>
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

        @if (Cart::count() > 0)

        <h2>{{ Cart::count() }} produkty v košíku.</h2>

        <div class="cart-table">
            @foreach (Cart::content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href=" {{ route('shop.show', $item->model->slug) }} "><img src="{{ productImage($item->model->product_image) }}" alt="item" class="cart-table-img"></a>
                    <div class="cart-item-details">
                        <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{$item->model->product_name}}</a></div>
                        <div class="cart-table-description">
                            Veľ: {{ $item->model->product_size }}
                        </div>
                    </div>
                </div>
                <div class="cart-table-row-right">
                    <div class="cart-table-actions" style="margin-left: -10%">
                        <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="button button-plain button-mobile">Odstrániť</button>
                        </form>
                    </div>
                    <div>
                        <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->product_quantity }}">
                            @for ($i = 1; $i < 5 + 1 ; $i++) <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div>{{ your_money_format($item->subtotal) }}</div>

                </div>
            </div>
            @endforeach

        </div> <!-- end cart-table -->

        @if (! session()->has('cupon'))
        <a href="#" class="have-code">Máte kupón ?</a>

        <div class="have-code-container">
            <form action="{{ route('cupon.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="cupon_code" id="cupon_code">
                <button type="submit" class="button button-plain">Použiť</button>
            </form>
        </div> <!-- end have-code-container -->
        @endif

        <div class="cart-totals">

            <div class="cart-totals-options-left" style="width: 100%">
                <div>
                    <h4>Spôsob dopravy:</h4>
                    @if (Session::has('sposobDopravy'))
                    @if (Session::get('sposobDopravy') == "naPostu")
                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naPostu" value="naPostu" checked>
                        <label for="naPostu">Balík na poštu</label>
                    </p>
                    @else
                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naPostu" value="naPostu">
                        <label for="naPostu">Balík na poštu</label>
                    </p>
                    @endif

                    @if (Session::get('sposobDopravy') == "naAdresu")
                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naAdresu" value="naAdresu" checked>
                        <label for="naAdresu">Balík na adresu</label>
                    </p>
                    @else
                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naAdresu" value="naAdresu">
                        <label for="naAdresu">Balík na adresu</label>
                    </p>
                    @endif
                    @else
                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naPostu" value="naPostu">
                        <label for="naPostu">Balík na poštu</label>
                    </p>

                    <p class="mt-3">
                        <input type="radio" name="sposobDopravy" id="naAdresu" value="naAdresu">
                        <label for="naAdresu">Balík na adresu</label>
                    </p>
                    @endif

                </div>
            </div>

            <div class="cart-totals-options-right" style="width: 100%">
                <div>
                    <h4>Možnosti platby:</h4>
                    @if (Session::has('sposobPlatby'))
                    @if (Session::get('sposobPlatby') == "online")
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="online" value="online" checked>
                        <label for="online">Online - Kartou ({{ your_money_format(setting('postovne.online')) }})</label>
                    </p>
                    @else
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="online" value="online">
                        <label for="online">Online - Kartou ({{ your_money_format(setting('postovne.online')) }})</label>
                    </p>
                    @endif

                    @if (Session::get('sposobPlatby') == "dobierka")
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="dobierka" value="dobierka" checked>
                        <label for="dobierka">Dobierka ({{ your_money_format(setting('postovne.dobierka')) }})</label>
                    </p>
                    @else
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="dobierka" value="dobierka">
                        <label for="dobierka">Dobierka ({{ your_money_format(setting('postovne.dobierka')) }})</label>
                    </p>
                    @endif
                    @else
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="online" value="online">
                        <label for="online">Online - Kartou ({{ your_money_format(setting('postovne.online')) }})</label>
                    </p>
                    <p class="mt-3">
                        <input type="radio" name="moznostPlatby" id="dobierka" value="dobierka">
                        <label for="dobierka">Dobierka ({{ your_money_format(setting('postovne.dobierka')) }})</label>
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="cart-totals">
            <div class="cart-totals-left" style="width: 100%">
                <div class="spacer"></div>
                <div class="spacer"></div>
                <a href="{{ route('cenik-platby') }}">
                    <h4>Možnosti dopravy a platby</h4>
                </a>
            </div>

            <div class="cart-totals-right" style="width: 100%;text-align: left">
                <div>
                    Celková váha košíka: <br>
                    Celkovo bez DPH: <br>
                    @if (session()->has('cupon'))
                    Kupón: <b>{{ session()->get('cupon')['name'] }}</b> |
                    <form action="{{ route('cupon.destroy') }}" method="POST" style="display:inline">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="cupon-button-odstranit">Odstrániť</button>
                    </form>
                    <br>
                    <hr>
                    Spolu bez DPH:
                    <br>
                    @endif
                    DPH: <br>
                    Cena poštovného: (@if (Session::has('sposobDopravy'))
                    @if (Session::get('sposobDopravy') == "naPostu")
                    Na poštu
                    @endif
                    @if (Session::get('sposobDopravy') == "naAdresu")
                    Na adresu
                    @endif
                    @else
                    <h10 style="color: #ff0000">Nezvolené</h10>
                    @endif
                    ):<br>

                    Cena platby (@if (Session::has('sposobPlatby'))
                    @if (Session::get('sposobPlatby') == "online")
                    Online
                    @endif
                    @if (Session::get('sposobPlatby') == "dobierka")
                    Dobierka
                    @endif
                    @else
                    <h10 style="color: red">Nezvolené</h10>
                    @endif
                    ): <br>

                    <span class="cart-totals-total">Celková suma:</span>
                </div>
                <div class="cart-totals-subtotal" style="text-align: right">
                    {{ Cart::weight(0) }} g<br>

                    {{ your_money_format($priceWithoutDph) }} <br>
                    @if (session()->has('cupon'))
                    -{{ your_money_format($discount) }} <br>
                    <hr>
                    {{ your_money_format($newSubtotal) }} <br>
                    @endif
                    {{ your_money_format($newTax) }} <br>

                    @if (Session::has('sposobDopravy'))
                    {{ your_money_format($deliveryCost) }} <br>
                    @else
                    <br>
                    @endif
                    @if (Session::has('sposobPlatby'))
                    {{ your_money_format($paymentCost) }} <br>
                    @else
                    <br>
                    @endif

                    <span class="cart-totals-total">{{ your_money_format($newTotal) }} </span>
                </div>
            </div>
        </div> <!-- end cart-totals -->

        <div class="cart-buttons">
            <a href="{{ route('shop.index') }}" class="button">Pokračovať v nakupovaní</a>
            <a href="{{ route('checkout.index') }}" id="proceedToPaymentBtn" class="button-primary">Dokončenie objednávky</a>
            {{--{{ Session::flush() }}--}}

        </div>

        @else
        <h2>Žiadne produkty v košíku.</h2>
        <a href="{{ route('shop.index') }}" class="button button-plain">Pokračovať v nakupovaní.</a>
        @endif

    </div>

    {{--@if (Session::has('sposobDopravy'))
                <input id="sposobDopravyHI" value="{{ Session::get('sposobDopravy') }}" hidden>
    @endif
    @if (Session::has('sposobPlatby'))
    <input id="sposobPlatbyHI" value="{{ Session::get('sposobPlatby') }}" hidden>
    @endif--}}

</div> <!-- end cart-section -->

@include('layouts.particles.might-like')


@endsection





@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script> {{--importujem axios--}}

<script>
    (function() {

        const classname = document.querySelectorAll('.quantity')

        Array.from(classname).forEach(function(element) {
            element.addEventListener('change', function() {
                const id = element.getAttribute('data-id')
                const productQuantity = element.getAttribute('data-productQuantity')

                axios.patch(`/kosik/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity,
                    })
                    .then(function(response) {
                        //console.log(response);
                        window.location.href = "{{ route('cart.index') }}"
                    })
                    .catch(function(error) {
                        //console.log(error);
                        window.location.href = "{{ route('cart.index') }}"
                    });
            })
        })

        //Nastavujem do session sposobDopravy a moznostPlatby
        $('input[type=radio]').click(function() {

            if (this.id === "naPostu") {
                $.ajax({
                    url: "/kosik/ajax/opt",
                    type: "get",
                    data: {
                        data: "naPostu",
                    },
                    success: function() {
                        window.location.href = "{{ route('cart.index') }}"
                    }
                });
            }
            if (this.id === "naAdresu") {
                $.ajax({
                    url: "/kosik/ajax/opt",
                    type: "get",
                    data: {
                        data: "naAdresu",
                    },
                    success: function() {
                        window.location.href = '{{ route("cart.index") }}'
                    }
                });
            }
            if (this.id === "dobierka") {
                $.ajax({
                    url: "/kosik/ajax/opt",
                    type: "get",
                    data: {
                        data: "dobierka",
                    },
                    success: function() {
                        window.location.href = "{{ route('cart.index') }}"
                    }
                });
            }
            if (this.id === "online") {
                $.ajax({
                    url: "/kosik/ajax/opt",
                    type: "get",
                    data: {
                        data: "online",
                    },
                    success: function() {
                        window.location.href = "{{ route('cart.index') }}"
                    }
                });
            }
        });

        /*var sposobDopravy = document.getElementById("sposobDopravyHI").value;
        var sposobPlatby = document.getElementById("sposobPlatbyHI").value;

        if(sposobDopravy === "naPostu"){
            document.getElementById("naPostu").checked = true;
        }
        if(sposobDopravy === "naAdresu"){
            document.getElementById("naAdresu").checked = true;
        }
        if(sposobPlatby === "dobierka"){
            document.getElementById("dobierka").checked = true;
        }
        if(sposobPlatby === "online"){
            document.getElementById("online").checked = true;
        }*/
    })();
</script>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection