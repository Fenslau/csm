<table class="d-table table table-striped table-bordered table-hover table-sm table-responsive group-table">
    <thead class="thead-dark">
      <tr class="text-center">
        <th rowspan="2" class="">№</th>
        <th rowspan="2" class="printable">Дата</th>
        <!-- <th rowspan="2" class="d-none view-all">Время</th>

        <th rowspan="2" class="d-none view-all">Город</th> -->
        <!-- <th class="d-none view-all">Ограниазция</th> -->

        <!-- <th rowspan="2" class="">Подразделение</th>
        <th rowspan="2" class="">Лампа</th> -->
        <th rowspan="2" class="printable">Условия обеззараживания</th>
        <th rowspan="2" class="printable">Режим облучения</th>
        <th colspan="2" class="printable">Время</th>
        <th rowspan="2" class="printable">Длительность, мин.</th>
        <th rowspan="2" class="printable">Регистратор</th>
      </tr>
      <tr>
        <th class="printable">Вкл</th>
        <th class="printable">Выкл</th>
      </tr>
    </thead>
    <tfoot class="d-none">
       <tr>
         <td></td>
         <td></td>
         <td>Данные верны.</td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td class="">Подпись _____________ @empty($items[0]->user->name) @else{{ $items[0]->user->name }}@endempty</td>
       </tr>
    </tfoot>
    <tbody>
      @forelse ($items as $item)
        @if ($item['time'] == 'Вечер') @continue @endif
        <tr class="lh-md text-center">
          <td class="">{{ $loop->iteration }}</td>
          <td>{{ date('d.m.y', strtotime($item['created_at'])) }}</td>
          <!-- <td class="d-none view-all">{{ date('H:i', strtotime($item['created_at'])) }}</td>

          <td class="d-none view-all">{{ $item['city'] }}</td> -->
          <!-- <td class="text-truncate">{{ $item['organization'] }}</td> -->

          <!-- <td class="text-truncate">{{ $item['department'] }}</td>
          <td>{{ $item['lampa'] }}</td> -->
          <td>{{ $item['condition'] }}</td>
          <td>{{ $item['rad_mode'] }}</td>
          <td>{{ substr($item['time_on'], 0, 5) }}</td>
          <td>{{ substr($item['time_off'], 0, 5) }}</td>
          <td>{{ $item['duration'] }}</td>
          <td>{{ $item->user->name }}</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="10">Ни одной записи в журналах не зарегистрировано</td>
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
          }
       ],
       dom: 'Bfrtip',
       buttons: [
               {
                   extend: 'excel',
                   className: 'btn btn-sm btn-success shadow-none border-0',
                   text: 'Excel',
                   exportOptions: {
                      columns: '.printable'
                   },
                   title: 'Учёт работы бактерицидной установки @empty($items[0]['lampa']) @else{{ $items[0]['lampa'] }}@endempty отдела @empty($items[0]['department']) @else{{ $items[0]['department'] }}@endempty',
                   messageBottom: 'Данные верны. @empty($items[0]->user->name) @else{{ $items[0]->user->name }}@endempty. Подпись _____________',

               },
               {
                   extend: 'print',
                   className: 'btn btn-sm btn-info shadow-none btn-csm',
                   text: 'Печать',
                   footer: true,
                   customize: function ( win, tbl ) {
                      $(win.document.body).find( 'td, th' ).addClass( 'text-center' );

                   },
                   exportOptions: {
                      columns: '.printable'
                   },
                   title: 'Учёт работы бактерицидной установки @empty($items[0]['lampa']) @else{{ $items[0]['lampa'] }}@endempty отдела @empty($items[0]['department']) @else{{ $items[0]['department'] }}@endempty',
               }
           ],

          "autoWidth": false
        });
    } );
</script>
