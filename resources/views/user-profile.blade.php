@extends('layouts.app')

@section('title-block', 'Пользователь '.$user->name)
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('profile', $user) }}
      <h4 class="text-center">Пользователь {{ $user->name }}</h4>
      <div class="my-3 max-content">
        <div class="d-flex justify-content-between">
          <span>E-mail: </span> <span class="ml-3">{{ $user->email }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Город: </span> <span class="ml-3">{{ $user->city }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Организация: </span> <span class="ml-3">{{ $user->organization }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Подразделение: </span> <span class="ml-3">{{ $user->department }}</span>
        </div>
      </div>

      <form class="form-inline" action="{{ route('give_roles', $user->id) }}" method="post">
        @csrf
        <div class="input-group">
          <label class="mr-2 font-weight-bold">Роли: </label>
          <select multiple class="form-control w-auto overflow-auto chosen-select border-right-0" data-placeholder="Выберите роли" name="ids[]">
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
            <button type="submit" class="btn btn-sm btn-outline-success shadow-none">Выдать роли</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
