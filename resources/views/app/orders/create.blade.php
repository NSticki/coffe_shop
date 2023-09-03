@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('orders.index') }}"><i
                                class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <ul class="nav nav-tabs" id="settings" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-main" data-toggle="tab" href="#client"
                               role="tab" aria-controls="home" aria-selected="true">Клиент</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-main" data-toggle="tab" href="#order"
                               role="tab" aria-controls="home" aria-selected="true">Заказ</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="client" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="firstname"
                                               class="col-form-label text-md-right col-md-2">Имя</label>
                                        <div class="col-md-5">
                                            <input type="text" id="firstname" name="firstname"
                                                   placeholder="Имя"
                                                   class="form-control @error('firstname') is-invalid @enderror">
                                            @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="lastname"
                                               class="col-form-label text-md-right col-md-2">Фамилия</label>
                                        <div class="col-md-5">
                                            <input type="text" id="lastname" name="lastname"
                                                   placeholder="Фамилия"
                                                   class="form-control @error('lastname') is-invalid @enderror">
                                            @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telephone"
                                               class="col-form-label text-md-right col-md-2">Телефон</label>
                                        <div class="col-md-5">
                                            <input type="text" id="telephone" name="telephone"
                                                   placeholder="Телефон"
                                                   class="form-control @error('telephone') is-invalid @enderror">
                                            @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="order" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
