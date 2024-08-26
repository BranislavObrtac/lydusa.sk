@extends('layouts.app')

@section('title', 'Profil')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Profil</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    <div class="products-section container">
        <div class="sidebar">
            <ul>
                <li class="active-profile">
                    <a href="{{ route('users.edit') }}">Profil</a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}">Objednávky</a>
                </li>
                <li>
                    <a href="{{ route('obchodPodmienky') }}">Zákaznícke centrum</a>
                </li>
            </ul>
        </div>
        {{--koniec sidebaru--}}
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">Profil</h1>

            </div>
            <div>
                <form method="POST" action="{{ route('users.update') }}">
                    @method('patch')
                    {{ csrf_field() }}
                    <div class="half-form">
                        <input id="name" type="text" class="form-control" name="name" value="{{ auth()->user()->user_first_name }}" placeholder="Meno" required autofocus>

                        <input id="secondName" type="text" class="form-control" name="secondName" value="{{ auth()->user()->user_second_name }}" placeholder="Priezvisko" required autofocus>
                    </div>
                    <div>
                        <input id="email" type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" placeholder="Email" required>
                    </div>
                    <div class="half-form">
                        <input id="user_city" type="text" class="form-control" name="user_city" value="{{ auth()->user()->user_city }}" placeholder="Mesto" autocomplete="user_city" required>

                        <input id="user_zip_code" type="text" class="form-control" name="user_zip_code" value="{{ auth()->user()->user_zip_code }}" placeholder="PSČ" autocomplete="user_zip_code" required>
                    </div>
                    <div>
                        <input id="user_street" type="text" class="form-control" name="user_street" value="{{ auth()->user()->user_street }}" placeholder="Adresa" autocomplete="user_street" required>
                    </div>
                    <div class="half-form">
                        <input id="user_country" type="text" class="form-control" name="user_country" value="{{ auth()->user()->user_country }}" placeholder="Krajina" autocomplete="user_country" required>

                        <input id="user_phone" type="text" class="form-control" name="user_phone" value="{{ auth()->user()->user_phone }}" placeholder="Telefónne číslo" autocomplete="user_phone" required>
                    </div>
                    *Ak chcete ponechať staré heslo, položky (Heslo, Zopakovať heslo) nevypĺňajte.
                    <div class="half-form">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Heslo">

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Zopakovať heslo" >
                    </div>
                    <div>
                            <button type="submit" class="my-profile-button">UPRAVIŤ PROFIL</button>
                    </div>
                </form>
            </div>

            <div class="spacer"></div>
        </div>
    </div>




@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
