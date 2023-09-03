@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('stores.update', $data['store']['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('stores.index') }}"><i class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <div class="row mt-3">
                        <div class="col-12">

                            <div class="form-group row">
                                <label for="store_name" class="col-form-label text-md-right col-md-2">Название</label>
                                <div class="col-md-5">
                                    <input type="text" id="store_name" name="store_name" placeholder="Название" value="{{ $data['store']['store_name'] }}"
                                           class="form-control @error('store_name') is-invalid @enderror">
                                    @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="store_address" class="col-form-label text-md-right col-md-2">Адрес</label>
                                <div class="col-md-5">
                                    <input type="text" id="store_address" name="store_address" placeholder="Адрес" value="{{ $data['store']['store_address'] }}"
                                           class="form-control @error('store_address') is-invalid @enderror">
                                    @error('store_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="store_phone" class="col-form-label text-md-right col-md-2">Телефон</label>
                                <div class="col-md-5">
                                    <input type="text" id="store_phone" name="store_phone" placeholder="Телефон" value="{{ $data['store']['store_phone'] }}"
                                           class="form-control @error('store_phone') is-invalid @enderror">
                                    @error('store_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="time_form" class="col-form-label text-md-right col-md-2">Время работы</label>
                                <div class="col-md-2">
                                    <input type="text" id="time_from" name="time_from" placeholder="С" value="{{ $data['store']['time_from'] }}"
                                           class="datepicker form-control @error('store_phone') is-invalid @enderror">
                                    @error('time_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="time_to" name="time_to" placeholder="До" value="{{ $data['store']['time_to'] }}"
                                           class="datepicker form-control @error('store_phone') is-invalid @enderror">
                                    @error('time_to')
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
        </form>
    </div>
@endsection
