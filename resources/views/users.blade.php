@extends('layouts.app')

@section('title-block', 'Управление пользователями')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('users') }}
      <h4 class="text-center">Управление пользователями</h4>

      @include('inc.toast')
      <div class="d-flex flex-column mt-3 p-3 shadow border">
          <h5 class="text-center">Все пользователи</h5>
          <form class="form-inline" name="search-user" action="{{ route('user-search') }}" method="post">
            <div class="input-group m-1">
              <input type="text" size="23" autocomplete="off" class="form-control form-control-sm" name="search" placeholder="Поиск">
              <div class="input-group-append">
                <button type="submit" class="btn btn-sm btn-warning shadow-none btn-csm">Найти</button>
              </div>
            </div>
          </form>
          <div id="user-search-result" class="">
          </div>
          <div class="py-3 d-flex flex-wrap">
            @foreach ($users as $user)
              @include('inc.user')
            @endforeach
          </div>
          {{ $users->onEachSide(2)->links() }}
          <span class="alert alert-info text-right mt-3">Нажмите на пользователя, чтобы установить ему <b>роли</b></span>
    </div>
    <div class="d-flex flex-column mt-3 p-3 shadow border">
        <h5 class="text-center">Все роли</h5>
        <form class="form-inline flex-md-nowrap" action="{{ route('new-role') }}" method="POST">
          @csrf
          <div class="input-group m-1">
            <input type="text" autocomplete="off" class="border-right-0 form-control form-control-sm" name="role_name" placeholder="Название" value="{{ old('role_name') }}">
            <div class="input-group-append">
              <button type="submit" class="btn btn-sm btn-outline-success shadow-none btn-csm">Создать роль</button>
            </div>
          </div>
        </form>

        <div class="py-3 d-flex flex-wrap">
          @forelse ($roles as $role)
            <div class="m-2 p-1 px-2 bg-light rounded border max-content input-group">
              <a class="pr-2" href="{{ route('role', $role->id) }}">{{ $role->role_name }}</a>
              <div class="input-group-append">
                <button url="{{ route('role-del') }}" name="{{ $role->id }}" type="button" class="close pl-2 text-danger del-role border-left">
                  <span>&times;</span>
                </button>
              </div>
            </div>
          @empty
            Ни одной роли не найдено
          @endforelse
        </div>
        <span class="alert alert-info text-right mt-3">Нажмите на роль, чтобы установить её связь с <b>правами</b></span>
    </div>
  </div>
</div>

@endsection
