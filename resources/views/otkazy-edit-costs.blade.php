@extends('layouts.app')

@section('title-block', 'Редактирование причин отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('cost') }}
      <h4 class="mb-3 text-center">Редактирование стоимости отказов</h4>
      <form class="my-3" action="{{ route('update_otkaz_costs') }}" method="post">
        @csrf
        @forelse ($items as $item)
          <div id="theme_{{ $item->id }}" class=" d-flex flex-nowrap form-group m-1 form-inline">
            <label style="min-width: 7rem;" class="justify-content-end text-truncate" for="theme_cost_{{ $item->id }}">{{ $item->theme }}: </label>
            <input id="theme_cost_{{ $item->id }}" class=" ml-3 form-control form-control-sm" type="text" name="{{ $item->id }}" autocomplete="off" value="{{ $item->cost }}" placeholder="Стоимость">
          </div>
        @empty
          <p>Не найдено ни одной темы отказов. Задайте их на странице <a href="{{ route('edit_otkaz_themes') }}">Тем</a></p>
        @endforelse

        <div class="form-group row m-1 my-3">
          <button type="submit" class="btn btn-outline-danger shadow-none mr-2 btn-csm">Сохранить</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
