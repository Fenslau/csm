@extends('layouts.app')

@section('title-block', 'Регистрация и контроль температурного режима холодильника')
@section('description-block', '')

@section('content')
<style>
.dataTables_filter {
  display: none;
}
</style>
<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('journal-holod') }}
      <h4 class="text-center mb-3">Регистрация и контроль температурного режима холодильника</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <form class="new-holod" action="{{ route('new-holod') }}" method="POST">
          @csrf
          @include('inc.cityandorg')

          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3" for="department">Подразделение: </label>
            <select id="department"  data-placeholder="Выберите подразделение" class="form-control text-truncate chosen-select" name="department">
              @foreach ($departments as $department)
                <option class="text-truncate" value="{{ $department }}"
                  @if(!empty(session('department')))
                    @if ($department == session('department')) selected @endif
                  @elseif(!empty(auth()->user()->department) AND auth()->user()->department == $department) selected
                  @endif
                >{{ $department }}</option>
              @endforeach
            </select>
          </div>
          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3" for="holodilnik">Холодильник: </label>
            <select id="holodilnik"  data-placeholder="Выберите холодильник" class="form-control text-truncate chosen-select" name="holodilnik">
              @foreach ($holodilniks as $holodilnik)
                <option class="text-truncate" value="{{ $holodilnik }}" @if(!empty(session('holodilnik')) AND $holodilnik == session('holodilnik')) selected @endif>{{ $holodilnik }}</option>
              @endforeach
            </select>
          </div>


          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3 text-nowrap" for="time">Время суток: </label>
            <select id="time" data-placeholder="Выберите время суток" class="form-control text-truncate chosen-select" name="time">
                <option value=""></option>
                <option value="utro">Утро</option>
                <option value="vecher">Вечер</option>
            </select>
          </div>

          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3 text-nowrap" for="temperature">Температура: </label>
            <select id="temperature" data-placeholder="Выберите температуру" class="form-control text-truncate chosen-select" name="temperature">
              @for ($temp = 1; $temp < 10; $temp++)
                <option value="{{ $temp }}" @if(!empty(session('temperature')) AND $temp == session('temperature')) selected @endif>{{ $temp }}&deg;C</option>
              @endfor
                <option value="Разморозка">Разморозка</option>
            </select>
          </div>

          <div class="form-group row m-1">
            <button type="submit" @auth @else disabled @endauth class="btn btn btn-outline-success shadow-none flex-grow-1">Зарегистрировать</button>
          </div>
        </form>
      </div>
  </div>
</div>
<div class="container-xl view-all-container">
  <div class="row">
    <div class="col mb-5">
      <h4 class="mt-5 text-center">Последние записи из журналов контроля
        @empty($request->holodilnik) @else холодильника {{ $request->holodilnik }} @endempty
        @empty($request->department) @else отдела {{ $request->department }} @endempty
        @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty
        @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty
        @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty
      </h4>
      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 mb-2">
        <form class="form-inline" action="{{ route('journal-holod') }}" method="GET">
          <div class="input-group align-items-center">
            <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
              <label class="mr-1" for="department_">Подразделение: </label>
              <select style="width: 200px;" id="department_"  data-placeholder="Выберите подразделение" class="form-control text-truncate chosen-select" name="department">
                  <option value=""></option>
                @foreach ($our_departments as $department)
                  <option class="text-truncate" value="{{ $department }}" @if(!empty($request->department) AND $department == $request->department) selected @endif>{{ $department }}</option>
                @endforeach
              </select>
            </div>
            <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
              <label class="mr-1" for="holodilnik_">Холодильник: </label>
              <select id="holodilnik_"  data-placeholder="Выберите холодильник" class="form-control text-truncate chosen-select" name="holodilnik">
                  <option value=""></option>
                @foreach ($our_holodilniks as $holodilnik)
                  <option class="text-truncate" value="{{ $holodilnik }}" @if(!empty($request->holodilnik) AND $holodilnik == $request->holodilnik) selected @endif>{{ $holodilnik }}</option>
                @endforeach
              </select>
            </div>
            С <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ date('Y-m') }}-01"	max="{{ date('Y-m-d') }}" min="2022-04-01">
            по <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="2022-04-01">

            <div class="input-group-append">
              <button type="submit" class="btn btn-sm btn-outline-danger shadow-none">Показать</button>
            </div>
          </div>
        </form>
        @can('holod_all_view')
          <div data-toggle="tooltip" title="Подробная таблица" class="view-all-table btn text-muted mr-2">
            <i class="fa fa-eye"></i>
          </div>
        @endcan
      </div>
      <div class="table-responsive">
        @include('inc.last-holod')
      </div>
      @empty($items) @else {{ $items->onEachSide(2)->links() }} @endempty
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col">

    </div>
  </div>
</div>
@endsection
