@extends('layouts.app')

@section('title-block', 'Внутренние сервисы ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('home') }}
      <div style="height: 75vh;" class="position-relative">
          <div class="d-block">

                <!-- <nav class="d-sm-none navbar navbar-light">

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
                        <a class="nav-link" href="{{ route('journals') }}">Журналы</a>
                      </li>
                      <li class="nav-item rounded px-2 my-1 border">
                        <a class="nav-link" href="{{ route('otkaz') }}">Регистрация отказов</a>
                      </li>
                    </ul>
                  </div>
                </nav> -->

                <nav class="d-flex justify-content-around align-items-stretch navbar">
                  <!-- <div class="m-1 min-content alert alert-success">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('document') }}">Электронный документооборот</a>
                    <p class="d-none d-md-block text-center lh-sm"><small>корреспонденция,	договоры, внутрикорпоративные документы</small></p>
                  </div>
                  <div class="m-1 min-content alert alert-success">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('procedure') }}">Процедурный кабинет</a>
                    <p class="d-none d-md-block text-center lh-sm"><small>регистрация манипуляций</small></p>
                  </div> -->
                  <div class="m-1 min-content alert alert-success btn-csm">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase text-white" href="{{ route('journals') }}">Журналы</a>
                    <p class="text-center lh-sm"><small>холодильники, уборка помещений, кварцевание и т.п</small></p>
                  </div>
                  <div class="m-1 min-content alert alert-success btn-csm">
                    <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase text-white" href="{{ route('otkaz') }}">Регистрация отказов</a>
                    <p class="text-center lh-sm"><small>отказы клиники в запросах пациентов на медицинские услуги</small></p>
                  </div>
                </nav>
          </div>



          <div class="">
            <!-- <h5 class="d-none d-md-block text-center pt-3">Администрирование</h5>
            <nav class="d-sm-none navbar navbar-light">

              <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"><i class="fas fa-bars fa-1x"></i> Административное Меню</button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="{{ route('users') }}">Управление пользователями</a>
                  </li>
                </ul>
              </div>

            </nav> -->
@can('manage_users')
            <nav class="d-flex justify-content-around align-items-stretch navbar">

              <div class="m-1 min-content alert  btn-csm">
                <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase text-white" href="{{ route('users') }}">Управление пользователями</a>
                <p class="text-center lh-sm"><small>контроль пользователей, выдача ролей, прав</small></p>
              </div>

            </nav>
@endcan
          </div>

      </div>
    </div>
  </div>
</div>

@endsection
