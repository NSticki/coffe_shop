@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3">
                <div class="heading-title">
                    <h1>{{ $data['title'] }}</h1>
                </div>
                <div class="text-right">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body card-content">
                <div class="row">
                    <div class="col-12">
                        @if($data['users']->isEmpty())
                            <div>
                                <p>Нет покупателей</p>
                            </div>

                        @else
                            @if( session()->has('message'))
                                <div class="alert alert-success">
                                    <b>{{ session()->get('message') }}</b>
                                </div>
                            @endif
                            <table class="main-table table table-hover">
                                <thead>
                                <tr>
                                    <td>Имя покупателя</td>
                                    <td>Телефон</td>
                                    <td class="text-right">Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['users'] as $user)
                                    <tr>
                                        <td>{{ $user['name'] }} {{ $user['lastname'] }}</td>
                                        <td>{{ $user['phone'] }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-success"
                                               href="{{ route('customers.show',$user->id) }}"><i
                                                    class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endempty
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        {{ $data['users']->links('assets.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
