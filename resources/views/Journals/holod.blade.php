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

          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
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
          <div class="d-flex flex-nowrap align-items-baseline form-group m-1">
            <label class="mr-3" for="holodilnik">Холодильник: </label>
            <div id="holodilnik" class="btn-group btn-group-toggle m-1 mb-2" data-toggle="buttons">

            </div>
          </div>

          <div class="btn-group btn-group-toggle m-1 mb-2" data-toggle="buttons">
            <label class="btn btn-outline-success btn-sm shadow-none mr-3">
              <input type="radio" name="time" id="plt" value="utro" autocomplete="off"> Утро
            </label>
            <label class="btn btn-outline-success btn-sm shadow-none">
              <input type="radio" name="time" id="oms" value="vecher" autocomplete="off"> Вечер
            </label>
          </div>

          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3 text-nowrap label-defrost" for="temperature">Температура: </label>
            <input type="range" name="temperature" value="5" class="custom-range" min="1" max="10" id="temperature" oninput="this.nextElementSibling.value = this.value">
            <output class="ml-2 output-defrost">5</output>&deg;C
            <input id="defrost" class="d-none" type="checkbox" name="defrost">
            <label for="defrost" data-toggle="tooltip" title="Разморозка" class="px-2 m-0 text-primary defrost cursor-pointer"><i class="fas fa-snowflakes"></i></label>
          </div>

          <div class="form-group row m-1">
            <button type="submit" @auth @else disabled @endauth class="btn btn btn-outline-success shadow-none flex-grow-1">Зарегистрировать</button>
          </div>
        </form>
        <script>
          $(document).ready(function () {
            $("#department").change(function(){
              var dep = $(this).val();
              axios.post('{{ route('get-holodilnik') }}', {
                  dep: dep
                })
                .then(function (response) {
                  $("#holodilnik").html(response.data.options);
                })
                .catch(function (error) {
                  $('.toast-header').addClass('bg-danger');
                  $('.toast-header').removeClass('bg-success');
                  $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
                  $('.toast').toast('show');
                });
            });
          });
          $(document).ready(function () {
            $("#department").trigger('change');
          });
        </script>
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
              <select id="holodilnik_" style="width: 8rem;" data-placeholder="Выберите холодильник" class="form-control text-truncate chosen-select" name="holodilnik">

              </select>
            </div>
            С <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ date('Y-m') }}-01"	max="{{ date('Y-m-d') }}" min="2022-04-01">
            по <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="2022-04-01">

            <div class="input-group-append">
              <button type="submit" class="btn btn-sm btn-outline-danger shadow-none">Показать</button>
            </div>
          </div>
        </form>
        <script>
          $(document).ready(function () {
            $("#department_").change(function(){
              var dep = $(this).val();
              axios.post('{{ route('get-holodilnik') }}', {
                  dep: dep,
                  select: 1
                })
                .then(function (response) {
                  $("#holodilnik_").html(response.data.options);
                  $('.chosen-select').trigger('chosen:updated');
                })
                .catch(function (error) {
                  $('.toast-header').addClass('bg-danger');
                  $('.toast-header').removeClass('bg-success');
                  $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
                  $('.toast').toast('show');
                });
            });
          });
          $(document).ready(function () {
            $('.chosen-select').trigger('change');
          });
        </script>
        <!-- @can('holod_all_view')
          <div data-toggle="tooltip" title="Подробная таблица" class="view-all-table btn text-muted mr-2">
            <i class="fa fa-eye"></i>
          </div>
        @endcan -->
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
      <div class="d-flex flex-wrap justify-content-around my-5">
        @can('holod_all_view')
        <div class="alert alert-danger max-content p-0">
          <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('journal-holod-list') }}">Список холодильников</a>
        </div>
        @endcan
      </div>
    </div>
  </div>
</div>
@endsection
