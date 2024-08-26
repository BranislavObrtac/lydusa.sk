<?php

namespace App\Mail;

use App\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array(
            'id' => $this->order->id,
            'email' => $this->order->billing_email,
            'first_name' => $this->order->billing_first_name,
            'second_name' => $this->order->billing_second_name,
            'address' => $this->order->billing_address,
            'city' => $this->order->billing_city,
            'province' => $this->order->billing_province,
            'postalcode' => $this->order->billing_postalcode,
            'phone' => $this->order->billing_phone,
            'delivery_optn' => $this->order->delivery_optn,
            'delivery_price' => $this->order->delivery_price,
            'payment_optn' => $this->order->payment_optn,
            'payment_price' => $this->order->payment_price,
            'cart_weight' => $this->order->cart_weight,
            'name_on_card' => $this->order->billing_name_on_card,
            'discount' => $this->order->billing_discount,
            'discount_code' => $this->order->billing_discount_code,
            'subtotal' => $this->order->billing_subtotal,
            'subtotal_pred_zlavou' => $this->order->billing_subtotal_no_dis,
            'tax' => $this->order->billing_tax,
            'total' => $this->order->billing_total,
            'payment_gateway' => $this->order->payment_gateway,
            'products' => $this->order->products,
            'created_at' => $this->order->created_at,
        );


        $pdf = PDF::loadView('faktura-pdf-bs3-download',$data)->setPaper('a4');

        if($this->order->payment_optn == "Dobierka"){
            return $this->to($this->order->billing_email,$this->order->billing_second_name)
                    ->subject('Objenávka_'.numberOfInvoice($this->order->created_at,$this->order->id))
                    ->view('emails.orders.placed');
        } else {
            return $this->to($this->order->billing_email,$this->order->billing_second_name)
                ->subject('Objenávka_'.numberOfInvoice($this->order->created_at,$this->order->id))
                ->bcc('objednavky@lydusa.sk')
                ->view('emails.orders.placed')
                ->attachData($pdf->output(),'faktura_'.numberOfInvoice($this->order->created_at,$this->order->id).'.pdf');
        }
    }
}
