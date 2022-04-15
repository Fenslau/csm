@extends('layouts.app')

@section('title-block', 'Регистрация отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('otkaz') }}
      <h4 class="text-center">Регистрация отказов</h4>
          <div class="custom-control custom-switch my-3">
            <input type="checkbox" name="add_help_words_8" class="custom-control-input" id="call">
            <label class="custom-control-label call-center" for="call">Колл-центр</label>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <form class="new-otkaz" action="{{ route('new-otkaz') }}" method="POST">
            @csrf
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
              <!-- <input type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить" onclick="$('.chosen-select option:selected').removeAttr('selected'); $('.chosen-select option').prop('selected', false); $('.chosen-select').trigger('chosen:updated');"> -->
            </div>
          </form>
          <script>
            $(document).ready(function () {
              $(document).on('click', '.call-center', function (e) {
                $('.vision-tooggable').toggleClass("visiblility");

              });
            });
          </script>
        </div>
    </div>

  <div class="row">
    <div class="col">
      <h4 class="mt-5 text-center">Последние зарегистрированные отказы</h4>
      <div class="table-responsive">
        @include('inc.last-otkazy')
      </div>
      @empty($items) @else {{ $items->onEachSide(2)->links() }} @endempty
        <div class="d-flex flex-wrap justify-content-around my-3">

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_reasons') }}">Причины</a>
            </div>

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_themes') }}">Темы</a>
            </div>

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('edit_otkaz_costs') }}">Стоимость</a>
            </div>

            <div class="alert alert-danger max-content p-0">
              <a class="min-content nav-link stretched-link alert-link rounded font-weight-bolder lh-m text-center text-uppercase" href="{{ route('otkaz-stat') }}">Статистика</a>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection
