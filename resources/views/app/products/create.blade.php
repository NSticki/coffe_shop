@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('products.index') }}"><i
                                class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-content">
                    <ul class="nav nav-tabs" id="settings" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-main" data-toggle="tab" href="#main"
                               role="tab" aria-controls="home" aria-selected="true">Основное</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-data" data-toggle="tab" href="#data" role="tab"
                               aria-controls="profile" aria-selected="false">Данные</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-data" data-toggle="tab" href="#options" role="tab"
                               aria-controls="profile" aria-selected="false">Опции</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-data" data-toggle="tab" href="#images" role="tab"
                               aria-controls="profile" aria-selected="false">Изображения</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="main" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="product_name"
                                               class="col-form-label text-md-right col-md-2">Название</label>
                                        <div class="col-md-5">
                                            <input type="text" id="product_name" name="product_name"
                                                   placeholder="Название"
                                                   class="form-control @error('product_name') is-invalid @enderror">
                                            @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="product_description" class="col-form-label text-md-right col-md-2">Описание</label>
                                        <div class="col-md-5">
                                                <textarea rows="5" type="text" id="product_description"
                                                          name="product_description"
                                                          placeholder="Описание"
                                                          class="form-control @error('product_description') is-invalid @enderror"></textarea>
                                            @error('product_description')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="product_is_disabled" class="col-form-label text-md-right col-md-2">Включён в стоп-лист</label>
                                        <div class="col-md-5 d-flex flex-column justify-content-center">
                                            <input name="is_disabled" type="checkbox" value="1" id="product_is_disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="data" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="category_id" class="col-form-label text-md-right col-md-2">Родительская
                                            категория</label>
                                        <div class="col-md-5">
                                            <select class="custom-select" name="category_id" id="category_id">
                                                <option value="0">Не выбрано</option>
                                                @foreach($data['categories'] as $category)
                                                    <option
                                                        value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="price" class="col-form-label text-md-right col-md-2">Цена</label>
                                        <div class="col-md-5">
                                            <input type="text" id="price" name="price"
                                                   placeholder="Цена"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="0">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="weight" class="col-form-label text-md-right col-md-2">Вес</label>
                                        <div class="col-md-5">
                                            <input type="text" id="weight" name="weight"
                                                   placeholder="Вес"
                                                   class="form-control @error('weight') is-invalid @enderror"
                                                   value="0">
                                            @error('weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fatAmount"
                                               class="col-form-label text-md-right col-md-2">Жиры</label>
                                        <div class="col-md-5">
                                            <input type="text" id="fatAmount" name="fatAmount"
                                                   placeholder="Жиры"
                                                   class="form-control @error('fatAmount') is-invalid @enderror"
                                                   value="0">
                                            @error('fatAmount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="proteinsAmount"
                                               class="col-form-label text-md-right col-md-2">Белки</label>
                                        <div class="col-md-5">
                                            <input type="text" id="proteinsAmount" name="proteinsAmount"
                                                   placeholder="Белки"
                                                   class="form-control @error('proteinsAmount') is-invalid @enderror"
                                                   value="0">
                                            @error('proteinsAmount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="carbohydratesAmount" class="col-form-label text-md-right col-md-2">Углеводы</label>
                                        <div class="col-md-5">
                                            <input type="text" id="carbohydratesAmount" name="carbohydratesAmount"
                                                   placeholder="Углеводы"
                                                   class="form-control @error('carbohydratesAmount') is-invalid @enderror"
                                                   value="0">
                                            @error('carbohydratesAmount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="energyAmount" class="col-form-label text-md-right col-md-2">Энергитическая
                                            ценность</label>
                                        <div class="col-md-5">
                                            <input type="text" id="energyAmount" name="energyAmount"
                                                   placeholder="Энергитическая ценность"
                                                   class="form-control @error('energyAmount') is-invalid @enderror"
                                                   value="0">
                                            @error('energyAmount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sort_order" class="col-form-label text-md-right col-md-2">Порядок
                                            сортировки</label>
                                        <div class="col-md-5">
                                            <input type="text" id="sort_order" name="sort_order"
                                                   placeholder="Сортировка"
                                                   class="form-control @error('sort_order') is-invalid @enderror"
                                                   value="100">
                                            @error('sort_order')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-form-label text-md-right col-md-2">Магазины</label>
                                        <div class="col-md-5">
                                            @foreach($data['stores'] as $store)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="stores_id[]" type="checkbox"
                                                           value="{{ $store['id'] }}" id="store_{{ $store['id'] }}">
                                                    <label class="form-check-label"
                                                           for="store_{{ $store['id'] }}">{{ $store->store_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="options" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="offset-2 col-8">
                                            <div class="options-wrapper">
                                                @foreach($data['option_categories'] as $category)
                                                    <button class="btn btn-dark option-btn" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#item-{{$category['id']}}"
                                                            aria-expanded="false" aria-controls="collapseExample">
                                                        {{ $category['name'] }}
                                                    </button>
                                                    <div class="collapse" id="item-{{$category['id']}}">
                                                        @foreach($category['options'] as $option)
                                                            @if ($option['is_disabled'])
                                                            <div class="form-group pl-4 greyed-out" title="Включён в стоп-лист">
                                                            @else
                                                            <div class="form-group pl-4">
                                                            @endif
                                                                <input type="checkbox" class="form-check-input"
                                                                       name="options[]"
                                                                       value="{{ $option['id'] }}"
                                                                       id="{{ $option['guid'] }}">
                                                                <label class="form-check-label"
                                                                       for="{{ $option['guid'] }}">{{ $option['name'] }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="images" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label
                                            class="col-form-label text-md-right col-md-2">Изображения</label>
                                        <div class="col-md-5">
                                            <input type="file" class="custom-file-input" id="product_images"
                                                   name="product_images">
                                            <label class="custom-file-label" for="product_images">Выберите
                                                изображения</label>
                                            @error('product_images')
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
        </form>
    </div>

@endsection
