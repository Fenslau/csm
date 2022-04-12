<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="city{{ $multiple }}">Город: </label>
  <select id="city{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите город" name="city{{ $arr }}">
    <option @selected('Томск', session('city'))>Томск</option>
    <option @selected('Красноярск', session('city'))>Красноярск</option>
  </select>
</div>

<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="organization{{ $multiple }}">Организация: </label>
  <select id="organization{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите организацию" name="organization{{ $arr }}">
    <option @selected('Санталь', session('organization'))>Санталь</option>
    <option @selected('ЦСМ', session('organization'))>ЦСМ</option>
  </select>
</div>

<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="division{{ $multiple }}">Подразделение: </label>
  <select id="division{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите подразделение" name="division{{ $arr }}">
    <option @selected('Стоматология', session('division'))>Стоматология</option>
    <option @selected('Педиатрия', session('division'))>Педиатрия</option>
  </select>
</div>

<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="group{{ $multiple }}">Группа: </label>
  <select id="group{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите группу" name="group{{ $arr }}">
    <option @selected('1', session('group'))>Специалисты</option>
    <option @selected('2', session('group'))>Медицинские услуги</option>
  </select>
</div>

<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="theme{{ $multiple }}">Тема: </label>
  <select id="theme{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите тему" name="theme{{ $arr }}">
    <option @selected('Гастроэнтеролог', session('theme'))>Гастроэнтеролог</option>
    <option @selected('Проктолог', session('theme'))>Проктолог</option>
    <option @selected('Терапевт', session('theme'))>Терапевт</option>
    <option @selected('Уролог', session('theme'))>Уролог</option>
    <option @selected('Кардиолог', session('theme'))>Кардиолог</option>
    <option @selected('Эндокринолог', session('theme'))>Эндокринолог</option>
    <option @selected('УЗИ', session('theme'))>УЗИ</option>
    <option @selected('УЗИ гинеколог', session('theme'))>УЗИ гинеколог</option>
    <option @selected('ФГДС', session('theme'))>ФГДС</option>
    <option @selected('КОВИД ПЦР тест', session('theme'))>КОВИД ПЦР тест</option>
  </select>
</div>

<div class="d-flex justify-content-between form-group row m-1">
  <label class="mr-3" for="reason{{ $multiple }}">Причина: </label>
  <select id="reason{{ $multiple }}" {{ $multiple }} class="form-control w-auto overflow-auto chosen-select" data-placeholder="Выберите причину отказа" name="reason_id{{ $arr }}">
    @empty($multiple)<option value="">Выберите причину</option>@endempty
    @forelse ($reasons as $reason)
      <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
    @empty
    @endforelse
  </select>
</div>
