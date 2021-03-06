<table class="d-table table table-striped table-bordered table-hover table-sm table-responsive">
    <thead class="thead-dark">
      <tr class="text-center">
        <th>№</th>
        <th>Город</th>
        <th>Ограниазция</th>
        <th>Подразделение</th>
        <th>Регистратор</th>

        <th>Тема</th>
        <th>Причина</th>
        <th>Дата</th>
        <th>Время</th>
      </tr>
    </thead>

    <tbody>
      @forelse ($items as $item)
        <tr class="lh-md text-center">
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item['city'] }}</td>
          <td>{{ $item['organization'] }}</td>
          <td>{{ $item['department'] }}</td>
          <td>{{ $item->user->name }}</td>

          <td>{{ $item->theme->theme }}</td>
          <td>{{ $item->reason->reason }}</td>
          <td>{{ date('d.m.y', strtotime($item['created_at'])) }}</td>
          <td>{{ date('H:i', strtotime($item['created_at'])) }}</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="10">Ни одного отказа не зарегистрировано</td>
        </tr>
      @endforelse
    </tbody>
</table>
