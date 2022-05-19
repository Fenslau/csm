
@if(!empty($items['7700']))
  По состоянию на {{ date('d.m.y H:i') }} лампы превысили ресурс 7700 часов:
  <ul>
  @foreach ($items['7700'] as $item)
      <li>Подразделение: {{ $item['department'] }} Лампа: {{ $item['lampa'] }}</li>
  @endforeach
  </ul>
@endif
@if(!empty($items['8000']))
  По состоянию на {{ date('d.m.y H:i') }} лампы превысили ресурс 8000 часов:
  <ul>
  @foreach ($items['8000'] as $item)
      <li>Подразделение: {{ $item['department'] }} Лампа: {{ $item['lampa'] }}</li>
  @endforeach
  </ul>
@endif
