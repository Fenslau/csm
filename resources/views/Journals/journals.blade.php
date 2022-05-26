@extends('layouts.app')

@section('title-block', 'Журналы ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('journals') }}
      <div class="d-block h-50">

            <!-- <nav class="d-sm-none navbar navbar-light">

              <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"><i class="fas fa-bars fa-1x"></i> Журналы</button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                <ul class="navbar-nav mr-auto">

                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="{{ route('journal-holod') }}">Холодильники</a>
                  </li>
                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="{{ route('journal-lampa') }}">Лампы</a>
                  </li>
                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="#">...</a>
                  </li>
                  <li class="nav-item rounded px-2 my-1 border">
                    <a class="nav-link" href="#">...</a>
                  </li>
                </ul>
              </div>
            </nav> -->

            <nav class="d-flex justify-content-around align-items-stretch navbar">
              <div class="m-1 min-content alert alert-success btn-csm">
                <p class="text-center lh-sm mb-0"><small>Регистрация и контроль температурного режима</small></p>
                <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase text-white" href="{{ route('journal-holod') }}">холодильника</a>
              </div>
              <div class="m-1 min-content alert alert-success btn-csm">
                <p class="text-center lh-sm mb-0"><small>учёт работы</small></p>
                <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase text-white" href="{{ route('journal-lampa') }}">бактерицидной установки</a>
              </div>
            </nav>
      </div>

    </div>
  </div>
</div>

@endsection
