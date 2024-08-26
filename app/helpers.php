<?php


use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

function your_money_format($value) {
    return  number_format($value, 2).'€';
}
function your_money_format_dph($value) {
    return  number_format($value * 1.2, 2).'€';
}
function your_money_format_iba_dph($value) {
    return  number_format($value * 0.2, 2).'€';
}

function vypocetCenyBezDphzCenySDph($value){
    return (100/120)*$value;
}

function cart_weight($value) {
    return  number_format($value, 0).' g';
}

function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}

function presentDateInvoice($date)
{
    return Carbon::parse($date)->format('d.m.Y');
}

function numberOfInvoice($date,$id)
{
   $year = Carbon::parse($date)->format('Y');
    return (($year-2000)*100000) + $id;
}

function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}

function productImage($path)
{
    return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('storage/image-not-found.png');
}

function getNumbers() {

    $cartWeight = Cart::weight(0,'','');
    $deliveryCost = getDeliveryPrice($cartWeight);
    $paymentCost = getPaymentPrice();


    $tax = config('cart.tax')/100;
    $discount = session()->get('cupon')['discount'] ?? 0;
    $code = session()->get('cupon')['name'] ?? null;
    $priceWithoutDph = round(vypocetCenyBezDphzCenySDph(Cart::subtotal()),2);

    $newSubtotal = round((vypocetCenyBezDphzCenySDph(Cart::subtotal())) - $discount,2);
    if($newSubtotal < 0){
        $newSubtotal = 0;
    }
    $newTax = $newSubtotal * $tax;

    $newTotal = $newSubtotal + $newTax + $deliveryCost + $paymentCost;

    return collect([
        'tax' => $tax,
        'discount' => $discount,
        'code' => $code,
        'newSubtotal' => $newSubtotal,
        'newTax' => $newTax,
        'newTotal' => $newTotal,
        'deliveryCost' => $deliveryCost,
        'paymentCost' => $paymentCost,
        'cartWeight' => $cartWeight,
        'priceWithoutDph' => $priceWithoutDph,
    ]);

}

function getOptnsDeliveryPayment()
{

    if (Session::has('sposobDopravy') && Session::has('sposobPlatby')) {

        if (Session::get('sposobDopravy') == "naPostu") {
            $sposobDopravy = "Slovenská pošta: na poštu";
        } elseif (Session::get('sposobDopravy') == "naAdresu") {
            $sposobDopravy = "Slovenská pošta: na adresu";
        } else {
            $sposobDopravy = "NULL";
        }
        if (Session::get('sposobPlatby') == "online") {
            $sposobPlatby = "Online Kartou";
        } elseif (Session::get('sposobPlatby') == "dobierka") {
            $sposobPlatby = "Dobierka";
        } else {
            $sposobPlatby = "NULL";
        }
    } else {
        $sposobDopravy = "NULL";
        $sposobPlatby = "NULL";
    }
    return collect([
        'sposobDopravy' => $sposobDopravy,
        'sposobPlatby' => $sposobPlatby,
    ]);
}

function getStockLevel($quantity){
    if(($quantity) > (setting('site.skladLevel')))
    {
        $stockLevel = '<div class="badge badge-success">Skladom.</div>';

    }elseif(($quantity) <= (setting('site.skladLevel')) && ($quantity) > 0)
    {
        $stockLevel = '<div class="badge badge-warning">Skladom: '. $quantity. ' ks.</div>';
    } else {
        $stockLevel = '<div class="badge badge-danger">Vypredané!</div>';;
    }
    return $stockLevel;
}

function getDeliveryPrice($cartWeight){
    if (Session::has('sposobDopravy')){
        if (Session::get('sposobDopravy') == "naPostu"){
            if($cartWeight < 500){
                return setting('postovne.np_0_500');
            }
            if($cartWeight >= 500 && $cartWeight < 1000){
                return setting('postovne.np_501_1000');
            }
            if($cartWeight >= 1000 && $cartWeight < 2000){
                return setting('postovne.np_1001_2000');
            }
            if($cartWeight >= 2000 && $cartWeight < 5000){
                return setting('postovne.np_2001_5000');
            }
            if($cartWeight >= 5000 && $cartWeight < 10000){
               return setting('postovne.np_5001_10000');
            }
            if($cartWeight >= 10000){
                return setting('postovne.np_10000');
            }
        }
        if (Session::get('sposobDopravy') == "naAdresu"){
            if($cartWeight < 500){
                return setting('postovne.na_0_499');
            }
            if($cartWeight >= 500 && $cartWeight < 1000){
                return setting('postovne.na_500_999');
            }
            if($cartWeight >= 1000 && $cartWeight < 2000){
                return setting('postovne.na_1000_1999');
            }
            if($cartWeight >= 2000 && $cartWeight < 5000){
                return setting('postovne.na_2000_4999');
            }
            if($cartWeight >= 5000 && $cartWeight < 10000){
                return setting('postovne.na_5000_9999');
            }
            if($cartWeight >= 10000){
                return setting('postovne.na_10000');
            }
        }
    }
    return 0;
}

function getPaymentPrice(){
    if (Session::has('sposobPlatby')) {
        if (Session::get('sposobPlatby') == "dobierka"){
            return setting('postovne.dobierka');
        }
        if (Session::get('sposobPlatby') == "online"){
            return setting('postovne.online');
        }
    }
    return 0;
    }
