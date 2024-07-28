@extends('layout')
@section('title')
    Регистрация
@endsection
@section('content')
    <div class="container-fluid vh-100 my-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-4 col-sm-12 shadow-lg p-5 bg-light">
                <div class="text-center">
                    <h3 class="text-primary">Регистрация</h3>
                </div>
                <div class="p-4">
                    <form method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-primary">
                                <i class="bi bi-envelope text-white"></i>
                            </span>
                            <input name="email" type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-primary">
                                <i class="bi bi-lock-fill text-white"></i>
                            </span>
                            <input name="password" type="password" class="form-control" placeholder="Пароль">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-primary">
                                <i class="bi bi-key-fill text-white"></i>
                            </span>
                            <input name="repeat_password" type="password" class="form-control" placeholder="Повторите пароль">
                        </div>
                        <div class="d-grid col-12 mx-auto">
                            <input name="button_registration" class="btn btn-primary" type="submit" value="Зарегистрироваться">
                        </div>
                        <p class="text-center mt-3">Уже есть аккаунт?
                            <span class="text-primary"><a href="?c=User&a=authorisation">Войти</a></span>
                        </p>
                        @includeIf('notification')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection