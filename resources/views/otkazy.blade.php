@extends('layouts.app')

@section('title-block', 'Регистрация отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('otkaz') }}
      <h4 class="text-center">Регистрация отказов</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <form class="new-otkaz" action="{{ route('new-otkaz') }}" method="POST">
            @csrf
              <!-- <div class="custom-control custom-switch my-3">
                <input type="checkbox" name="call" class="custom-control-input" id="call" @if(session('call')) checked @endif value="1">
                <label class="custom-control-label call-center" for="call">Колл-центр</label>
              </div> -->
              @include('inc.cityandorg')
              <!-- <div class="d-md-none d-block btn-group btn-group-toggle" data-toggle="buttons">
                @foreach ($themes as $theme)
                  <div class="form-check form-check-inline m-2">
                    <label class="form-check-label btn btn-outline-primary shadow-none" for="{{ $theme->id }}">
                    <input class="form-check-input" type="radio" name="theme_id" id="{{ $theme->id }}" value="{{ $theme->id }}">{{ $theme->theme }}</label>
                  </div>
                @endforeach
              </div> -->


            <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
              <label class="mr-3 text-nowrap" for="theme">Тема отказа: </label>
              <select id="theme" class="form-control text-truncate chosen-select" name="theme_id">
                  <option value="">Выберите тему</option>
                @foreach ($themes as $theme)
                  <option class="text-truncate" value="{{ $theme->id }}">{{ $theme->theme }}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
              <label class="mr-3 text-nowrap" for="reason">Причина отказа: </label>
              <select id="reason" class="form-control text-truncate chosen-select" name="reason_id">
                  <option value="">Выберите причину</option>
                @foreach ($reasons as $reason)
                  <option class="text-truncate" value="{{ $reason->id }}">{{ $reason->reason }}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
              <label class="mr-3" for="department">Подразделение: </label>
              <select id="department"  data-placeholder="Выберите подразделение" class="form-control text-truncate chosen-select" name="department">
                @foreach ($departments as $department)
                  <option class="text-truncate" value="{{ $department }}" @if(!empty(session('department')) AND $department == session('department')) selected @endif>{{ $department }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group row m-1">
              <button type="submit" @auth @else disabled @endauth class="btn btn btn-outline-success shadow-none flex-grow-1">Зарегистрировать</button>
            </div>
          </form>
          <!-- <script>
            $(document).ready(function () {
              $(document).on('click', '.call-center', function (e) {
                if (document.getElementById("call").checked) {
                  $('.vision-tooggable').addClass("visiblility");
                  @php(session()->forget('call'))
                  location.reload ();
                }
                else {
                  $('.vision-tooggable').removeClass("visiblility");
                  $('#organization').change();
                }
              });
            });
            $(document).ready(function () {
                if (document.getElementById("call").checked) $('.vision-tooggable').removeClass("visiblility");
                else $('.vision-tooggable').addClass("visiblility");
            });
            $(document).ready(function () {
              $("#organization").change(function(){
                var org = $(this).val();
                axios.post('{{ route('get-departments') }}', {
                    org: org
                  })
                  .then(function (response) {
                    $("#department").html(response.data.options);
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
          </script> -->
        </div>
    </div>
</div>
<div class="container-xl view-all-container">
  <div class="row">
    <div class="col">
      <h4 class="mt-5 text-center">Отказы, сгруппированные @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty</h4>
      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 mb-2">
        <form class="form-inline" action="{{ route('otkaz') }}" method="GET">
          <div class="input-group align-items-center">
            С <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ date('Y-m') }}-01"	max="{{ date('Y-m-d') }}" min="2022-04-01">
            по <input class="w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="2022-04-01">
            <div class="input-group-append">
              <button type="submit" class="btn btn-sm btn-outline-danger shadow-none">Показать</button>
            </div>
          </div>
        </form>
        @can('otkaz_all_view')
          <div data-toggle="tooltip" title="Подробная таблица" class="view-all-table btn text-muted mr-2">
            <i class="fa fa-eye"></i>
          </div>
        @endcan
      </div>
      <div class="table-responsive">
        @include('inc.group-otkazy')
      </div>
      @empty($items) @else {{ $items->onEachSide(2)->links() }} @endempty
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col">
        <div class="d-flex flex-wrap justify-content-around my-5">
          @can('otkaz_reason_edit')
            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_reasons') }}">Причины</a>
            </div>
          @endcan
          @can('otkaz_theme_edit')
            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_themes') }}">Темы</a>
            </div>
          @endcan
            <!-- <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_costs') }}">Стоимость</a>
            </div> -->

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('otkaz-stat') }}">Статистика</a>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection
