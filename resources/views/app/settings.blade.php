@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body card-content">
                            <ul class="nav nav-tabs" id="settings" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="settings-main" data-toggle="tab" href="#main"
                                       role="tab" aria-controls="home" aria-selected="true">Основное</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="settings-iiko" data-toggle="tab" href="#iiko" role="tab"
                                       aria-controls="profile" aria-selected="false">Iiko</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="settings-acquiring" data-toggle="tab" href="#acquiring"
                                       role="tab" aria-controls="contact" aria-selected="false">Эквайринг</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="main" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="d-flex flex-column mt-3">
                                        <div class="form-group row">
                                            <label for="shop_name"
                                                   class="col-form-label text-md-right col-md-2">Название</label>
                                            <div class="col-md-5">
                                                <input type="text" id="shop_name" name="shop_name" placeholder="Название"
                                                       value="{{ isset($data['settings']['shop_name']) ? $data['settings']['shop_name'] : '' }}"
                                                       class="form-control @error('shop_name') is-invalid @enderror">
                                                @error('shop_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="shop_email"
                                                   class="col-form-label text-md-right col-md-2">Email</label>
                                            <div class="col-md-5">
                                                <input type="email" id="shop_email" name="shop_email" placeholder="Email"
                                                       value="{{ isset($data['settings']['shop_email']) ? $data['settings']['shop_email'] : '' }}"
                                                       class="form-control @error('shop_email') is-invalid @enderror">
                                                @error('shop_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="iiko" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="d-flex flex-column mt-3">
                                        <div class="col-12 text-right">
                                            <a class="btn btn-primary" href="{{ route('iiko') }}">Выгрузить Каталог</a>
                                        </div>
                                        <div class="col-12 text-right">
                                            <a class="btn btn-primary" href="{{ route('iikoMenu') }}">Вывести Каталог</a>
                                        </div>

                                        <div class="form-group row">
                                            <label for="iiko_login"
                                                   class="col-form-label text-md-right col-md-2">Логин</label>
                                            <div class="col-md-5">
                                                <input type="text" id="iiko_login" name="iiko_login" placeholder="Логин"
                                                       value="{{ isset($data['settings']['iiko_login']) ? $data['settings']['iiko_login'] : '' }}"
                                                       class="form-control @error('iiko_login') is-invalid @enderror">
                                                @error('iiko_login')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="iiko_key"
                                                   class="col-form-label text-md-right col-md-2">Ключ API</label>
                                            <div class="col-md-5">
                                                <input type="text" id="iiko_key" name="iiko_key" placeholder="Ключ API"
                                                       value="{{ isset($data['settings']['iiko_key']) ? $data['settings']['iiko_key'] : '' }}"
                                                       class="form-control @error('iiko_pass') is-invalid @enderror">
                                                @error('iiko_key')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="acquiring" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="d-flex flex-column mt-3">
                                        <div class="form-group row">
                                            <label for="acquiring_login"
                                                   class="col-form-label text-md-right col-md-2">Логин</label>
                                            <div class="col-md-5">
                                                <input type="text" id="acquiring_login" name="acquiring_login" placeholder="Логин"
                                                       value="{{ isset($data['settings']['acquiring_login']) ? $data['settings']['acquiring_login'] : '' }}"
                                                       class="form-control @error('acquiring_login') is-invalid @enderror">
                                                @error('acquiring_login')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="acquiring_pass"
                                                   class="col-form-label text-md-right col-md-2">Пароль</label>
                                            <div class="col-md-5">
                                                <input type="text" id="acquiring_pass" name="acquiring_pass" placeholder="Пароль"
                                                       value="{{ isset($data['settings']['shop_email']) ? $data['settings']['acquiring_pass'] : '' }}"
                                                       class="form-control @error('acquiring_pass') is-invalid @enderror">
                                                @error('acquiring_pass')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
