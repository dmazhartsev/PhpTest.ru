@extends('layout')
@section('title')
    Инфо
@endsection
@section('content')
    <div class="container flex-grow-1 container-p-y my-2">

        <div class="d-flex mb-3">
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt=""
                 class="rounded-circle me-3 ui-w-100">
            <div>
                <h4 class="font-weight-bold mb-0">{{$userParameters['first_name']}} {{$userParameters['last_name']}} {{$userParameters['sur_name']}}
                    <span class="text-muted font-weight-normal">{{$userParameters['email']}}</span>
                </h4>
                <div class="text-muted mb-2">ID: 3425433</div>
                <a href="?c=User&a=edit" class="btn btn-outline-dark">Редактировать профиль</a>&nbsp;
                <a href="?c=User&a=change_password" class="btn btn-outline-dark">Изменить пароль</a>&nbsp;
                <a href="?c=User&a=logout" class="btn btn-outline-dark">Выйти</a>&nbsp;
            </div>
        </div>

        <div class="card">
            <div class="container">
                <div class="row my-2 justify-content-md-start">
                    <div class="col-6">
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Имя</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['first_name']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Фамилия</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['last_name']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Отчество</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['sur_name']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Telegram</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['contact']['telegram']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Skype</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['contact']['skype']}}</p></div>
                        </div>
                        <div class="row">
                            <div class="mt-1 col-sm-3"><p class="mb-0">Telephone</p></div>
                            <div class="mt-1 col-sm-9"><p class="text-muted mb-0">{{$userParameters['contact']['telephone']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection