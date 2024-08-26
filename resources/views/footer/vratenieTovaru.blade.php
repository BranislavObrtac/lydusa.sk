@extends('layouts.app')

@section('title', 'Reklamačný poriadok lydusa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Reklamačný poriadok</span>
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
                <li class="active-profile">
                    <a href="{{ route('vratenieTovaru') }}">Reklamačný poriadok</a>
                </li>
                <li>
                    <a href="{{ route('kupony') }}">Kupóny</a>
                </li>
                <li>
                    <a href="{{ route('cenik-platby') }}">Možnosti dopravy a platby</a>
                </li>
                <li>
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
                <h1 class="stylish-heading">Reklamačný poriadok</h1>
            </div>

            <div>
                <p class="text-justify">{!! setting('zakaznicke-centrum.vratenieTovaru') !!}</p>

            </div>

            <div class="spacer"></div>
        </div>





    @endsection

    @section('extra-js')
        <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
            <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
            <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
            <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
