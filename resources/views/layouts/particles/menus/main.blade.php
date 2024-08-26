<!-- Left Side Of Navbar -->

<ul class="navbar-nav mr-auto pl-4">
    @foreach($items as $menu_item)
            <li class="nav-item">
                <a class="nav-link" href="{{ $menu_item->link() }}">
                    <b>{{ $menu_item->title }}</b>
                </a>
            </li>
    @endforeach
</ul>

<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-auto d-flex">
    <!-- Authentication Links -->
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><b>Prihlásenie</b></a>
        </li>
        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}"><b>Registrácia</b></a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <b>{{ Auth::user()->user_first_name }} {{ Auth::user()->user_second_name }}</b>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('create') }}">Môj účet</a>

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

{{-- <ul class="navbar-nav mr-auto pl-4">
    <li class="nav-item">
        <a class="nav-link" href="#" class="pl-8"><b>CHLAPCI</b></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" class="pl-4"><b>DIEVČATÁ</b></a>
    </li>
</ul>--}}
