@extends('layouts.app')

@section('title', 'Prihlásenie')

@section('content')
    <div class="container">
        <div class="auth-pages">
            <div class="auth-left">
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
                <h2>PRIHLÁSENIE</h2>
                <div class="spacer"></div>

                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}

                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Heslo" required>

                    <div class="login-container">
                        <button type="submit" class="auth-button">PRIHLÁSIŤ</button>
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="height: 10px; margin-bottom: 5px;"> Zapametať údaje
                        </label>
                    </div>

                    <div class="spacer"></div>

                    <a href="{{ route('password.request') }}">
                        Zabudli ste heslo?
                    </a>

                </form>
            </div>

            <div class="auth-right">
                <h2>NOVÝ ZÁKAZNÍK</h2>
                <div class="spacer"></div>
                <p><strong>Skráťte si čas v budúcnosti.</strong></p>
                <p>Vytvorenie účtu Vám v budúcnosti zrýchli platenie a budete mať možnosť pristupovať k histórii vašich objednávok.</p>
                <div style="display: flex;
                            justify-content: center;
                            align-items: center;">
                    <img src="{{asset('storage/registerLogo.png')}}" style="height: 200px">
                </div>
                <div>
                    <a href="{{ route('register') }}" class="auth-button-hollow"style="

                            display: flex;
                            justify-content: center;
                            align-items: center;">
                        Vytvoriť si vlastný účet</a>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--
<div class="container" style="padding-bottom: 10%;padding-top: 8%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Prihlásenie') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input style="height: 55%; width: 5%" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Zapametať prihlasovacie údaje') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="button-primary full-width">
                                    {{ __('Prihlásiť') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Zabudnuté heslo ?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
