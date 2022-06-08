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
    <div class="col-lg-6">
      <form class="stat-otkaz" action="{{ route('otkaz-stat') }}" method="GET">
            <div class="d-flex flex-nowrap justify-content-between form-group m-1">
              <label class="mr-3" for="city">Город: </label>
              <select multiple id="city" class="form-control text-truncate chosen-select" data-placeholder="Выберите город" name="city[]">
                @foreach ($cities as $city)
                  <option class="text-truncate" value="{{ $city }}" @if (is_array($request->city) AND in_array($city, $request->city)) selected @endif>{{ $city }}</option>
                @endforeach
              </select>
              <button class="btn btn-sm btn-outline-info text-nowrap shadow-none btn-outline-csm" id="city_all">Выбрать всё</button>
            </div>
            <script>
            $(document).ready(function () {
              $(document).on('click', '#city_all', function (e) {
                  e.preventDefault();
                  $('#city option').prop('selected', true);
                  $('#city').trigger('chosen:updated');
              });
            });
            </script>
          <!-- <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3" for="organization">Организация: </label>
            <select multiple id="organization" class="form-control text-truncate chosen-select" data-placeholder="Выберите организацию" name="organization[]">
              @foreach ($organizations as $organization)
                <option class="text-truncate" value="{{ $organization }}" @if (is_array($request->organization) AND in_array($organization, $request->organization)) selected @endif>{{ $organization }}</option>
              @endforeach
            </select>
          </div> -->


          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3" for="department">Подразделение: </label>
            <select multiple id="department" class="form-control text-truncate chosen-select" data-placeholder="Выберите подразделение" name="department[]">
              @foreach ($departments as $department)
                <option class="text-truncate" value="{{ $department }}" @if (is_array($request->department) AND in_array($department, $request->department)) selected @endif>{{ $department }}</option>
              @endforeach
            </select>
            <button class="btn btn-sm btn-outline-info text-nowrap shadow-none btn-outline-csm" id="department_all">Выбрать всё</button>
          </div>
          <script>
          $(document).ready(function () {
            $(document).on('click', '#department_all', function (e) {
                e.preventDefault();
                $('#department option').prop('selected', true);
                $('#department').trigger('chosen:updated');
            });
          });
          </script>

          <div class="d-flex flex-nowrap justify-content-between form-group m-1">
            <label class="mr-3 text-nowrap" for="omsdms">ПЛТ/ОМС/ДМС: </label>
            <select multiple id="omsdms" class="form-control text-truncate chosen-select" data-placeholder="Выберите из списка" name="omsdms[]">
                <option class="" value="ПЛТ" @if (is_array($request->omsdms) AND in_array("ПЛТ", $request->omsdms)) selected @endif>ПЛТ</option>
                <option class="" value="ОМС" @if (is_array($request->omsdms) AND in_array("ОМС", $request->omsdms)) selected @endif>ОМС</option>
                <option class="" value="ДМС" @if (is_array($request->omsdms) AND in_array("ДМС", $request->omsdms)) selected @endif>ДМС</option>
            </select>
            <button class="btn btn-sm btn-outline-info text-nowrap shadow-none btn-outline-csm" id="omsdms_all">Выбрать всё</button>
          </div>
          <script>
          $(document).ready(function () {
            $(document).on('click', '#omsdms_all', function (e) {
                e.preventDefault();
                $('#omsdms option').prop('selected', true);
                $('#omsdms').trigger('chosen:updated');
            });
          });
          </script>

        <div class="d-flex flex-nowrap justify-content-between form-group m-1">
          <label class="mr-3 text-nowrap" for="theme">Тема отказа: </label>
          <select multiple id="theme" class="form-control text-truncate chosen-select" data-placeholder="Выберите тему отказа" name="theme_id[]">
            @foreach ($themes as $theme)
              <option class="text-truncate" value="{{ $theme->id }}" @if (is_array($request->theme_id) AND in_array($theme->id, $request->theme_id)) selected @endif>{{ $theme->theme }}</option>
            @endforeach
          </select>
          <button class="btn btn-sm btn-outline-info text-nowrap shadow-none btn-outline-csm" id="theme_all">Выбрать всё</button>
        </div>
        <script>
        $(document).ready(function () {
          $(document).on('click', '#theme_all', function (e) {
              e.preventDefault();
              $('#theme option').prop('selected', true);
              $('#theme').trigger('chosen:updated');
          });
        });
        </script>

        <div class="d-flex flex-nowrap justify-content-between form-group m-1">
          <label class="mr-3 text-nowrap" for="reason">Причина отказа: </label>
          <select multiple id="reason" class="form-control text-truncate chosen-select" data-placeholder="Выберите причину отказа" name="reason_id[]">
            @foreach ($reasons as $reason)
              <option class="text-truncate" value="{{ $reason->id }}" @if (is_array($request->reason_id) AND in_array($reason->id, $request->reason_id)) selected @endif>{{ $reason->reason }}</option>
            @endforeach
          </select>
          <button class="btn btn-sm btn-outline-info text-nowrap shadow-none btn-outline-csm" id="reason_all">Выбрать всё</button>
        </div>
        <script>
        $(document).ready(function () {
          $(document).on('click', '#reason_all', function (e) {
              e.preventDefault();
              $('#reason option').prop('selected', true);
              $('#reason').trigger('chosen:updated');
          });
        });
        </script>

        <div class="form-group row m-1 align-items-center">
          С <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_from" @if($request->calendar_from) value="{{ $request->calendar_from }}" @else value="{{ date('Y-m') }}-01" @endif max="{{ date('Y-m-d') }}" min="2022-04-01">
          по <input class="mx-1 w-auto form-control form-control-sm datepicker" type="date" name="calendar_to" @if($request->calendar_from) value="{{ $request->calendar_to }}" @else value="{{ date('Y-m-d') }}" @endif max="{{ date('Y-m-d') }}" min="2022-04-01">
        </div>
        <div class="form-group row m-1">
          <button type="submit" class="btn btn-outline-danger shadow-none flex-grow-1 mr-2 btn-csm">Показать</button>
          <input id="reset" type="reset" class="btn btn-outline-secondary shadow-none" value="Сбросить">
        </div>
      </form>
    </div>
  </div>
<script>
  $(document).ready(function () {
      $(document).on('click', '#reset', function (e) {
        e.preventDefault();
        $('.chosen-select option:selected').removeAttr('selected');
        $('.chosen-select option').prop('selected', false);
        $('.chosen-select').trigger('chosen:updated');
        $('input[name = "calendar_from"]').prop('value', '{{ date('Y-m') }}-01');
        $('input[name = "calendar_to"]').prop('value', '{{ date('Y-m-d') }}');
      });
  });
</script>
  <div class="row">
    <div class="col">
        <figure class="highcharts-figure mt-5">
            <div id="container0.1"></div>
            <p class="highcharts-description">
            </p>
        </figure>
        <script>
          $(document).ready(function () {
              Highcharts.chart('container0.1', {
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'Распределение отказов по городам'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  accessibility: {
                      point: {
                          valueSuffix: '%'
                      }
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b>: {point.y:.0f}'
                          }
                      }
                  },
                  series: [{
                      name: 'Отказы',
                      colorByPoint: true,
                      data: [
                        @foreach ($our_cities as $city)
                        		    {
                                    name: '{{ $city->city }}',
                                    y: {{ $city->count }}
                                },
                        @endforeach
                	    ]
                  }]
              });
            });
        </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
        <figure class="highcharts-figure mt-5">
            <div id="container0.2"></div>
            <p class="highcharts-description">
            </p>
        </figure>
        <script>
          $(document).ready(function () {
              Highcharts.chart('container0.2', {
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'Распределение отказов по способу оплаты'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  accessibility: {
                      point: {
                          valueSuffix: '%'
                      }
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b>: {point.y:.0f}'
                          }
                      }
                  },
                  series: [{
                      name: 'Отказы',
                      colorByPoint: true,
                      data: [
                        @foreach ($our_oplata as $oplata)
                        		    {
                                    name: '{{ $oplata->omsdms }}',
                                    y: {{ $oplata->count }}
                                },
                        @endforeach
                	    ]
                  }]
              });
            });
        </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
        <figure class="highcharts-figure mt-5">
            <div id="container0.3"></div>
            <p class="highcharts-description">
            </p>
        </figure>
        <script>
          $(document).ready(function () {
              Highcharts.chart('container0.3', {
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'Распределение отказов по подразделениям'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  accessibility: {
                      point: {
                          valueSuffix: '%'
                      }
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b>: {point.y:.0f}'
                          }
                      }
                  },
                  series: [{
                      name: 'Отказы',
                      colorByPoint: true,
                      data: [
                        @foreach ($our_departments as $department)
                                {
                                    name: '{{ $department->department }}',
                                    y: {{ $department->count }}
                                },
                        @endforeach
                      ]
                  }]
              });
            });
        </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container1.7"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container1.7', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Распределение отказов по подразделениям с учётом вида оплаты'
              },
              xAxis: {
                  categories: [
                    @foreach ($our_departments as $department)
                    '{{ $department->department }}',
                    @endforeach
                  ]
              },
              yAxis: {
                  min: 0,
                  title: {
                      text: 'Количество отказов'
                  },
                  stackLabels: {
                      enabled: true,
                      style: {
                          fontWeight: 'bold',
                          color: ( // theme
                              Highcharts.defaultOptions.title.style &&
                              Highcharts.defaultOptions.title.style.color
                          ) || 'gray'
                      }
                  }
              },
              legend: {
                  align: 'right',
                  x: -30,
                  verticalAlign: 'top',
                  y: 25,
                  floating: true,
                  backgroundColor:
                      Highcharts.defaultOptions.legend.backgroundColor || 'white',
                  borderColor: '#CCC',
                  borderWidth: 1,
                  shadow: false
              },
              tooltip: {
                  headerFormat: '<b>{point.x}</b><br/>',
                  pointFormat: '{series.name}: {point.y}<br/>Всего: {point.stackTotal}'
              },
              plotOptions: {
                  column: {
                      stacking: 'normal',
                      dataLabels: {
                          enabled: true
                      }
                  }
              },
              series: [
                @foreach ($dep_op as $op => $dep)
                  {
                    name: '{{ $op }}',
                    data: [
                      @foreach ($dep as $value)
                        @if($value > 0) {{ $value }}, @else '', @endif
                      @endforeach
                    ]
                  },
                @endforeach
              ]
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
          <div id="container1.9"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container1.9', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Отказы по подразделениям и <b>темам</b> @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на подразделение, чтобы увидеть статистику по темам отказов этого подразделения'
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
                            @foreach ($department->themes as $theme)
                              [
                                  "{{ $theme->theme->theme }}",
                                  {{ $theme->count }}
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
          <div id="container1.95"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container1.95', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Отказы по подразделениям и <b>причинам</b> @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на подразделение, чтобы увидеть статистику по причинам отказов этого подразделения'
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
                            @foreach ($department->reasons as $reason)
                              [
                                  "{{ $reason->reason->reason }}",
                                  {{ $reason->count }}
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
          <div id="container2.05"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container2.05', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Распределение отказов по темам с учётом вида оплаты'
              },
              xAxis: {
                  categories: [
                    @foreach ($our_themes as $theme)
                    '{{ $theme->theme->theme }}',
                    @endforeach
                  ]
              },
              yAxis: {
                  min: 0,
                  title: {
                      text: 'Количество отказов'
                  },
                  stackLabels: {
                      enabled: true,
                      style: {
                          fontWeight: 'bold',
                          color: ( // theme
                              Highcharts.defaultOptions.title.style &&
                              Highcharts.defaultOptions.title.style.color
                          ) || 'gray'
                      }
                  }
              },
              legend: {
                  align: 'right',
                  x: -30,
                  verticalAlign: 'top',
                  y: 25,
                  floating: true,
                  backgroundColor:
                      Highcharts.defaultOptions.legend.backgroundColor || 'white',
                  borderColor: '#CCC',
                  borderWidth: 1,
                  shadow: false
              },
              tooltip: {
                  headerFormat: '<b>{point.x}</b><br/>',
                  pointFormat: '{series.name}: {point.y}<br/>Всего: {point.stackTotal}'
              },
              plotOptions: {
                  column: {
                      stacking: 'normal',
                      dataLabels: {
                          enabled: true
                      }
                  }
              },
              series: [
                @foreach ($theme_op as $op => $theme)
                  {
                    name: '{{ $op }}',
                    data: [
                      @foreach ($theme as $value)
                        @if($value > 0) {{ $value }}, @else '', @endif
                      @endforeach
                    ]
                  },
                @endforeach
              ]
          });
        });
      </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container2.09"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container2.09', {
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
          <div id="container2.1"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container2.1', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Темы отказов и <b>подразделения</b>, к которым они относятся @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на тему, чтобы увидеть в каких подразделениях она была зафиксирована'
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
                            @foreach ($theme->departments as $department)
                              [
                                  "{{ $department->department }}",
                                  {{ $department->count }}
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
          <div id="container3.05"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container3.05', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Распределение отказов по причинам с учётом вида оплаты'
              },
              xAxis: {
                  categories: [
                    @foreach ($our_reasons as $reason)
                    '{{ $reason->reason->reason }}',
                    @endforeach
                  ]
              },
              yAxis: {
                  min: 0,
                  title: {
                      text: 'Количество отказов'
                  },
                  stackLabels: {
                      enabled: true,
                      style: {
                          fontWeight: 'bold',
                          color: ( // theme
                              Highcharts.defaultOptions.title.style &&
                              Highcharts.defaultOptions.title.style.color
                          ) || 'gray'
                      }
                  }
              },
              legend: {
                  align: 'right',
                  x: -30,
                  verticalAlign: 'top',
                  y: 25,
                  floating: true,
                  backgroundColor:
                      Highcharts.defaultOptions.legend.backgroundColor || 'white',
                  borderColor: '#CCC',
                  borderWidth: 1,
                  shadow: false
              },
              tooltip: {
                  headerFormat: '<b>{point.x}</b><br/>',
                  pointFormat: '{series.name}: {point.y}<br/>Всего: {point.stackTotal}'
              },
              plotOptions: {
                  column: {
                      stacking: 'normal',
                      dataLabels: {
                          enabled: true
                      }
                  }
              },
              series: [
                @foreach ($reason_op as $op => $reason)
                  {
                    name: '{{ $op }}',
                    data: [
                      @foreach ($reason as $value)
                        @if($value > 0) {{ $value }}, @else '', @endif
                      @endforeach
                    ]
                  },
                @endforeach
              ]
          });
        });
      </script>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container3.09"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container3.09', {
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

  <div class="row">
    <div class="col">
      <figure class="highcharts-figure mt-5">
          <div id="container3.1"></div>
          <p class="highcharts-description">
          </p>
      </figure>
      <script>
        $(document).ready(function () {
          Highcharts.chart('container3.1', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'Причины отказов и <b>подразделения</b>, к которым они относятся @empty($request->calendar_from) @else c {{ date('d.m', strtotime($request->calendar_from)) }} @endempty @empty($request->calendar_to) @else по {{ date('d.m', strtotime($request->calendar_to)) }} @endempty @if(empty($request->calendar_to) && empty($request->calendar_from)) за текущий месяц @endempty'
              },
              subtitle: {
                  text: 'Нажмите на причину, чтобы увидеть подразделения, где она была зафиксирована'
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
                            @foreach ($reason->departments as $department)
                              [
                                  "{{ $department->department }}",
                                  {{ $department->count }}
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
