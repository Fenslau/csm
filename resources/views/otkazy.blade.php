@extends('layouts.app')

@section('title-block', 'Регистрация отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('otkaz') }}
      <h4 class="text-center">Регистрация отказов</h4>
        <div class="d-flex flex-wrap justify-content-between">
          <form class="max-content my-3 new-otkaz" action="{{ route('new-otkaz') }}" method="POST">
            @csrf
            @include('inc.otkaz-form', ['multiple' => '', 'arr' => ''])

            <div class="form-group row m-1">
              <button @can(['create_otkaz']) @else disabled @endcan type="submit" class="btn btn btn-outline-success shadow-none flex-grow-1 mr-2">Зарегистрировать</button>
              <input type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить" onclick="$('.chosen-select option:selected').removeAttr('selected'); $('.chosen-select option').prop('selected', false); $('.chosen-select').trigger('chosen:updated');">
            </div>
          </form>
            @can('otkaz_stat')
              <form class="max-content my-3 stat-otkaz" action="{{ route('stat-otkaz') }}" method="POST">
                @csrf
                @include('inc.otkaz-form', ['multiple' => 'multiple', 'arr' => '[]'])
                <div class="form-group row m-1">
                  С <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ session('calendar_from') }}"	max="{{ date('Y-m-d') }}" min="2022-04-04">
                  по <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ session('calendar_to') }}" max="{{ date('Y-m-d') }}" min="2022-04-04">
                </div>
                <div class="form-group row m-1">
                  <button type="submit" class="btn btn btn-outline-danger shadow-none flex-grow-1 mr-2">Показать</button>
                  <input type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить" onclick="$('.chosen-select option:selected').removeAttr('selected'); $('.chosen-select option').prop('selected', false); $('.chosen-select').trigger('chosen:updated');">
                </div>
              </form>
            @endcan
        </div>
      <h4 class="mt-5 text-center">Последние зарегистрированные отказы</h4>
      <div class="table-responsive">
        @include('inc.last-otkazy')
      </div>
      @empty($items) @else {{ $items->onEachSide(2)->links() }} @endempty
        <div class="d-flex justify-content-around">
          @canany('reason_add', 'reason_del')
            <div class="alert alert-danger max-content p-0 mt-3">
              <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_reasons') }}">Редактировать причины</a>
            </div>
          @endcan
          @can('otkaz_cost')
            <div class="alert alert-danger max-content p-0 mt-3">
              <a class="nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_costs') }}">Редактировать стоимость</a>
            </div>
          @endcan
        </div>
    </div>
  </div>
</div>

@endsection
