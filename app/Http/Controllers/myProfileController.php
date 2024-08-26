<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;

class myProfileController extends Controller
{
    public function create()
    {
        return view('myProfile.create');
    }

    public function store()
    {
        $data = request()->validate([
            'user_id' => '',
            'telNumber' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required'
        ]);

        auth()->user()->address()->create($data);
    }
}
