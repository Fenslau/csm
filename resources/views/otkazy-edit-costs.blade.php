@extends('layouts.app')

@section('title-block', 'Редактирование причин отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('cost') }}
      <h4 class="mb-3 text-center">Редактирование стоимости отказов</h4>

    </div>
  </div>
</div>

@endsection
