@extends('layouts.app')

@section('title', 'Možnosti dopravy a platby')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="{{ route('welcome') }}">Domov</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Možnosti dopravy a platby</span>
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
                    <a href="{{ route('sposobDopravy') }}">Spôsob dopravy</a>
                </li>
                <li>
                    <a href="{{ route('vratenieTovaru') }}">Vrátenie tovaru</a>
                </li>
                <li>
                    <a href="{{ route('kupony') }}">Kupóny</a>
                </li>
                <li>
                    <a href="{{ route('cenik-platby') }}">Možnosti dopravy a platby</a>
                </li>

            </ul>
        </div>
    {{--koniec sidebaru--}}

        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">Ceník poštovného</h1>
            </div>

            <div>
                <p class="text-justify">{!! setting('zakaznicke-centrum.cennikPostovneho') !!}</p>

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
