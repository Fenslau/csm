По состоянию на {{ date('d.m.y H:i') }} не было ввода данных по лампам:
<ul>
@foreach ($items as $item)
    <li>Подразделение: {{ $item['department'] }} Лампа: {{ $item['lampa'] }}</li>
@endforeach
</ul>
