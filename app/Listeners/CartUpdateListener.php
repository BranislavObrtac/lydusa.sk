<?php

namespace App\Listeners;

use App\Cupon;
use App\Jobs\UpdateCupon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $cuponName = session()->get('cupon')['name'] ?? null;

        if($cuponName){
        $cupon = Cupon::where('code',$cuponName)->first();

        dispatch_now(new UpdateCupon($cupon));
        }
    }
}
