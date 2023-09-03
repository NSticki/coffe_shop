@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3">
                <div class="heading-title">
                    <h1>{{ $data['title'] }}</h1>
                </div>
                <div class="text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fa fa-plus"
                                                                                      aria-hidden="true"></i>
                        Добавить</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body card-content">
                <div class="row">
                    <div class="col-12">
                        @if($data['users']->isEmpty())
                            <div>
                                <p>Users Empty</p>
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
                                    <td>Имя пользователя</td>
                                    <td>Телефон</td>
                                    <td>Роль</td>
                                    <td class="text-right">Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['users'] as $user)
                                    <tr>
                                        <td>{{ $user['name'] }} {{ $user['lastname'] }}</td>
                                        <td>{{ $user['telephone'] }}</td>
                                        <td>{{ $user['role_id'] == 1 ? 'Администратор' : 'Клиент' }}</td>
                                        <td class="text-right">
                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                  method="POST">
                                                <a class="btn btn-success"
                                                   href="{{ route('users.edit',$user->id) }}"><i
                                                        class="fas fa-eye"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
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
