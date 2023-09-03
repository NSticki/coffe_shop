<header>

    <div class="head-menu">
        <ul class="nav navbar-nav navbar-expand">
            <li><a class="flex-c tr-3" href="#"><div><img src="{{ asset('images/assets/User-icon.svg') }}" alt=""> {{ Auth::user()->name }} </div></a></li>
            <li><a class="flex-c tr-3" href="{{ url('/logout') }}"><div><img src="{{ asset('images/assets/Exit-icon.svg') }}" alt="">Выход</div></a></li>
        </ul>
    </div>

</header>
