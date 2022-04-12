<table class="d-table table table-striped table-bordered table-hover table-sm table-responsive">
    <thead class="thead-dark">
      <tr class="text-center">
        <th>№</th>
        <th>Город</th>
        <th>Ограниазция</th>
        <th>Подразделение</th>
        <th>Регистратор</th>
        <th>Группа</th>
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
          <td>{{ $item['division'] }}</td>
          <td>{{ $item->user->employee['user_name'] }} {{ $item->user->employee['user_surname'] }}</td>
          <td>
              @if($item['group'] == 1) Специалисты @endif
              @if($item['group'] == 2) Медицинские услуги @endif
          </td>
          <td>{{ $item['theme'] }}</td>
          <td>{{ $item->reason->reason }}</td>
          <td>{{ date('d.m.y', strtotime($item['created_at'])) }}</td>
          <td>{{ date('H:i', strtotime($item['created_at'])) }}</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="10">Ни одного откаа не зарегистрировано</td>
        </tr>
      @endforelse
    </tbody>
</table>
