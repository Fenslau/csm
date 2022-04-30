@extends('layouts.app')

@section('title-block', 'Статистика отказов')
@section('description-block', '')

@section('content')
<style type="text/css">

    .highcharts-credits {
      display: none;
    }
    caption.highcharts-table-caption {
      display: none;
    }

    .highcharts-figure .highcharts-root {
      font-family: inherit !important;
    }
    .highcharts-data-table table {
    	border: 1px solid #EBEBEB;
    	margin: 10px auto;
    	text-align: center;
    	width: 100%;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        color: #555;
    }
    .highcharts-data-table th {
      padding: 0.5em;
    	background-color: initial;
    	color: initial;
    	border-color: initial;
    	position: initial;
    	border-left: initial;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
    	border-left: initial;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .icon {
      min-width: 1rem;
    }
</style>
<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('otkaz-stat') }}
      <h4 class="text-center">Статистика отказов</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form class="stat-otkaz" action="{{ route('otkaz-stat') }}" method="GET">
            <div class="d-flex flex-nowrap justify-content-between form-group m-1">
              <label class="mr-3" for="city">Город: </label>
              <select multiple id="city" class="form-control text-truncate chosen-select" data-placeholder="Выберите город" name="city[]">
                @foreach ($cities as $city)
                  <option class="text-truncate" value="{{ $city }}" @if (is_array($request->city) AND in_array($city, $request->city)) selected @endif>{{ $city }}</option>
                @endforeach
              </select>
            </div>

          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3" for="organization">Организация: </label>
            <select multiple id="organization" class="form-control text-truncate chosen-select" data-placeholder="Выберите организацию" name="organization[]">
              @foreach ($organizations as $organization)
                <option class="text-truncate" value="{{ $organization }}" @if (is_array($request->organization) AND in_array($organization, $request->organization)) selected @endif>{{ $organization }}</option>
              @endforeach
            </select>
          </div>


          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3" for="department">Подразделение: </label>
            <select multiple id="department" class="form-control text-truncate chosen-select" data-placeholder="Выберите подразделение" name="department[]">
              @foreach ($departments as $department)
                <option class="text-truncate" value="{{ $department }}" @if (is_array($request->department) AND in_array($department, $request->department)) selected @endif>{{ $department }}</option>
              @endforeach
            </select>
          </div>

          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3 text-nowrap" for="omsdms">ПЛТ/ОМС/ДМС: </label>
            <select multiple id="omsdms" class="form-control text-truncate chosen-select" data-placeholder="Выберите из списка" name="omsdms[]">
                <option class="" value="ПЛТ">ПЛТ</option>
                <option class="" value="ОМС">ОМС</option>
                <option class="" value="ДМС">ДМС</option>
            </select>
          </div>

        <div class="d-flex flex-nowrap justify-content-between form-group m-1">
          <label class="mr-3 text-nowrap" for="theme">Тема отказа: </label>
          <select multiple id="theme" class="form-control text-truncate chosen-select" data-placeholder="Выберите тему отказа" name="theme_id[]">
            @foreach ($themes as $theme)
              <option class="text-truncate" value="{{ $theme->id }}" @if (is_array($request->theme_id) AND in_array($theme->id, $request->theme_id)) selected @endif>{{ $theme->theme }}</option>
            @endforeach
          </select>
        </div>

        <div class="d-flex flex-nowrap justify-content-between form-group m-1">
          <label class="mr-3 text-nowrap" for="reason">Причина отказа: </label>
          <select multiple id="reason" class="form-control text-truncate chosen-select" data-placeholder="Выберите причину отказа" name="reason_id[]">
            @foreach ($reasons as $reason)
              <option class="text-truncate" value="{{ $reason->id }}" @if (is_array($request->reason_id) AND in_array($reason->id, $request->reason_id)) selected @endif>{{ $reason->reason }}</option>
            @endforeach
          </select>
        </div>


        <div class="form-group row m-1 align-items-center">
          С <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" value="{{ date('Y-m') }}-01"	max="{{ date('Y-m-d') }}" min="2022-04-01">
          по <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="2022-04-01">
        </div>
        <div class="form-group row m-1">
          <button type="submit" class="btn btn-outline-danger shadow-none flex-grow-1 mr-2">Показать</button>
          <input type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить" onclick="$('.chosen-select option:selected').removeAttr('selected'); $('.chosen-select option').prop('selected', false); $('.chosen-select').trigger('chosen:updated');">
        </div>
      </form>
    </div>
  </div>


  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container1.5"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container1.5', {
              chart: {
                  type: 'pie'
              },
              title: {
                  text: 'Отказы по подразделениям @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: ''
              },

              accessibility: {
                  announceNewData: {
                      enabled: true
                  },
                  point: {
                      valueSuffix: ''
                  }
              },

              plotOptions: {
                  series: {
                      dataLabels: {
                          enabled: true,
                          format: '{point.name}: {point.y:.0f}'
                      }
                  }
              },

              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
              },

              series: [
                  {
                      name: "Отказы",
                      colorByPoint: true,
                      data: [
                        @foreach($our_departments as $dep)
                          {
                              name: "{{ $dep['department'] }}",
                              y: {{ $dep['count'] }},
                              drilldown: "{{ $dep['department'] }}"
                          },
                        @endforeach
                      ]
                  }
              ],
              drilldown: {
                  series: [
                    @foreach($our_departments as $dep)
                      {
                          name: "Отказы",
                          id: "{{ $dep['department'] }}",
                          data: [

                          ]
                      },
                    @endforeach
                  ]
              }
          });
        });
      </script>
    </div>
  </div>


  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container1.8"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container1.8', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Отказы по подразделениям @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на подразделение, чтобы увидеть статистику по нему по датам'
              },
              accessibility: {
                  announceNewData: {
                      enabled: true
                  }
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: 'Количество отказов'
                  }

              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.0f}'
                      }
                  }
              },

              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
              },

              series: [
                  {
                      name: "Отказы",
                      colorByPoint: true,
                      data: [
                        @foreach ($our_departments as $department)
                          {
                              name: "{{ $department->department }}",
                              y: {{ $department->count }},
                              drilldown: "{{ $department->department }}"
                          },
                        @endforeach
                      ]
                  }
              ],
              drilldown: {
                  breadcrumbs: {
                      position: {
                          align: 'right'
                      }
                  },
                  series: [
                      @foreach ($our_departments as $department)
                        {
                          name: "Отказы",
                          id: "{{ $department->department }}",
                          data: [
                            @foreach ($department->dates as $date => $value)
                              [
                                  "{{ $date }}",
                                  {{ count($value) }}
                              ],
                            @endforeach
                          ]
                        },
                      @endforeach
                  ]
              }
          });
        });
      </script>
    </div>
  </div>


  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container2"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container2', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Темы отказов @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на тему, чтобы увидеть статистику по ней по датам'
              },
              accessibility: {
                  announceNewData: {
                      enabled: true
                  }
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: 'Количество отказов'
                  }

              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.0f}'
                      }
                  }
              },

              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
              },

              series: [
                  {
                      name: "Отказы",
                      colorByPoint: true,
                      data: [
                        @foreach ($our_themes as $theme)
                          {
                              name: "{{ $theme->theme->theme }}",
                              y: {{ $theme->count }},
                              drilldown: "{{ $theme->theme->theme }}"
                          },
                        @endforeach
                      ]
                  }
              ],
              drilldown: {
                  breadcrumbs: {
                      position: {
                          align: 'right'
                      }
                  },
                  series: [
                      @foreach ($our_themes as $theme)
                        {
                          name: "Отказы",
                          id: "{{ $theme->theme->theme }}",
                          data: [
                            @foreach ($theme->dates as $date => $value)
                              [
                                  "{{ $date }}",
                                  {{ count($value) }}
                              ],
                            @endforeach
                          ]
                        },
                      @endforeach
                  ]
              }
          });
        });
      </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container3"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container3', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Причины отказов @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на причину, чтобы увидеть статистику по ней по датам'
              },
              accessibility: {
                  announceNewData: {
                      enabled: true
                  }
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: 'Количество отказов'
                  }

              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.0f}'
                      }
                  }
              },

              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
              },

              series: [
                  {
                      name: "Отказы",
                      colorByPoint: true,
                      data: [
                        @foreach ($our_reasons as $reason)
                          {
                              name: "{{ $reason->reason->reason }}",
                              y: {{ $reason->count }},
                              drilldown: "{{ $reason->reason->reason }}"
                          },
                        @endforeach
                      ]
                  }
              ],
              drilldown: {
                  breadcrumbs: {
                      position: {
                          align: 'right'
                      }
                  },
                  series: [
                      @foreach ($our_reasons as $reason)
                        {
                          name: "Отказы",
                          id: "{{ $reason->reason->reason }}",
                          data: [
                            @foreach ($reason->dates as $date => $value)
                              [
                                  "{{ $date }}",
                                  {{ count($value) }}
                              ],
                            @endforeach
                          ]
                        },
                      @endforeach
                  ]
              }
          });
        });
      </script>
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
