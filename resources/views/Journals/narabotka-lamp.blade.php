@extends('layouts.app')

@section('title-block', 'Наработка ламп бактерицидных установок')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('journal-lampa-narabotka') }}
      <h4 class="text-center mb-3">Наработка ламп бактерицидных установок</h4>
      <div class="table-responsive">
          <table class="d-table table table-striped table-bordered table-hover table-sm table-responsive group-table">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th>№</th>
                  <th>Подразделение</th>
                  <th>Помещение/лампа</th>
                  <th>Наработка, час</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($items as $item)
                  <tr class="lh-md text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-truncate">{{ $item['department'] }}</td>
                    <td>{{ $item['lampa'] }}</td>
                    <td>{{ round($item['duration_all']/60, 0) }}</td>
                    <td><a onclick="if (confirm('Подтвердить')) {return true;} else {return false;}" class="btn btn-sm btn-outline-danger zamena-lampy" href="{{ route('zamena-lampy') }}/?department={{ $item['department'] }}&lampa={{ $item['lampa'] }}">Заменить</a></td>
                  </tr>
                @empty
                  <tr>
                    <td class="text-center" colspan="5">Ни одной записи в журнале не зарегистрировано</td>
                  </tr>
                @endforelse
              </tbody>
          </table>
      </div>
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
                }
                ],

                "autoWidth": false
              });
          } );
      </script>
    </div>
  </div>
</div>
@endsection
