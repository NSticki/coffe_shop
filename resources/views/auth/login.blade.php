@extends('layouts.auth')

@section('content')
    <div class="auth-wrapper">
        <div class="logo text-center">
            <img src="{{ asset('images/assets/logo.svg') }}" alt="">
        </div>
        <div class="auth-form">
{{--            @if( session()->has('message'))--}}
{{--                <div class="alert alert-danger">--}}
{{--                    <span>{{ session()->get('message') }}</span>--}}
{{--                </div>--}}
{{--            @endif--}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-box">
                    <label for="email">Введите логин</label>

                    <div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-box">
                    <label for="password">Введите пароль</label>

                    <div>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-box">
{{--                    <div class="form-check">--}}
{{--                        <input class="form-check-input" type="checkbox" name="remember"--}}
{{--                               id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                        <label class="form-check-label" for="remember">--}}
{{--                            Запомнить меня--}}
{{--                        </label>--}}
{{--                    </div>--}}
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a class="btn restore-password" href="{{ route('password.request') }}">
                                Забыли пароль?
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-box">
                    <div class="text-center">
                        <button type="submit" class="btn auth-btn">Войти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

