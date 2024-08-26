@extends('layouts.app')

@section('title', 'Zaplatiť')

@section('extra-css')
    <style>
        .mt-32 {
            margin-top: 32px;
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-container container">
            <div>
                <a href="{{ route('welcome') }}">Domov</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <a href="{{ route('cart.index') }}">Kosik</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span>Objednavka</span>
            </div>
        </div>
    </div>
    <div class="container">

        @if (session()->has('success_message'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="checkout-heading stylish-heading">PLATBA</h1>
        <div class="checkout-section">
            <div>
                <form action="{{ route('checkout.store') }}" method="POST" name="payment-form" id="payment-form">
                    {{ csrf_field() }}

                    <div style="display: inline"> Chcete <a href="#" style="text-decoration: underline;">výhody</a> pri nakupovaní ?
                        <a href="{{ route('login') }}" class="auth-button-hollow"style="
                            display: inline;
                            text-indent: 20px;
                            justify-content: center;
                            align-items: center;">
                            <b>PRIHLÁSTE SA.</b></a>
                    </div>
                    <div class="spacer"></div>

                    <h2><b>ÚDAJE PRE OBJEDNÁVKU</b></h2>

                    <div class="form-group">
                        <label for="email">Email</label>
                        @if (auth()->user())
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                        @else
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @endif
                    </div>
                    <div class="half-form">
                        <div class="form-group">
                            <label for="name">Meno</label>
                            @if (auth()->user())
                                <input type="name" class="form-control" id="name" name="name" value="{{ auth()->user()->user_first_name }}" required>
                            @else
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="secondName">Priezvisko</label>
                            @if (auth()->user())
                                <input type="text" class="form-control" id="secondName" name="secondName" value="{{ auth()->user()->user_second_name }}" required>
                            @else
                                <input type="text" class="form-control" id="secondName" name="secondName" value="{{ old('second_name') }}" required>
                            @endif
                        </div>
                    </div>
                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">Mesto</label>
                            @if (auth()->user())
                                <input type="text" class="form-control" id="city" name="city" value="{{ auth()->user()->user_city }}" required>
                            @else
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="address">Ulica, č. domu/bytu</label>
                            @if (auth()->user())
                                <input type="text" class="form-control" id="address" name="address" value="{{ auth()->user()->user_street }}" required>
                            @else
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                            @endif
                        </div>
                    </div>
                    <div class="half-form">
                        <div class="form-group">
                            <label for="province">Krajina</label>
                            @if (auth()->user())
                                <input type="text" class="form-control" id="province" name="province" value="{{ auth()->user()->user_country }}" required>
                            @else
                                <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}" required>
                            @endif
                        </div>
                            <div class="form-group">
                                <label for="postalcode">PSČ</label>
                                @if (auth()->user())
                                    <input type="text" class="form-control" id="postalcode" name="postalcode" value="{{ auth()->user()->user_zip_code }}" required>
                                @else
                                    <input type="text" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}" required>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefónne číslo</label>
                            @if (auth()->user())
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->user_phone }}" required>
                            @else
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @endif
                        </div>
                     <!-- end half-form -->
                    <div>
                        <input style="width: 15px; height: 15px" type="checkbox" value="checked" name="obchodPodmienky" id="obchodPodmienky" required>
                        <span id="obchodnePodmienky" style="font-size: 12pt; margin-top: 10px;">
                            Zaplatením objednávky zároveň súhlasíte s <a href="{{ route('obchodPodmienky') }}" style="text-decoration: underline">
                                obchodnými podmienkami a so spracovaním osobných údajov</a>.</span>
                    </div>

                    <div class="spacer"></div>

                    @if (Session::has('sposobPlatby'))
                        @if (Session::get('sposobPlatby') == "dobierka")
                            <h4>Spôsob platby: {{ Session::get('sposobPlatby') }}</h4>
                            <hr>
                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

                            <button type="submit" id="complete-order-dobierka" name="complete-order-dobierka" class="button-primary full-width">Dokončiť objednávku</button>

                            <script type="text/javascript">
                                $(window).on('beforeunload', function () {
                                    $("button[type=submit]").prop("disabled", "disabled");
                                });
                            </script>
                        @endif
                    @endif

                    @if (Session::has('sposobPlatby'))
                        @if (Session::get('sposobPlatby') == "online")
                            <h2>Spôsob platby:</h2>
                            <hr>
                            <button class="button-info" onclick="myFunctionPlatbaOnline()">PLATBA KARTOU ONLINE</button> {{--button hide element--}}

                            <div id="PlatbaOnline" style="display: none"> {{--div hide element--}}
                                <div class="spacer"></div>

                                <h2>ÚDAJE O KARTE</h2>

                                <div class="form-group">
                                    <label for="name_on_card">Meno na karte</label>
                                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="{{ old('name_on_card') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="card-element">
                                        Kreditná alebo debitná karta
                                    </label>
                                    <div id="card-element">
                                        <!-- a Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display form errors -->
                                    <div id="card-errors" role="alert"></div>
                                </div>

                                <div class="spacer"></div>
                                <button type="submit" id="complete-order" class="button-primary full-width">Dokončiť objednávku</button>
                                <hr>
                            </div> {{--end hide element--}}
                        @endif
                    @endif {{--ONLINE KARTOU--}}

                </form>
            </div>

            <div class="checkout-table-container">
                <h2><b>VAŠA OBJEDNÁVKA</b></h2>

                <div class="checkout-table">
                    @foreach (Cart::content() as $item)
                        <div class="checkout-table-row">
                            <div class="checkout-table-row-left">
                                <a href=" {{ route('shop.show', $item->model->slug) }} ">
                                <img src="{{ productImage($item->model->product_image) }}" alt="item" class="checkout-table-img">
                                </a>
                                    <div class="checkout-item-details">
                                        <a href=" {{ route('shop.show', $item->model->slug) }} ">
                                            <div class="checkout-table-item">{{$item->model->product_name}}</div>
                                        </a>
                                    <div class="checkout-table-description">
                                        Farba: {{ $item->model->product_color }} |
                                        Veľ: {{ $item->model->product_size }} |
                                        Hmotnosť: {{ $item->model->product_weight_grams }}g
                                    </div>
                                    <div class="checkout-table-price">{{ your_money_format($item->model->product_price) }}</div>
                                </div>
                            </div> <!-- end checkout-table -->

                            <div class="checkout-table-row-right">
                                <div class="checkout-table-quantity">{{ $item->qty }}</div>
                            </div>
                        </div> <!-- end checkout-table-row -->
                    @endforeach

                </div> <!-- end checkout-table -->

                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        Spolu bez DPH: <br>
                        @if (session()->has('cupon'))
                            Kupón: <b>{{ session()->get('cupon')['name'] }}</b>
                            <br>
                            <hr>
                            Spolu bez DPH:
                            <br>
                        @endif
                        DPH ({{config('cart.tax')}}%)<br>
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
                        <span class="checkout-totals-total">Celková suma:</span>
                    </div>

                    <div class="checkout-totals-right">
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
                        <span class="checkout-totals-total">{{ your_money_format($newTotal) }}</span>
                    </div>
                </div> <!-- end checkout-totals -->
            </div>
        </div> <!-- end checkout-section -->

    </div>




@endsection

@section('extra-js')
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>

    <script>

        (function(){
                // Create a Stripe client.
            var stripe = Stripe('{{ config('services.stripe.key') }}');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Disable the submit button to prevent repeated clicks
               // document.getElementById('complete-order').disabled = true;
                document.getElementById('complete-order').disabled = true;

                var options = {
                    name: document.getElementById('name_on_card').value,
                    address_line1: document.getElementById('address').value,
                    address_city: document.getElementById('city').value,
                    address_state: document.getElementById('province').value,
                    address_zip: document.getElementById('postalcode').value
                }

                stripe.createToken(card, options).then(function(result) {

                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;

                        // Enable the submit button
                        //document.getElementById('complete-order').disabled = false;
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
    })();
        function myFunctionPlatbaOnline() {
            var x = document.getElementById("PlatbaOnline");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

            // PayPal Stuff
            // Render the PayPal button into #paypal-button-container

           /* var form = document.querySelector('#paypal-payment-form');
            var client_token = "{{--{{ $paypalToken }}--}}";

            braintree.dropin.create({
                locale: 'sk_SK',
                authorization: client_token,
                selector: '#bt-dropin',
                paypal: {
                    flow: 'vault',
                    buttonStyle: {
                        color: 'blue',
                        shape: 'rect',
                        size: 'large',
                    },
                },
            },

                function (createErr, instance) {
                if (createErr) {
                    console.log('Create Error', createErr);
                    return;
                }
                // remove credit card option
                var elem = document.querySelector('.braintree-option__card');
                elem.parentNode.removeChild(elem);

                var elemen = document.querySelector('.braintree-placeholder');
                elemen.parentNode.removeChild(elemen);

                /!*
                var braintree_large_button = document.querySelector('.braintree-large-button');
                braintree_large_button.parentNode.removeChild(braintree_large_button);
                *!/

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    //document.getElementById('complete-order-paypal').disabled = true;

                    instance.requestPaymentMethod(function (err, payload) {
                        if (err) {
                            console.log('Request Payment Method Error', err);
                            return;
                        }
                        // Add the nonce to the form and submit
                        document.querySelector('#nonce').value = payload.nonce;

                        var val_email = document.getElementById("email").value;
                        var email = document.createElement('input');
                        email.setAttribute('type', 'hidden');
                        email.setAttribute('name', 'email');
                        email.setAttribute('value', val_email);
                        form.appendChild(email);

                        var val_name = document.getElementById("name").value;
                        var name = document.createElement('input');
                        name.setAttribute('type', 'hidden');
                        name.setAttribute('name', 'name');
                        name.setAttribute('value', val_name);
                        form.appendChild(name);

                        var val_secondName = document.getElementById("secondName").value;
                        var secondName = document.createElement('input');
                        secondName.setAttribute('type', 'hidden');
                        secondName.setAttribute('name', 'secondName');
                        secondName.setAttribute('value', val_secondName);
                        form.appendChild(secondName);

                        var val_city = document.getElementById("city").value;
                        var city = document.createElement('input');
                        city.setAttribute('type', 'hidden');
                        city.setAttribute('name', 'city');
                        city.setAttribute('value', val_city);
                        form.appendChild(city);

                        var val_address = document.getElementById("address").value;
                        var address = document.createElement('input');
                        address.setAttribute('type', 'hidden');
                        address.setAttribute('name', 'address');
                        address.setAttribute('value', val_address);
                        form.appendChild(address);

                        var val_province = document.getElementById("province").value;
                        var province = document.createElement('input');
                        province.setAttribute('type', 'hidden');
                        province.setAttribute('name', 'province');
                        province.setAttribute('value', val_province);

                        form.appendChild(province);

                        var val_postalcode = document.getElementById("postalcode").value;
                        var postalcode = document.createElement('input');
                        postalcode.setAttribute('type', 'hidden');
                        postalcode.setAttribute('name', 'postalcode');
                        postalcode.setAttribute('value', val_postalcode);
                        form.appendChild(postalcode);

                        var val_phone = document.getElementById("phone").value;
                        var phone = document.createElement('input');
                        phone.setAttribute('type', 'hidden');
                        phone.setAttribute('name', 'phone');
                        phone.setAttribute('value', val_phone);
                        form.appendChild(phone);

                        /!*var val_obchodPodmienky = document.getElementById("obchodPodmienky").value;
                        var obchodPodmienky = document.createElement('input');
                        obchodPodmienky.setAttribute('type', 'hidden');
                        obchodPodmienky.setAttribute('name', 'obchodPodmienky');
                        obchodPodmienky.setAttribute('value', val_obchodPodmienky);
                        form.appendChild(obchodPodmienky);*!/

                        var val_obchodPodmienky = document.getElementById("obchodPodmienky");

                        if (val_obchodPodmienky.checked === true){
                            form.submit();
                        } else {
                            /!*return document.getElementById("error").innerHTML =
                                "Na dokončenie objednávky musíte súhlasiť s obchodnými podmienkami a spracovaním osobných údajov.";*!/
                            return (document.getElementById("obchodnePodmienky").style.color = "red",
                                document.getElementById("error").innerHTML = "Na dokončenie objednávky musíte súhlasiť s obchodnými podmienkami a so spracovaním osobných údajov..");

                        }


            // function to disable and enable buttons, receives an array with button IDs
            // from https://coursesweb.net/javascript
            function disableEnableBtn(ids){
                // traverses the array with IDs
                var nrids = ids.length;
                for(var i=0; i<nrids; i++){
                    // registers onclick event to each button
                    if(document.getElementById('complete-order-paypal')) {
                        document.getElementById('complete-order-paypal').onclick = function() {
                            this.setAttribute('disabled', 'disabled'); // disables the button by adding the disabled attribute
                            this.innerHTML = 'Prosím čakajte'; // changes the button text
                            var idbtn = this.id; // stores the button ID

                            // calls a function after 2 sec. (2000 milliseconds)
                            setTimeout(()=>{
                                document.getElementById('complete-order-paypal').removeAttribute('disabled'); // removes the disabled attribute
                                document.getElementById('complete-order-paypal').innerHTML = 'Dokončiť objednávku'; // changes tne button text
                            }, 15000 );
                        }
                    }
                }
            }
            // array with IDs of buttons
            var btnid = ['btn1', 'btn2'];

            disableEnableBtn(btnid); // calls the function
        });
    });
    });
    })();
*/

/*    function myFunctionPaypal() {
    var x = document.getElementById("Paypal");
    if (x.style.display === "none") {
    x.style.display = "block";
    } else {
    x.style.display = "none";
    }
    }*/

    /*function myFunctionPlatbaDobierka() {
    }*/

</script>
@endsection
