@extends('layouts.app')

@section('title', 'Ďakujeme za nákup')

@section('extra-css')

@endsection

@section('body-class', 'sticky-footer')

@section('content')

    <div class="thank-you-section" style="padding-top: 10%; padding-bottom: 10%">
        <h1>Ďakujeme za <br> Vašu objednávku !</h1>
        <p>Potvrdzujúci email bol odoslaný</p>
        <div class="spacer"></div>
        <div>
            <a href="{{ url('/') }}" class="button">Domov</a>
        </div>
    </div>




@endsection
