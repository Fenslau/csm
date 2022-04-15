
<div class="p-2 alert alert-primary shadow">
  <div class="container">
    <div class="row">
      <div class="col d-flex align-items-center justify-content-between">
        @auth
          <div class="w-100 d-flex align-items-center justify-content-between">
            <a class="btn btn-sm btn-secondary shadow-none text-nowrap" href="{{ route('logout') }}"><i class="fa fa-sign-out fa-flip-horizontal"></i> Выйти</a>
            <div class="font-weight-bolder">
              <a class="alert-link card-link" href="{{ route('user', auth()->user()->id) }}">
                <i class="fa fa-user"></i>
                {{ auth()->user()->name }}
              </a>
            </div>
          </div>
        @else
          <div class="m-auto">
              Войдите в систему под своей корпоративной учётной записью
          </div>
          <a class="btn btn-sm btn-primary shadow-none text-nowrap" data-toggle="modal" data-target="#login" href="#"><i class="fa fa-sign-in fa-flip-horizontal"></i> Войти</a>
        @endauth
      </div>
    </div>
  </div>
</div>
