@extends('layouts.app')

@section('title-block', 'Внутренние сервисы ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('home') }}
      <div style="height: 75vh;" class="position-relative">
          <div class="d-block h-50">

                <nav class="d-sm-none navbar navbar-light">

                  <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"><i class="fas fa-bars fa-1x"></i> Меню</button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <ul class="navbar-nav mr-auto">

                      <li class="nav-item rounded px-2 my-1 border">
                        <a class="nav-link" href="{{ route('document') }}">Электронный документооборот</a>
                      </li>
                      <li class="nav-item rounded px-2 my-1 border">
                        <a class="nav-link" href="{{ route('procedure') }}">Процедурный кабинет</a>
                      </li>
                      <li class="nav-item rounded px-2 my-1 border">
                        <a class="nav-link" href="{{ route('otkaz') }}">Регистрация отказов</a>
                      </li>
                    </ul>
                  </div>
                </nav>

                <nav class="d-none d-sm-flex justify-content-around align-items-stretch navbar">
                  <div class="m-1 min-content alert alert-success">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('document') }}">Электронный документооборот</a>
                    <p class="d-none d-md-block text-center lh-sm"><small>корреспонденция,	договоры, внутрикорпоративные документы</small></p>
                  </div>
                  <div class="m-1 min-content alert alert-success">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('procedure') }}">Процедурный кабинет</a>
                    <p class="d-none d-md-block text-center lh-sm"><small>регистрация манипуляций</small></p>
                  </div>
                  <div class="m-1 min-content alert alert-success">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('otkaz') }}">Регистрация отказов</a>
                    <p class="d-none d-md-block text-center lh-sm"><small>отказы клиники в запросах пациентов на медицинские услуги</small></p>
                  </div>
                </nav>
          </div>


@canany('create_user', 'create_role')
          <div class="">
            <h5 class="d-none d-md-block text-center pt-3">Администрирование</h5>
            <nav class="d-sm-none navbar navbar-light">

              <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"><i class="fas fa-bars fa-1x"></i> Административное Меню</button>
@canany('create_user', 'create_role')
              <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="{{ route('users') }}">Управление пользователями</a>
                  </li>
                </ul>
              </div>
@endcanany
            </nav>

            <nav class="d-none d-sm-flex justify-content-around align-items-stretch navbar">
@canany('create_user', 'create_role')
              <div class="m-1 min-content alert alert-danger">
                <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('users') }}">Управление пользователями</a>
                <p class="d-none d-md-block text-center lh-sm"><small>создание пользователей, выдача логинов, ролей, прав</small></p>
              </div>
@endcanany
            </nav>
          </div>
@endcanany
      </div>
    </div>
  </div>
</div>

@endsection
