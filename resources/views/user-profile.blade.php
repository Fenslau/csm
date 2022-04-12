@extends('layouts.app')

@section('title-block', 'Пользователь '.$user->employee->user_name.' '.$user->employee->user_surname)
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('profile', $user) }}
      <h4 class="text-center">Пользователь {{ $user->employee->user_name }} {{ $user->employee->user_surname }}</h4>
      <form class="my-3 form-inline" action="{{ route('user-update', $user->id) }}" method="post">
        @csrf
        <div class="input-group m-1">
            <input type="text" autocomplete="off" class="form-control form-control-sm" name="login" placeholder="Логин" value="{{ old('login', $user->login) }}">
            <input type="email" autocomplete="off" class="form-control form-control-sm" name="email" placeholder="e-mail" value="{{ old('e-mail', $user->email) }}" data-toggle="tooltip" title="Можно оставить пустым">
            <input type="text" autocomplete="off" class="form-control form-control-sm" name="password" placeholder="Пароль" data-toggle="tooltip" title="Оставьте пустым, если не хотите менять">
          <div class="input-group-append">
            <button type="submit" class="btn btn-sm btn-outline-success shadow-none">Обновить</button>
          </div>
        </div>
      </form>

      <form class="form-inline" action="{{ route('give_roles', $user->id) }}" method="post">
        @csrf
        <div class="input-group m-1">
          <label class="mr-3 font-weight-bold" for="{{ $user->id }}">{{ $user->employee->user_name }} {{ $user->employee->user_surname }}: </label>
          <select id="{{ $user->id }}" multiple class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите роли" name="ids[]">
            @forelse ($roles_all as $role)

              <option value="{{ $role->id }}"
                @if(in_array($role->id, array_column($user->roles->toArray(), 'id')))
                  selected
                @endif>{{ $role->role_name }}
              </option>
            @empty
            @endforelse
          </select>
          <div class="input-group-append">
            <button @can(['create_role']) @else disabled @endcan type="submit" class="btn btn-sm btn-outline-success shadow-none">Выдать роли</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
