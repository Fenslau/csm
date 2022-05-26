
<div class="shadow header">
  <div class="container">
    <div class="row">
      <div class="col d-flex align-items-center justify-content-between">
        @auth
          <div class="w-100 d-flex align-items-center justify-content-between">
            <a class="btn btn-sm btn-header shadow-none text-nowrap" href="{{ route('logout') }}">Выйти	&#8291; <i class="fa fa-sign-out"></i></a>
            <div class="font-weight-bolder text-right">
              <a class="alert-link card-link text-white" href="{{ route('user', auth()->user()->id) }}">
                <i class="fa fa-user"></i>
                {{ auth()->user()->name }}
              </a>
            </div>
          </div>
        @else

          <a class="btn btn-sm btn-header shadow-none text-nowrap" data-toggle="modal" data-target="#login" href="#"> Вход в систему</a>
          <img class="logo" src="https://0370.ru/panels/top_panel/pics/0370_logo.png">
        @endauth
      </div>
    </div>
  </div>
</div>
