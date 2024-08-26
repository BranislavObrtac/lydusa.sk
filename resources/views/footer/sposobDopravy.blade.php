@extends('layouts.app')

@section('title', 'Formuláre lydusa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Formuláre</span>
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
                <li>
                    <a href="{{ route('obchodPodmienky') }}">Obchodné podmienky</a>
                </li>
                <li>
                    <a href="{{ route('spracovanieOU') }}">Spracovanie os. údajov</a>
                </li>
                <li>
                    <a href="{{ route('vratenieTovaru') }}">Reklamačný poriadok</a>
                </li>
                <li>
                    <a href="{{ route('kupony') }}">Kupóny</a>
                </li>
                <li>
                    <a href="{{ route('cenik-platby') }}">Možnosti dopravy a platby</a>
                </li>
                <li class="active-profile">
                    <a href="{{ route('sposobDopravy') }}">Formuláre</a>
                </li>
                <li>
                    <a href="{{ route('cookies') }}">Cookies</a>
                </li>

            </ul>
        </div>
    {{--koniec sidebaru--}}

        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">Formuláre</h1>
            </div>

            <div style="margin-bottom: 5%">
                <h2 style="margin-bottom: 5%; text-align: left" class="text-justify formulare-mobile">Reklamačný formulár</h2>
                <a href="{{ route('reklamacny-formular') }}" class="button">Stiahnúť</a>
            </div>
            <div>
                <h2 style="margin-bottom: 5%; text-align: left" class="text-justify formulare-mobile">Formulár pre odstúpenie od zmluvy pre spotrebiteľa</h2>
                <a href="{{ route('formular-ooz') }}" class="button">Stiahnúť</a>
            </div>
            <div class="spacer">
        </div>





    @endsection

    @section('extra-js')
        <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
            <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
            <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
            <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
