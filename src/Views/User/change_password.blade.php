@extends('layout')
@section('title')
    Изменение пароля
@endsection
@section('content')
    <div class="container flex-grow-1 container-p-y my-2">
        <div class="d-flex mb-3">
            <div class="hovereffect">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt=""
                     class="rounded-circle me-3 ui-w-100">
                <div class="overlay">
                    <a class="info" href="#">Загрузить</a>
                </div>
            </div>
            <div>
                <h4 class="font-weight-bold mb-0"><span class="text-muted font-weight-normal">ivanovivan@mail.ru</span>
                </h4>
                <div class="text-muted mb-2">ID: 3425433</div>
            </div>
        </div>
        <div class="card">
            <div class="container">
                <form method="post">
                    <div class="row  mt-2">
                        <div class="col-6">
                            <div class="input-group mb-3">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-lock-fill text-black"></i>
                            </span>
                                <input name="oldPassword" type="password" id="password" class="form-control"
                                       placeholder="Текущий пароль">
                                <span class="input-group-text" onclick="password_show_hide();">
                                    <i class="bi bi-eye-slash" id="show_eye"></i>
                                    <i class="bi bi-eye d-none" id="hide_eye"></i>
                                </span>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text bg-white">
                            <i class="bi bi-lock text-black"></i>
                            </span>
                                <input name="newPassword" type="password" class="form-control"
                                       placeholder="Новый пароль">
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-key-fill text-black"></i>
                            </span>
                                <input name="repeatNewPassword" type="password" 
                                       class="form-control" placeholder="Повторите новый пароль">
                            </div>
                        </div>
                    </div>
                    <div class="row my-2 justify-content-md-end">
                        <div class="col-2">
                            <input name="button_save_changes" class="btn btn-outline-dark" type="submit"
                                   value="Сохранить">
                            <input name="button_cancel" class="btn btn-outline-dark" type="submit" value="Отмена">
                        </div>
                    </div>
                    @includeIf('notification')
                </form>
            </div>
        </div>
    </div>
@endsection