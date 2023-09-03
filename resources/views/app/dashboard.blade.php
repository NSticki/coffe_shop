@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3">
                <div class="heading-title">
                    <h1>Главная</h1>
                </div>

                @if( session()->has('message'))
                    <div class="alert alert-success">
                        <b>{{ session()->get('message') }}</b>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-4">
                                <h3>Сообщить о проблеме?</h3>
                                <p class="mt-5">Если у вас по какой то причине не работает панель администрирования
                                    сайтом или приложение, свяжитесь с нами по контактам справа или сообщите нам через
                                    форму ниже.</p>
                                <form action="{{ route('sendMail') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="for-email">E-mail для ответа*</label>
                                        <input id="for-email" type="text" name="email"
                                               class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="for-name">Ваше имя*</label>
                                        <input id="for-name" type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="for-message">Опишите проблему*</label>
                                        <textarea rows="5" id="for-message" name="message"
                                                  class="form-control @error('message') is-invalid @enderror"></textarea>
                                        @error('message')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Отправить</button>
                                    </div>
                                </form>
                            </div>
                            <div class="offset-2 col-6">
                                <h3>Контакты</h3>
                                <p class="mt-5"><b>Проетный менеджер</b></p>
                                <p>Левин Константин</p>
                                <p>+7 (3822) 99-40-43 доб 2</p>
                                <p>Будни с 9.00 до 18.00 (МСК+4)</p>
                                <p>lkv@webstripe.ru</p>
                                <p><a href="http://webstripe.ru">www.webstripe.ru</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
