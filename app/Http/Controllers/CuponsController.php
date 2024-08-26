<?php

namespace App\Http\Controllers;

use App\Cupon;
use App\Jobs\UpdateCupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CuponsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cupon = Cupon::where('code',$request->cupon_code)->first();

        if (! $cupon) {
            return back()->withErrors('Zlý kupón, prosím skúste ešte raz.');
        }

        dispatch_now(new UpdateCupon($cupon));


        return back()->with('success_message','Kupón bol použitý.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('cupon');

        return back()->with('success_message','Kupón bol odstránený.');

    }
}
