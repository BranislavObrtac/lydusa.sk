<div class="container-fluid" style="height: 25px;background: #26272b">
    <div class="container d-flex">
        <div class="navbar-reklamy" style="display: inline-block; color: white;margin: auto"> Nájdete nás aj na
            <a href="https://www.modrykonik.sk/market/seller/elalili/reviews/"><b style="color: gray">modrom koníku</b></a>
            alebo
            <a href="https://www.facebook.com/groups/159362401449568"><b style="color: gray">facebooku</b></a>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">
            <div><img src="{{ Voyager::image(setting('site.logo')) }}" style="height: 50px"></div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto pl-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome')}}" class="pl-4"><b>DOMOV</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.index')}}" class="pl-4"><b>OBLEČENIE</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/vyhladavanie?q=&idx=products&p=0&dFR%5Bgenders%5D%5B0%5D=Chlapec&dFR%5Bgenders%5D%5B1%5D=Dievča" class="pl-4"><b>ROZŠÍRENÉ HĽADANIE</b></a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto d-flex">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}"><b>KOŠÍK</b>
                        @if (Cart::instance('default')->count() > 0)
                            <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                        @endif
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><b style="text-transform: uppercase">Prihlásenie</b></a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><b style="text-transform: uppercase">Registrácia</b></a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <b style="text-transform: uppercase">{{ Auth::user()->user_first_name }} {{ Auth::user()->user_second_name }}</b>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.edit') }}">Môj účet</a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Odhlásiť') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

