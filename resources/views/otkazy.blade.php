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
              <div class="custom-control custom-switch my-3">
                <input type="checkbox" name="call" class="custom-control-input" id="call" @if(session('call')) checked @endif value="1">
                <label class="custom-control-label call-center" for="call">Колл-центр</label>
              </div>
              @empty(auth()->user()->city)
                <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
                  <label class="mr-3" for="city">Город: </label>
                  <select id="city" class="form-control text-truncate chosen-select" name="city">
                    @foreach ($cities as $city)
                      <option class="text-truncate" value="{{ $city }}" @if(!empty(auth()->user()->city) AND $city == auth()->user()->city) selected @endif>{{ $city }}</option>
                    @endforeach
                  </select>
                </div>
              @else
                <input type="hidden" name="city" value="{{ auth()->user()->city }}">
              @endempty

              <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1 visiblility vision-tooggable">
                <label class="mr-3" for="organization">Организация: </label>
                <select id="organization" class="form-control text-truncate chosen-select" name="organization">
                  @foreach ($organizations as $organization)
                    <option class="text-truncate" value="{{ $organization }}" @if(!empty(auth()->user()->organization) AND $organization == auth()->user()->organization) selected @endif>{{ $organization }}</option>
                  @endforeach
                </select>
              </div>


              <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1 visiblility vision-tooggable">
                <label class="mr-3" for="department">Подразделение: </label>
                <select id="department" class="form-control text-truncate chosen-select" name="department">
                  @foreach ($departments as $department)
                    <option class="text-truncate" value="{{ $department }}" @if(!empty(auth()->user()->department) AND $department == auth()->user()->department) selected @endif>{{ $department }}</option>
                  @endforeach
                </select>
              </div>

              <div class="d-md-none d-block btn-group btn-group-toggle" data-toggle="buttons">
                @foreach ($themes as $theme)
                  <div class="form-check form-check-inline m-2">
                    <label class="form-check-label btn btn-outline-primary shadow-none" for="{{ $theme->id }}">
                    <input class="form-check-input" type="radio" name="theme_id" id="{{ $theme->id }}" value="{{ $theme->id }}">{{ $theme->theme }}</label>
                  </div>
                @endforeach
              </div>


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
            <div class="form-group row m-1">
              <button type="submit" @auth @else disabled @endauth class="btn btn btn-outline-success shadow-none flex-grow-1">Зарегистрировать</button>
            </div>
          </form>
          <script>
            $(document).ready(function () {
              $(document).on('click', '.call-center', function (e) {
                if (document.getElementById("call").checked) {
                  $('.vision-tooggable').addClass("visiblility");
                  @php(session()->forget('call'))
                  location.reload ();
                }
                else {
                  $('.vision-tooggable').removeClass("visiblility");
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
          </script>
        </div>
    </div>
</div>
<div class="container-xl">
  <div class="row">
    <div class="col">
      <h4 class="mt-5 text-center">Отказы, сгруппированные @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty</h4>
      <form class="form-inline float-right my-3" action="{{ route('otkaz') }}" method="GET">
        <div class="form-group">
          С <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="2022-04-04"	max="{{ date('Y-m-d') }}" min="2022-04-04">
          по <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="2022-04-04">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-outline-danger shadow-none">Применить</button>
        </div>
      </form>
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

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_reasons') }}">Причины</a>
            </div>

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_themes') }}">Темы</a>
            </div>

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
