@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <form class="form" action="{{ route('options.store') }}" method="POST">

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
                                                   value="100">
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
                                            <input name="is_disabled" type="checkbox" value="1" id="is_disabled">
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
                                        <tr id="item-0">
                                            <input type="hidden" name="options[0][guid]" value="null">
                                            <td><input class="form-control" type="checkbox" name="options[0][is_disabled]" value="1"></td>
                                            <td><input class="form-control" type="text" name="options[0][name]"
                                                       placeholder="Название"></td>
                                            <td><select class="custom-select" name="options[0][prefix]">
                                                    <option value="-">-</option>
                                                    <option value="+">+</option>
                                                </select></td>
                                            <td><input class="form-control" type="text" name="options[0][price]"
                                                       placeholder="Цена"></td>
                                            <td><input class="form-control" type="text" name="options[0][weight]"
                                                       placeholder="Вес 0.00"></td>
                                            <td class="text-right">
                                                <button type="button" onclick="deleteItem(this)" data-target="0"
                                                        class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
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
