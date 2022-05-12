По состоянию на {{ date('d.m.y H:i') }} не было ввода данных о температуре холодильников:
<ul>
@foreach ($items as $item)
    <li>Подразделение: {{ $item['department'] }} Холодильник: {{ $item['holodilnik'] }}</li>
@endforeach
</ul>
