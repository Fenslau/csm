<table class="d-table table table-striped table-bordered table-hover table-sm table-responsive group-table">
    <thead class="thead-dark">
      <tr class="text-center">
        <th class="d-none view-all">№</th>
        <th>Дата</th>
        <th>Время</th>

        <th class="d-none view-all">Город</th>
        <th class="d-none view-all">Ограниазция</th>

        <th>Тема</th>
        <th>Причина</th>
        <th>Подразделение</th>

        <th class="d-none view-all">Регистратор</th>
        <th>Отказы</th>
      </tr>
    </thead>

    <tbody>
      @forelse ($items as $item)
        <tr class="lh-md text-center">
          <td class="d-none view-all">{{ $loop->iteration }}</td>
          <td>{{ date('d.m.y', strtotime($item['maxdate'])) }}</td>
          <td>{{ date('H:i', strtotime($item['maxdate'])) }}</td>

          <td class="d-none view-all">{{ $item['city'] }}</td>
          <td class="text-truncate d-none view-all">{{ $item['organization'] }}</td>

          <td>{{ $item->theme->theme }}</td>
          <td>{{ $item->reason->reason }}</td>
          <td class="text-truncate">{{ $item['department'] }}</td>

          <td class="d-none view-all">{{ $item->user->name }}</td>
          <td>{{ $item->count }}</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="6">Ни одного отказа не зарегистрировано</td>
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
          // "targets": 1,
          // "orderable": false
          } ],

          "autoWidth": false
        });
    } );
</script>
