@extends('layouts.app')

@section('title-block', 'Электронный документооборот ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('document') }}
      <h4 class="text-center">Электронный документооборот</h4>




    </div>
  </div>
</div>

@endsection
