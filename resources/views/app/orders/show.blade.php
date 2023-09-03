@extends('layouts.app', ['name' => 'Joe Doe'])

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3">
                <div class="heading-title">
                    <h1>Заказ №{{ $data['order']->id }}</h1>
                </div>
                <div class="text-right">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary"><i
                            class="fas fa-arrow-alt-circle-left"></i> Назад</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body card-content">
                <table class="main-table table table-hover">
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Клиент</td>
                        <td>Телефон</td>
                        <td>Терминал</td>
                        <td>Комментарий</td>
                        <td>Сумма</td>
                        <td>Дата</td>
                        <td>Статус</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $data['order']->id }}</td>
                        <td>{{ $data['order']->firstname . " " . $data['order']->lastname }}</td>
                        <td>{{ $data['order']->telephone }}</td>
                        <td>{{ $data['order']->telephone }}</td>
                        <td>{{ $data['order']->comment }}</td>
                        <td>{{ $data['order']->total_sum }}</td>
                        <td>{{ $data['order']->created_at }}</td>
                        <td>@if ($data['order']->is_paid == 1)
                                Оплачено
                            @else
                                Не оплачено
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p>Корзина</p>
                <table class="main-table table table-hover">
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Товар</td>
                        <td>Кол-во</td>
                        <td>Модификаторы</td>
                        <td>Цена</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['order_items'] as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item['name_product'] }}</td>
                            <td>{{ $item['amount'] }}</td>
                            <td>
                                @foreach($item['modifiers'] as $modifiers)
                                    <div>{{ $modifiers['name_options'] }}</div>
                                @endforeach
                            </td>
                            <td>{{ $item['price_product'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
