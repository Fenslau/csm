@extends('layouts.app')

@section('title-block', 'Статистика отказов')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('stat-otkaz') }}
      <h4 class="text-center">Статистика отказов</h4>


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
