@extends('layouts.app')

@section('title-block', 'Редактирование тем отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('theme') }}
      <h4 class="mb-3 text-center">Редактирование тем отказов</h4>
      <form action="{{ route('theme-add') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input style="border: 1px solid rgb(35, 64, 143) !important;" type="text" autocomplete="off" class="border-success border-right-0 form-control" name="theme" placeholder="Тема отказа">
          <input style="border: 1px solid rgb(35, 64, 143) !important;" type="text" autocomplete="off" class="border-success border-right-0 form-control" name="cost" placeholder="Стоимость">
          <div class="input-group-append">
            <button class="btn btn-outline-success text-nowrap shadow-none btn-csm" type="submit">Добавить тему</button>
          </div>
        </div>
      </form>
      <div class="d-flex flex-column mt-3 p-3 shadow border">
          <h5 class="mb-3 text-center">Все темы</h5>
          <div class="py-3 d-flex flex-wrap">
            @forelse ($themes as $theme)
              <div class="m-2 p-1 px-2 bg-light rounded border max-content input-group">
                {{ $theme->theme }}
                <div class="input-group-append">
                  <button url="{{ route('theme-del') }}" name="{{ $theme->id }}" type="button" class="close pl-2 text-danger del-theme">
                    <span>&times;</span>
                  </button>
                </div>
              </div>
            @empty
              Ни одной темы не найдено
            @endforelse
          </div>
        </div>
    </div>
  </div>
</div>

@endsection
