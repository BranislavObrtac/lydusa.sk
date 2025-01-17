<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('my-profile')->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'secondName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
            'password' => ['sometimes','nullable', 'string', 'min:6', 'confirmed'],
            'user_city' =>  ['required', 'string', 'max:255'],
            'user_zip_code' =>  ['required', 'string', 'max:255'],
            'user_street' =>  ['required', 'string', 'max:255'],
            'user_country' =>  ['required', 'string', 'max:255'],
            'user_phone' =>  ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user();
        $input = $request->except('password','password_confirmation');

        if(! $request->filled('password')){
            $user->fill($input)->save();

            return back()->with('success_message', 'Profil bol úspešne zmenený !');
        }

        $user->password = bcrypt($request->password);
        $user->fill($input)->save();

        return back()->with('success_message', 'Profil bol úspešne zmenený !');


        //dd($request->all());
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
}
