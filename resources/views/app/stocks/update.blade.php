@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form class="form" action="{{ route('stocks.update',$data['stock']['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['stock']->title }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('stocks.index') }}"><i class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <div class="row mt-3">
                        <div class="col-12">

                            <div class="form-group row">
                                <label for="title" class="col-form-label text-md-right col-md-2">Название</label>
                                <div class="col-md-5">
                                    <input type="text" id="title" name="title" placeholder="Название" value="{{ $data['stock']->title }}"
                                           class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="info-content" class="col-form-label text-md-right col-md-2">Описание</label>
                                <div class="col-md-10">
                                                <textarea rows="5" type="text" id="info-content"
                                                          name="content"
                                                          placeholder="Описание"
                                                          class="summernote form-control @error('content') is-invalid @enderror">{{ $data['stock']->content }}</textarea>
                                    @error('content')
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
