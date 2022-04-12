@extends('layouts.app')

@section('title-block', 'Процедурный кабинет ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('procedure') }}
      <h4 class="text-center">Процедурный кабинет</h4>




    </div>
  </div>
</div>

@endsection
