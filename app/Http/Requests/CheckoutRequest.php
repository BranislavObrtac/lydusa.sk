<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users';

        return [
            'email' => $emailValidation,
            'name' => 'required',
            'secondName' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postalcode' => 'required',
            'phone' => 'required',
        ];

    }
    public function messages()
    {
        return [
            'email.unique' => 'Už máte účet s týmto e-mailom. Prosím  <a href="/login">prihláste sa.</a>',
            'email.required'=> 'Prosím vyplnte pole s názvom "Email"',
            'name.required'=> 'Prosím vyplnte pole s názvom "Meno"',
            'secondName.required'=> 'Prosím vyplnte pole s názvom "Priezvisko"',
            'address.required'=> 'Prosím vyplnte pole s názvom "Ulica"',
            'city.required'=> 'Prosím vyplnte pole s názvom "Mesto"',
            'province.required'=> 'Prosím vyplnte pole s názvom "Krajina"',
            'postalcode.required'=> 'Prosím vyplnte pole s názvom "PSČ"',
            'phone.required'=> 'Prosím vyplnte pole s názvom "Telefónne číslo"',
        ];
    }
}
