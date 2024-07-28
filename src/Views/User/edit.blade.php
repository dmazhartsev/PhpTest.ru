@extends('layout')
@section('title')
    Редактирование профиля
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
                <h4 class="font-weight-bold mb-0"><span
                            class="text-muted font-weight-normal">{{$userParameters['email']}}</span>
                </h4>
                <div class="text-muted mb-2">ID: 3425433</div>
            </div>
        </div>

        <div class="card">
            <div class="container">
                <form method="post">
                    <div class="row  mt-2">
                        <div class="col-6">
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Имя</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="first_name"
                                                             placeholder="Имя"
                                                             value="{{$userParameters['first_name']}}"></div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Фамилия</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="last_name"
                                                             placeholder="Фамилия"
                                                             value="{{$userParameters['last_name']}}"></div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Отчество</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="sur_name"
                                                             placeholder="Отчетство"
                                                             value="{{$userParameters['sur_name']}}"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Telegram</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="telegram"
                                                             placeholder="Telegram"
                                                             value="{{$userParameters['contact']['telegram']}}"></div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Skype</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="skype"
                                                             placeholder="Skype" value="{{$userParameters['contact']['skype']}}">
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-sm-3"><p class="mb-0">Telephone</p></div>
                                <div class="col-sm-9"><input class="form-control" type="text" name="telephone"
                                                             placeholder="Telephone"
                                                             value="{{$userParameters['contact']['telephone']}}"></div>
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