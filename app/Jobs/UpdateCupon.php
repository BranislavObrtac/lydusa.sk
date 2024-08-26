<?php

namespace App\Jobs;

use App\Cupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCupon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cupon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cupon $cupon)
    {
        $this->cupon = $cupon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        session()->put('cupon',[
            'name'=> $this -> cupon -> code,
            'discount' => $this -> cupon-> discount(vypocetCenyBezDphzCenySDph(Cart::subtotal())),
        ]);
    }
}
