@extends('layouts.app')

@section('title-block', 'Список ламп по подразделениям')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('journal-lampa-list') }}

      <h4 class="mb-3 text-center">Добавить новую лампу</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form action="{{ route('journal-lampa-new') }}" method="post">
        @csrf
        <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
          <label class="mr-3 d-none d-md-inline" for="department">Подразделение: </label>
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
          <input type="text" autocomplete="off" class="form-control form-control-sm form-control" name="lampa" placeholder="Инв.номер">
        </div>
        <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1 my-2">
          <input type="text" autocomplete="off" class="form-control form-control-sm form-control" name="duration_all" placeholder="Наработка на данный момент">
        </div>
        <div class="form-group row m-1 my-3">
            <button type="submit" @auth @else disabled @endauth class="btn btn btn-outline-success shadow-none flex-grow-1 btn-csm">Добавить</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h4 class="text-center my-3">Список ламп по подразделениям</h4>
      <div class="table-responsive">
        <table class="d-table table table-striped table-bordered table-hover table-sm table-responsive group-table">
            <thead class="thead-dark">
              <tr class="text-center">
                <th class="">№</th>
                <th class="">Подразделение</th>
                <th>Лампа</th>
                <th>Наработка, час</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              @forelse ($items as $item)
                <tr class="lh-md text-center">
                  <td class="">{{ $loop->iteration }}</td>
                  <td class="text-truncate">{{ $item['department'] }}</td>
                  <td>{{ $item['lampa'] }}</td>
                  <td>{{round($item['duration_all']/60, 0) }}</td>
                  <td><a onclick="if (confirm('Подтвердить')) {return true;} else {return false;}" class="btn btn-sm btn-outline-danger zamena-lampy" href="{{ route('zamena-lampy') }}/?department={{ $item['department'] }}&lampa={{ $item['lampa'] }}">Заменить</a></td>
                  <td><a onclick="if (confirm('Подтвердить')) {return true;} else {return false;}" class="btn btn-sm btn-outline-danger del-lampa" href="{{ route('journal-lampa-del') }}/?department={{ $item['department'] }}&lampa={{ $item['lampa'] }}">Удалить</a></td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="5">Ни одной лампы не заведено</td>
                </tr>
              @endforelse
            </tbody>
        </table>
        <script>
            $(document).ready( function () {
                  $(".group-table").DataTable({
                  "language": {
                          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
                      },
                  "lengthMenu": [ 50, 100, 200, 500 ],
                  "pageLength": 50,
                  "columnDefs": [ {
                  "targets": 4,
                  "orderable": false
                  },
                  {
                  "targets": 5,
                  "orderable": false
                  },
               ],
                  "autoWidth": false
                });
            } );
        </script>
      </div>
    </div>
  </div>
</div>
@endsection
