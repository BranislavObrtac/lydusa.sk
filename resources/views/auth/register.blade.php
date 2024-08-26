@extends('layouts.app')

@section('title', 'Registrácia')

@section('content')
    <div class="container">
        <div class="auth-pages">
            <div>
                @if (session()->has('success_message'))
                    <div class="alert alert-success">
                        {{ session()->get('success_message') }}
                    </div>
                @endif @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h2>REGISTRÁCIA</h2>
                <div class="spacer"></div>

                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="half-form">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Meno" required autofocus>

                        <input id="secondName" type="text" class="form-control" name="secondName" value="{{ old('secondName') }}" placeholder="Priezvisko" required autofocus>
                    </div>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

                    <div class="half-form">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Heslo" required>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Zopakovať heslo" required>
                    </div>

                    <div class="half-form">
                        <input id="user_city" type="text" class="form-control" name="user_city" value="{{ old('user_city') }}" placeholder="Mesto" autocomplete="user_city" required>

                        <input id="user_zip_code" type="text" class="form-control" name="user_zip_code" value="{{ old('user_zip_code') }}" placeholder="PSČ" autocomplete="user_zip_code" required>
                    </div>

                    <input id="user_street" type="text" class="form-control" name="user_street" value="{{ old('user_street') }}" placeholder="Adresa" autocomplete="user_street" required>

                    <div class="half-form">
                        <input id="user_country" type="text" class="form-control" name="user_country" value="{{ old('user_country') }}" placeholder="Krajina" autocomplete="user_country" required>

                        <input id="user_phone" type="text" class="form-control" name="user_phone" value="{{ old('user_phone') }}" placeholder="Telefónne číslo" autocomplete="user_phone" required>
                    </div>
                    <div class="login-container">
                        <div class="already-have-container">
                            <button type="submit" class="auth-button">REGISTROVAŤ</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="auth-right">
                <h2>Nový zákazník</h2>
                <div class="spacer"></div>
                <p><strong>Skráťte si čas.</strong></p>
                <p>Vytvorenie účtu Vám v budúcnosti zrýchli platenie a budete mať možnosť pristupovať k histórii vašich objednávok. </p>
                <div class="spacer"></div>
                <div style="
                            display: flex;
                            justify-content: center;
                            align-items: center;">
                    <img src="{{asset('storage/registerLogo.png')}}" style="height: 200px">
                </div>
                <div>
                    <p style="margin-top: 50px;"><strong>Máte už účet ?</strong></p>
                    <a href="{{ route('login') }}" class="auth-button-hollow"style="

                            display: flex;
                            justify-content: center;
                            align-items: center;">
                        PRIHLÁSIŤ SA</a>
                </div>
            </div>
        </div>
    </div>
@endsection


{{--
<div class="container" style="padding-top: 4%;padding-bottom: 8%">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrácia') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Meno') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('Meno') }}"  autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="secondName" class="col-md-4 col-form-label text-md-right">{{ __('Priezvisko') }}</label>

                            <div class="col-md-6">
                                <input id="secondName" type="text" class="form-control @error('secondName') is-invalid @enderror" name="secondName" value="{{ old('secondName') }}"  autocomplete="secondName">

                                @error('secondName')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Heslo') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Opakujte heslo') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_city" class="col-md-4 col-form-label text-md-right">{{ __('Mesto') }}</label>

                            <div class="col-md-6">
                                <input id="user_city" type="text" class="form-control @error('user_city') is-invalid @enderror" name="user_city" autocomplete="user_city">

                                @error('user_city')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_zip_code" class="col-md-4 col-form-label text-md-right">{{ __('PSČ') }}</label>

                            <div class="col-md-6">
                                <input id="user_zip_code" type="text" class="form-control @error('user_zip_code') is-invalid @enderror" name="user_zip_code" autocomplete="user_zip_code">

                                @error('user_zip_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_street" class="col-md-4 col-form-label text-md-right">{{ __('Ulica') }}</label>

                            <div class="col-md-6">
                                <input id="user_street" type="text" class="form-control @error('user_street') is-invalid @enderror" name="user_street" autocomplete="user_street">

                                @error('user_street')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_country" class="col-md-4 col-form-label text-md-right">{{ __('Krajina') }}</label>

                            <div class="col-md-6">
                                <input id="user_country" type="text" class="form-control @error('user_country') is-invalid @enderror" name="user_country" autocomplete="user_country">

                                @error('user_country')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_phone" class="col-md-4 col-form-label text-md-right">{{ __('Tel. číslo') }}</label>

                            <div class="col-md-6">
                                <input id="user_phone" type="text" class="form-control @error('user_phone') is-invalid @enderror" name="user_phone" value="{{ old('user_phone') }}"  autocomplete="user_phone">

                                @error('user_phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrovať') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
