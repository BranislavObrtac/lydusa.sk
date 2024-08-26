<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class CartController extends Controller
{

    public function empty()
    {
       Cart::destroy();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();

        return view('cart')-> with([
            'mightAlsoLike' => $mightAlsoLike,
            'discount' => getNumbers()->get('discount'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
            'deliveryCost' => getNumbers()->get('deliveryCost'),
            'paymentCost' => getNumbers()->get('paymentCost'),
            'priceWithoutDph'  => getNumbers()->get('priceWithoutDph'),
        ]);
    }
    public function DPO(Request $request)
    {
        $data = $request->data;
        if($data == "naPostu" || $data == "naAdresu"){
            session()->put('sposobDopravy',$request->data);
        }
        if($data == "online" || $data == "dobierka"){
            session()->put('sposobPlatby',$request->data);
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
     * @param Request $request
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session()->put('Testt ',$request->data);

        if($request->data == "naPostu"){
            session()->put('Test ',$request->data);
        }

        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Tento predukt sa už nachádza vo vašom košíku.');
        }

        Cart::add($request->id, $request->product_name, 1, $request->product_price,$request->product_weight_grams)
            ->associate('App\Product');
            return redirect()->route('cart.index')->with('success_message','Produkt bol vložený do košíka.');
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
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails()){
            session()->flash('errors',collect(['Počet kusov musí byť medzi 1-5']));
            return response()->json(['success' => false],400);
        }

        if ($request->quantity > $request->productQuantity){
            session()->flash('errors',collect(['Nedostatočný počet kusov na sklade.']));
            return response()->json(['success' => false],400);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message','Košík bol úspešne aktualizovaný!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);

        return back()->with('success_message', 'Produkt bol odstránený z košíka');

    }
}
