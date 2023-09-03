@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('options.update', $data['option']['id']) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3">
                    <div class="heading-title">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('options.index') }}"><i
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
                               aria-controls="profile" aria-selected="false">Модификаторы</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="main" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12">


                                    <div class="form-group row">
                                        <label for="name" class="col-form-label text-md-right col-md-2">Опция</label>
                                        <div class="col-md-5">
                                            <input type="text" id="name" name="name" placeholder="Название"
                                                   value="{{ $data['option']['name'] }}"
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
                                                <option value="0">Не выбранно</option>

                                                @foreach($data['options'] as $parent)
                                                    <option value="{{ $parent['id'] }}">{{ $parent['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sort_order" class="col-form-label text-md-right col-md-2">Порядок
                                            сортировки</label>
                                        <div class="col-md-5">
                                            <input type="text" id="sort_order" name="sort_order"
                                                   placeholder="Сортировка"
                                                   class="form-control @error('sort_order') is-invalid @enderror"
                                                   value="{{ $data['option']['sort_order'] }}">
                                            @error('sort_order')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="min_amount" class="col-form-label text-md-right col-md-2">Минимальное
                                            кол-во</label>
                                        <div class="col-md-5">
                                            <input type="text" id="min_amount" name="min_amount"
                                                   placeholder="Сортировка"
                                                   class="form-control @error('min_amount') is-invalid @enderror"
                                                   value="{{ $data['option']['min_amount'] }}">
                                            @error('min_amount')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="max_amount" class="col-form-label text-md-right col-md-2">Максимальное
                                            кол-во</label>
                                        <div class="col-md-5">
                                            <input type="text" id="max_amount" name="max_amount"
                                                   placeholder="Сортировка"
                                                   class="form-control @error('max_amount') is-invalid @enderror"
                                                   value="{{ $data['option']['max_amount'] }}">
                                            @error('max_amount')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-md-2"
                                               for="required">Обязательность</label>

                                        <div class="col-md-5 d-flex flex-column justify-content-center">
                                            <input name="required" type="checkbox"
                                                   {{ $data['option']['required'] == 1 ? 'checked' : ''}}
                                                   value="1" id="required">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="is_disabled" class="col-form-label text-md-right col-md-2">Включена в стоп-лист</label>
                                        <div class="col-md-5 d-flex flex-column justify-content-center">
                                            <input name="is_disabled" type="checkbox" value="1" id="is_disabled" {{$data['option']['is_disabled'] ? 'checked' : ''}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="data" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="text-right mb-2">
                                        <button type="button" id="addOption" class="btn btn-primary"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Включён в стоп-лист</th>
                                            <th scope="col">Название</th>
                                            <th scope="col">Префикс
                                            </td>
                                            <th scope="col">Цена
                                            </td>
                                            <th scope="col">Вес
                                            </td>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="options-table">
                                        @foreach($data['modifiers'] as $key => $modifier)
                                            <tr id="item-{{$key}}">
                                                <input type="hidden" name="options[{{$key}}][guid]"
                                                       value="{{ $modifier['guid'] }}">
                                                <td><input class="form-control" type="checkbox" name="options[{{$key}}][is_disabled]" value="1" {{$modifier['is_disabled'] ? 'checked' : ''}}></td>
                                                <td><input class="form-control" type="text"
                                                           name="options[{{$key}}][name]" value="{{$modifier['name']}}"
                                                           placeholder="Название"></td>
                                                <td><select class="custom-select" name="options[{{$key}}][prefix]">
                                                        <option
                                                            {{ $modifier['prefix'] == '-' ? 'selected' : '' }} value="-">
                                                            -
                                                        </option>
                                                        <option
                                                            {{ $modifier['prefix'] == '+' ? 'selected' : '' }} value="+">
                                                            +
                                                        </option>
                                                    </select></td>
                                                <td><input class="form-control" type="text"
                                                           name="options[{{$key}}][price]"
                                                           value="{{$modifier['price']}}"
                                                           placeholder="Цена"></td>
                                                <td><input class="form-control" type="text"
                                                           name="options[{{$key}}][weight]"
                                                           value="{{$modifier['weight']}}"
                                                           placeholder="Вес 0.00"></td>
                                                <td class="text-right">
                                                    <button type="button" onclick="deleteItem(this)"
                                                            data-target="{{$key}}"
                                                            class="btn btn-danger"><i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        function deleteItem(elem) {
            let id = elem.dataset.target;
            let del = document.getElementById('item-' + id);
            del.remove();
        }
    </script>
@endsection
