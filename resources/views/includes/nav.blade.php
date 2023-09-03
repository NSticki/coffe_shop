


<nav id="left-bar">
    <div class="logo">
        <div class="img">
            <img src="{{ asset('images/assets/logo.png') }}" alt="">
        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">Главная</a>
        </li>
        <li class="nav-item" >
            <a href="{{ url('catalog.index') }}" class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}" >Каталог товаров</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">Категории/Добавить</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link {{ Route::is('products.*') ? 'active' : '' }}">Товары/Добавить</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('options.index') }}" class="nav-link {{ Route::is('options.*') ? 'active' : '' }}">Опции/Добавить</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('info.index') }}" class="nav-link {{ Route::is('info.*') ? 'active' : '' }}">Информационные страницы</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('stocks.index') }}" class="nav-link {{ Route::is('stocks.*') ? 'active' : '' }}">Акции/Добавить</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link {{ Route::is('orders.*') ? 'active' : '' }}">Заказы</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link {{ Route::is('customers.*') ? 'active' : '' }}">Покупатели</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reviews.index') }}" class="nav-link {{ Route::is('reviews.*') ? 'active' : '' }}">Отзывы</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ Route::is('users.*') ? 'active' : '' }}">Пользователи/Добавить</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('settings') }}" class="nav-link {{ Route::is('settings') ? 'active' : '' }}">Настройки</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('stores.index') }}" class="nav-link {{ Route::is('stores.*') ? 'active' : '' }}">Магазины/Добавить</a>
        </li>
    </ul>
</nav>
