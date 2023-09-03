@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('users.store') }}" method="POST">
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <div class="row mt-3">
                        <div class="col-12">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-form-label text-md-right col-md-2">Имя</label>
                                <div class="col-md-5">
                                    <input type="text" id="name" name="name" placeholder="Имя"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-form-label text-md-right col-md-2">Фамилия</label>
                                <div class="col-md-5">
                                    <input type="text" id="lastname" name="lastname" placeholder="Фамилия"
                                           class="form-control @error('lastname') is-invalid @enderror">
                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telephone" class="col-form-label text-md-right col-md-2">Телефон</label>
                                <div class="col-md-5">
                                    <input type="text" id="telephone" name="telephone" placeholder="Телефон"
                                           class="form-control @error('telephone') is-invalid @enderror">
                                    @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-form-label text-md-right col-md-2">Email</label>
                                <div class="col-md-5">
                                    <input type="text" id="email" name="email" placeholder="Email"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-form-label text-md-right col-md-2">Пароль</label>
                                <div class="col-md-5">
                                    <input type="password" id="password" name="password" placeholder="Пароль"
                                           class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-form-label text-md-right col-md-2">Подтверждение пароля</label>
                                <div class="col-md-5">
                                    <input type="password" id="password-confirm" name="password-confirm" placeholder="Пароль"
                                           class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role_id" class="col-form-label text-md-right col-md-2">Роль</label>
                                <div class="col-md-5">
                                    <select class="custom-select" name="role_id" id="role_id">
                                        @foreach($data['user_roles'] as $role)
                                            <option
                                                value="{{ $role['id'] }}">{{ $role['role'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
