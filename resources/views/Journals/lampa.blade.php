@extends('layouts.app')

@section('title-block', 'Учёт работы бактерицидной установки')
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
      {{ Breadcrumbs::render('journal-lampa') }}
      <h4 class="text-center mb-3">Учёт работы бактерицидной установки</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <form class="new-lampa" action="{{ route('new-lampa') }}" method="POST">
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

          <div class="btn-group btn-group-toggle m-1 mb-2" data-toggle="buttons">
            <label class="btn btn-outline-success btn-sm shadow-none">
              <input type="radio" name="lampa_type" value="Повторно-кратковременный" autocomplete="off"> Ультрафиолетовая <br><small>бактерицидная установка</small>
            </label>
            <label class="btn btn-outline-success btn-sm shadow-none border-left-0">
              <input type="radio" name="lampa_type" value="Непрерывный" autocomplete="off"> Бактерицидный <br>рециркулятор
            </label>
          </div>

          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3 text-nowrap" for="lampa">Помещение/лампа: </label>
            <input id="lampa" class="form-control form-control-sm" type="text" autocomplete="off" name="lampa" value="@if(session('lampa')) {{ session('lampa') }} @endif">
          </div>

          <div class="btn-group btn-group-toggle m-1 mb-2" data-toggle="buttons">
            <label class="btn btn-outline-success btn-sm shadow-none">
              <input type="radio" name="condition" value="В отсутствии людей" autocomplete="off"> В отсутствии людей
            </label>
            <label class="btn btn-outline-success btn-sm shadow-none border-left-0">
              <input type="radio" name="condition" value="В присутствии людей" autocomplete="off"> В присутствии людей
            </label>
          </div>

          <div class="btn-group btn-group-toggle m-1 mb-2" data-toggle="buttons">
            <label class="btn btn-outline-success btn-sm shadow-none">
              <input type="radio" name="rad_mode" value="Повторно-кратковременный" autocomplete="off"> Повторно-кратковременный
            </label>
            <label class="btn btn-outline-success btn-sm shadow-none border-left-0">
              <input type="radio" name="rad_mode" value="Непрерывный" autocomplete="off"> Непрерывный
            </label>
          </div>


          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3 text-nowrap" for="time_on">Время включения: </label>
            <input id="time_on" class="form-control form-control-sm" type="time" name="time_on" value="">
          </div>

          <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
            <label class="mr-3 text-nowrap" for="time_off">Время выключения: </label>
            <input id="time_off" class="form-control form-control-sm" type="time" name="time_off" value="">
          </div>
          <div class="text-center"><small>длительность будет вычислена автоматически и добавлена в журнал</small></div>

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
      <h4 class="mt-5 text-center">Последние записи из журналов учёта работы
        @empty($request->lampa) @else лампы {{ $request->lampa }} @endempty
        @empty($request->department) @else отдела {{ $request->department }} @endempty
        @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty
        @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty
        @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty
      </h4>
      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 mb-2">
        <form class="form-inline" action="{{ route('journal-lampa') }}" method="GET">
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
              <label class="mr-1" for="lampa_">Кабинет: </label>
              <select id="lampa_"  data-placeholder="Выберите кабинет" class="form-control text-truncate chosen-select" name="lampa">
                  <option value=""></option>
                @foreach ($our_lampas as $lampa)
                  <option class="text-truncate" value="{{ $lampa }}" @if(!empty($request->lampa) AND $lampa == $request->lampa) selected @endif>{{ $lampa }}</option>
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
        @can('lampa_all_view')
          <div data-toggle="tooltip" title="Подробная таблица" class="view-all-table btn text-muted mr-2">
            <i class="fa fa-eye"></i>
          </div>
        @endcan
      </div>
      <div class="table-responsive">
        @include('inc.last-lampa')
      </div>
      @empty($items) @else {{ $items->onEachSide(2)->links() }} @endempty
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="d-flex flex-wrap justify-content-around my-5">

          <div class="alert alert-danger max-content p-0">
            <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('narabotka-lamp') }}">Наработка ламп</a>
          </div>

      </div>
    </div>
  </div>
</div>
@endsection
