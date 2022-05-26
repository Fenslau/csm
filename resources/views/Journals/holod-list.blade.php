@extends('layouts.app')

@section('title-block', 'Список холодильников по подразделениям')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('journal-holod-list') }}

      <h4 class="mb-3 text-center">Добавить новый холодильник</h4>
      <form action="{{ route('journal-holod-new') }}" method="post">
        @csrf
        <div class="input-group mb-3 align-items-baseline">
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
          <input type="text" autocomplete="off" class="form-control form-control-sm border-success border-right-0 form-control" name="holodilnik" placeholder="Холодильник">
          <div class="input-group-append">
            <button class="btn btn-sm btn-outline-success text-nowrap shadow-none btn-csm" type="submit">Добавить</button>
          </div>
        </div>
      </form>

      <h4 class="text-center mb-3">Список холодильников по подразделениям</h4>
      <div class="table-responsive">
        <table class="d-table table table-striped table-bordered table-hover table-sm table-responsive group-table">
            <thead class="thead-dark">
              <tr class="text-center">
                <th class="">№</th>
                <th class="">Подразделение</th>
                <th>Холодильник</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              @forelse ($items as $item)
                <tr class="lh-md text-center">
                  <td class="">{{ $loop->iteration }}</td>
                  <td class="text-truncate">{{ $item['department'] }}</td>
                  <td>{{ $item['holodilnik'] }}</td>
                  <td><a onclick="if (confirm('Подтвердить')) {return true;} else {return false;}" class="btn btn-sm btn-outline-danger del-holodilnik" href="{{ route('journal-holod-del') }}/?department={{ $item['department'] }}&holodilnik={{ $item['holodilnik'] }}">Удалить</a></td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="4">Ни одного холодильника не заведено</td>
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
                  "targets": 3,
                  "orderable": false
                  }
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
