@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form class="form" action="{{ route('categories.update',$data['category']['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['category']['name'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('categories.index') }}"><i class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="name" class="col-form-label text-md-right col-md-2">Категория</label>
                                <div class="col-md-5">
                                    <input type="text" id="name" name="name" placeholder="Название"
                                           value="{{ $data['category']['name'] }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parent_id" class="col-form-label text-md-right col-md-2">Родительская
                                    категория</label>
                                <div class="col-md-5">
                                    <select class="custom-select" name="parent_id" id="parent_id">
                                        <option value="">Не выбранно</option>

                                        @foreach($data['categories'] as $parent)
                                            @if ($data['category']['parent_id'] == $parent['guid'])
                                                <option value="{{ $parent['id'] }}" selected>{{ $parent['name'] }}</option>
                                            @else
                                                <option value="{{ $parent['id'] }}">{{ $parent['name'] }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sort_order" class="col-form-label text-md-right col-md-2">Порядок сортировки</label>
                                <div class="col-md-5">
                                    <input type="text" id="sort_order" name="sort_order" placeholder="Сортировка"
                                           class="form-control @error('sort_order') is-invalid @enderror" value="{{ $data['category']['sort_order'] }}">
                                    @error('sort_order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="is_disabled" class="col-form-label text-md-right col-md-2">Включена в стоп-лист</label>
                                <div class="col-md-5 d-flex flex-column justify-content-center">
                                    <input name="is_disabled" type="checkbox" value="1" id="is_disabled" {{$data['category']['is_disabled'] ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
