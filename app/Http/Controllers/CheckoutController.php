<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\ProceedToPayment;
use App\Mail\OrderPlaced;
use App\Mail\OrderPlacedFakturaLydusa;
use App\Order;
use App\OrderProduct;
use App\Product;
use Braintree\Gateway;
use Cartalyst\Stripe\Api\Checkout;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use function React\Promise\all;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        try {
            $paypalToken = $gateway->ClientToken()->generate();
        } catch (\Exception $e) {
            $paypalToken = null;
        }
    if(Session::has('sposobPlatby') && Session::has('sposobDopravy')){
        if(Cart::total()==0){
            abort(404);
        } else {
            return view('checkout')->with([
                'paypalToken' => $paypalToken,
                'discount' => getNumbers()->get('discount'),
                'newSubtotal' => getNumbers()->get('newSubtotal'),
                'newTax' => getNumbers()->get('newTax'),
                'newTotal' => getNumbers()->get('newTotal'),
                'deliveryCost' => getNumbers()->get('deliveryCost'),
                'paymentCost' => getNumbers()->get('paymentCost'),
                'priceWithoutDph'  => getNumbers()->get('priceWithoutDph'),

            ]);
        }
    } else {
        return back()->withErrors('Prosím zvoľte možnosť: "Spôsob dopravy" a "Možnosti platby".');
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CheckoutRequest $request)
    {
        //Kontrola či dakto nevykúpil tovar sekundu predomnov
        if($this->productsAreNoLongerAvailable()){
            return back()->withErrors('Oops! Jeden z produktov vo vašom košíku už nie je dostupný.');
        }

        $contents = Cart::content()->map(function ($item) {
            return $item->model->slug.', '.$item->qty;
        })->values()->toJson();

        if (Session::has('sposobPlatby')){
            if (Session::get('sposobPlatby') == "dobierka"){

                try {
                    //Vlozit do orded table

                    $order = $this ->addToOrdersTablesDobierka($request, null);

                    //emaily
                    Mail::send(new OrderPlaced($order));
                    Mail::send(new OrderPlacedFakturaLydusa($order));

                    // Mail::to($request->email)->send (new OrderPlaced);

                    //Vlozit do pivet->order produkt table

                    //znizit pocet ks po objednani produktu
                    $this->decreaseQuantities();

                    //Uspesna platba
                    Cart::instance('default')->destroy();
                    session()->forget('cupon');

                    return redirect()->route('confirmation.index')->with('success_message', 'Ďakujeme za nákup. Platba bola akceptovaná.');

                } catch (CardErrorException $e) {
                    //Ak je chyba
                    $this ->addToOrdersTables($request, $e->getMessage());
                    return back()->withErrors('Chyba ! ' . $e->getMessage());
                }

            }
        }

        if (Session::has('sposobPlatby')){
            if (Session::get('sposobPlatby') == "online"){

                try {
                    $charge = Stripe::charges()->create([
                        'amount' => getNumbers()->get('newTotal'), //kolko si učtujeme
                        'currency' => 'EUR',
                        'source' => $request->stripeToken, // token z front endu
                        'description' => 'Order',
                        'receipt_email' => $request->email,
                        'metadata' => [
                            'contents' => $contents,
                            'quantity' => Cart::instance('default')->count(),
                            'discount' => collect(session()->get('cupon'))->toJson()
                        ],
                    ]);

                    //Vlozit do orded table

                    $order = $this ->addToOrdersTables($request, null);

                    //emaily
                    Mail::send(new OrderPlaced($order));

                    //Vlozit do pivet->order produkt table

                    //znizit pocet ks po objednani produktu
                    $this->decreaseQuantities();

                    //Uspesna platba
                    Cart::instance('default')->destroy();
                    session()->forget('cupon');

                    return redirect()->route('confirmation.index')->with('success_message', 'Ďakujeme za nákup. Platba bola akceptovaná.');

                } catch (CardErrorException $e) {
                    //Ak je chyba
                    $this ->addToOrdersTables($request, $e->getMessage());
                    return back()->withErrors('Chyba ! ' . $e->getMessage());
                }
            }
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paypalCheckout(CheckoutRequest $request)
    {
        // Check race condition when there are less items available to purchase
        if ($this->productsAreNoLongerAvailable()) {
            return back()->withErrors('Oops! Jeden z produktov vo vašom košíku už nie je dostupný.');
        }
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $nonce = $request->payment_method_nonce;

        $result = $gateway->transaction()->sale([
            'amount' => getNumbers()->get('newTotal'), //kolko si učtujeme
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        $transaction = $result->transaction;
        //dd($result);

        if ($result->success) {
            $order = $this->addToOrdersTablesPaypal(
                $request,
                null
            );

            Mail::send(new OrderPlaced($order));

            // decrease the quantities of all the products in the cart
            $this->decreaseQuantities();

            Cart::instance('default')->destroy();
            session()->forget('cupon');

            return redirect()->route('confirmation.index')->with('success_message', 'Ďakujeme za nákup, platba bola akceptovaná !');
        } else {
            $order = $this->addToOrdersTablesPaypal(
                $request,
                null
            );

            return back()->withErrors('Chyba: '.$result->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function addToOrdersTables($request, $error){
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request -> email,
            'billing_first_name' => $request -> name,
            'billing_second_name' => $request -> secondName,
            'billing_address' => $request -> address,
            'billing_city' => $request -> city,
            'billing_province' => $request -> province,
            'billing_postalcode' => $request -> postalcode,
            'billing_phone' => $request -> phone,
            'delivery_optn' => getOptnsDeliveryPayment()->get('sposobDopravy'),
            'delivery_price' => (number_format(getNumbers()->get('deliveryCost'), 2).'€'),
            'payment_optn' => getOptnsDeliveryPayment()->get('sposobPlatby'),
            'payment_price' => (number_format(getNumbers()->get('paymentCost'), 2).'€'),
            'cart_weight' => getNumbers()->get('cartWeight').' g',
            'billing_name_on_card' => $request -> name_on_card,
            'billing_discount' =>(number_format(getNumbers()->get('discount'), 2).'€'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => (number_format(getNumbers()->get('newSubtotal'), 2).'€'),
            'billing_subtotal_no_dis' => (number_format(getNumbers()->get('priceWithoutDph'), 2).'€'),
            'billing_tax' => (number_format(getNumbers()->get('newTax'), 2).'€'),
            'billing_total' => (number_format(getNumbers()->get('newTotal'), 2).'€'),
            'error' => $error,
        ]);
        foreach (Cart::content() as $item){
            OrderProduct::create([
                'order_id' => $order ->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }
        return $order;
    }

    protected function addToOrdersTablesDobierka($request, $error){
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request -> email,
            'billing_first_name' => $request -> name,
            'billing_second_name' => $request -> secondName,
            'billing_address' => $request -> address,
            'billing_city' => $request -> city,
            'billing_province' => $request -> province,
            'billing_postalcode' => $request -> postalcode,
            'billing_phone' => $request -> phone,
            'delivery_optn' => getOptnsDeliveryPayment()->get('sposobDopravy'),
            'delivery_price' => (number_format(getNumbers()->get('deliveryCost'), 2).'€'),
            'payment_optn' => getOptnsDeliveryPayment()->get('sposobPlatby'),
            'payment_price' => (number_format(getNumbers()->get('paymentCost'), 2).'€'),
            'cart_weight' => getNumbers()->get('cartWeight').' g',
            'billing_name_on_card' => $request -> name_on_card,
            'billing_discount' =>(number_format(getNumbers()->get('discount'), 2).'€'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => (number_format(getNumbers()->get('newSubtotal'), 2).'€'),
            'billing_subtotal_no_dis' => (number_format(getNumbers()->get('priceWithoutDph'), 2).'€'),
            'billing_tax' => (number_format(getNumbers()->get('newTax'), 2).'€'),
            'billing_total' => (number_format(getNumbers()->get('newTotal'), 2).'€'),
            'payment_gateway' => 'Dobierka',
            'error' => $error,
        ]);
        foreach (Cart::content() as $item){
            OrderProduct::create([
                'order_id' => $order ->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }
        return $order;
    }

    /*protected function addToOrdersTablesPaypal($request,$error)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request -> email,
            'billing_first_name' => $request -> name,
            'billing_second_name' => $request -> secondName,
            'billing_address' => $request -> address,
            'billing_city' => $request -> city,
            'billing_province' => $request -> province,
            'billing_postalcode' => $request -> postalcode,
            'billing_phone' => $request -> phone,
            'delivery_optn' => getOptnsDeliveryPayment()->get('sposobDopravy'),
            'delivery_price' => (number_format(getNumbers()->get('deliveryCost'), 2).'€'),
            'payment_optn' => getOptnsDeliveryPayment()->get('sposobPlatby'),
            'payment_price' => (number_format(getNumbers()->get('paymentCost'), 2).'€'),
            'cart_weight' => getNumbers()->get('cartWeight').' g',
            'billing_discount' =>(number_format(getNumbers()->get('discount'), 2).'€'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => (number_format(getNumbers()->get('newSubtotal'), 2).'€'),
            'billing_tax' => (number_format(getNumbers()->get('newTax'), 2).'€'),
            'billing_total' => (number_format(getNumbers()->get('newTotal'), 2).'€'),
            'error' => $error,
            'payment_gateway' => 'paypal',
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }

        return $order;
    }*/

    protected function decreaseQuantities()
        {
            foreach (Cart::content() as $item){
                $product = Product::find($item->model->id);

                $product -> update([
                    'product_quantity' => $product -> product_quantity - $item->qty
                ]);
            }
        }

    protected function productsAreNoLongerAvailable(){
            foreach (Cart::content() as $item) {
                $product = Product::find($item->model->id);

                if($product->product_quantity < $item->qty){
                    return true;
                }
            }
            return false;
        }


}
