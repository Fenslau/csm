@extends('layouts.app')

@section('title-block', 'Назначение прав для роли')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('role', $role) }}
      <h4 class="text-center mb-3">Назначение прав для роли {{ $role->role_name }}</h4>
      <form class="form-inline" action="{{ route('give_permissions', $role->id) }}" method="post">
        @csrf
        <div class="input-group m-1">
          <label class="mr-3 font-weight-bold" for="{{ $role->id }}">{{ $role->role_name }}: </label>
          <select id="{{ $role->id }}" multiple class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите права" name="slug[]">
            @forelse ($permissions_all as $permission)

              <option value="{{ $permission->permission_slug }}"
                @if(in_array($permission->permission_slug, array_column($role->permissions->toArray(), 'permission_slug')))
                  selected
                @endif>{{ $permission->permission_name }}
              </option>
            @empty
            @endforelse
          </select>
          <div class="input-group-append">
            <button type="submit" class="btn btn-sm btn-outline-success shadow-none btn-csm">Выдать права</button>
          </div>
        </div>
      </form>

      <div class="d-flex flex-column mt-3 p-3 shadow border">
          <h5 class="text-center">Пользователи с такой ролью</h5>
          <div class="py-3 d-flex flex-wrap">
            @forelse ($users as $user)
              @include('inc.user')
            @empty
              Нет ни одного пользователя с такой ролью
            @endforelse
          </div>
          @empty($users) @else{{ $users->onEachSide(2)->links() }} @endempty
          <span class="alert alert-info text-right mt-3">Нажмите на пользователя, чтобы установить ему <b>роли</b></span>
    </div>

    </div>
  </div>
</div>

@endsection
