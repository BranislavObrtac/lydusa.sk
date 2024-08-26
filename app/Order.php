<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'user_id','billing_email','billing_first_name','billing_second_name','billing_address',
        'billing_city','billing_province','billing_postalcode','billing_phone','delivery_optn',
        'delivery_price','payment_optn','payment_price','cart_weight','billing_name_on_card',
        'billing_discount','billing_discount_code','billing_subtotal','billing_subtotal_no_dis','billing_tax','billing_total',
        'payment_gateway','error'
    ];

    public function products(){
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }
}
