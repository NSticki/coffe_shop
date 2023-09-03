@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <form class="form" action="/" method="POST">
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['customer']['name'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('customers.index') }}"><i class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <div class="row mt-3">
                        <div class="col-12">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name" class="col-form-label text-md-right col-md-2">Имя</label>
                                <div class="col-md-5">
                                    <input type="text" id="name" name="name" placeholder="Имя" value="{{ $data['customer']['name'] }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telephone" class="col-form-label text-md-right col-md-2">Телефон</label>
                                <div class="col-md-5">
                                    <input type="text" id="telephone" name="telephone" placeholder="Телефон" value="{{ $data['customer']['phone'] }}"
                                           class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
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
