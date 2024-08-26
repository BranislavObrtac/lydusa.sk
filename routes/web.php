<?php

use Barryvdh\DomPDF\Facade as PDF;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/any-route', function () {
    Artisan::call('storage:link');
});

Route::get('/','WelcomeController@index')->name('welcome');

Route::get('/produkty', 'ShopController@index')->name('shop.index');
Route::get('/produkty/{product}', 'ShopController@show')->name('shop.show');

Route::get('/kosik', 'CartController@index')->name('cart.index');
Route::post('/kosik', 'CartController@store')->name('cart.store');

Route::get('/kosik/ajax/opt', 'CartController@DPO')->name('cart.DPO');

Route::patch('/kosik/{product}', 'CartController@update')->name('cart.update');
Route::delete('/kosik/{product}', 'CartController@destroy')->name('cart.destroy');

Route::get('empty',function(){
    Cart::destroy();
});

Route::get('/objednavka', 'CheckoutController@index')->name('checkout.index');
Route::post('/objednavka', 'CheckoutController@store')->name('checkout.store');
Route::post('/paypal-objednavka', 'CheckoutController@paypalCheckout')->name('checkout.paypal');


Route::get('/mp/create', 'myProfileController@create')->name('create');
Route::post('/mp', 'myProfileController@store');


Route::middleware('auth')->group(function () {
    Route::get('/profil', 'UsersController@edit')->name('users.edit');
    Route::patch('/profil', 'UsersController@update')->name('users.update');

    Route::get('/objednavky', 'OrdersController@index')->name('orders.index');
    Route::get('/objednavky/{order}', 'OrdersController@show')->name('orders.show');
});

Route::get('/dakujeme-za-nakup', 'ConfirmationController@index')->name('confirmation.index');
Route::post('/kupon', 'CuponsController@store')->name('cupon.store');
Route::delete('/kupon', 'CuponsController@destroy')->name('cupon.destroy');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/faktura-pdf-bs3-download', function () {
    // return view('invoice-pdf');
    $pdf = PDF::loadView('faktura-pdf-bs3-download')->setPaper('a4');
    return $pdf->download('faktura.pdf');
});
Route::get('/hladat','ShopController@search')->name('search');

Route::get('/vyhladavanie','ShopController@searchAlgolia')->name('search-algolia');

Route::get('/obchodne-podmienky-lydusa',function (){
    return view('footer.obchodPodmienky');
})->name('obchodPodmienky');

Route::get('/formulare-na-stiahnutie-lydusa',function (){
    return view('footer.sposobDopravy');
})->name('sposobDopravy');

Route::get('/reklamacny-poriadok-lydusa',function (){
    return view('footer.vratenieTovaru');
})->name('vratenieTovaru');

Route::get('/kupony-lydusa',function (){
    return view('footer.kupony');
})->name('kupony');

Route::get('/moznosti-dopravy-a-platby-lydusa',function (){
    return view('footer.cenik-platby');
})->name('cenik-platby');


Route::get('/mail',function (){
    $order = App\Order::find(225);
    return new App\Mail\OrderPlaced($order);
});

Route::get('/cookies-lydusa',function (){
    return view('footer.cookies');
})->name('cookies');

Route::get('/zasady-spracovania-osobnych-udajov',function (){
    return view('footer.spracovanieOU');
})->name('spracovanieOU');

Route::get('/reklamacny-formular', function () {
    return response()->download(public_path('formulare/reklamacnyFormular.docx'));
})->name('reklamacny-formular');

Route::get('/formular-na-odstupenie-od-zmluvy-pre-spotrebitela', function () {
    return response()->download(public_path('formulare/formular_OOZ.docx'));
})->name('formular-ooz');

Route::get('/google45e6a3e2c957c4e8.html', function () {
    return view('google');
});


