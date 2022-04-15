@extends('layouts.app')

@section('title-block', 'Статистика отказов')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('otkaz-stat') }}
      <h4 class="text-center">Статистика отказов</h4>
      <form class="max-content my-5 stat-otkaz" action="{{ route('otkaz-stat') }}" method="GET">
        @csrf
        <div class="form-group row m-1">
          С <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ session('calendar_from') }}"	max="{{ date('Y-m-d') }}" min="2022-04-04">
          по <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ session('calendar_to') }}" max="{{ date('Y-m-d') }}" min="2022-04-04">
        </div>
        <div class="form-group row m-1">
          <button type="submit" class="btn btn btn-outline-danger shadow-none flex-grow-1 mr-2">Показать</button>
          <input type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить" onclick="$('.chosen-select option:selected').removeAttr('selected'); $('.chosen-select option').prop('selected', false); $('.chosen-select').trigger('chosen:updated');">
        </div>
      </form>

    </div>
  </div>
</div>
<script src="//code.highcharts.com/highcharts.src.js"></script>
<script src="//code.highcharts.com/modules/data.src.js"></script>
<script src="//code.highcharts.com/modules/wordcloud.src.js"></script>
<script src="//code.highcharts.com/modules/drilldown.src.js"></script>
<script src="//code.highcharts.com/modules/annotations.src.js"></script>
<script src="//code.highcharts.com/modules/exporting.src.js"></script>
<script src="//code.highcharts.com/modules/export-data.src.js"></script>
<script src="//code.highcharts.com/modules/accessibility.src.js"></script>
@endsection
