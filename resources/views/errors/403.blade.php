@extends('layouts.app')

@section('title-block',  'Доступ запрещён')

@section('content')
<h2 class="m-3 text-center h4">Доступ запрещён</h2>
<div class="alert alert-warning">
  Вы не авторизованы для этого действия. {!! $exception->getMessage() !!}. Если вы считаете, что права должны быть, обратитесь к администратору сервиса
</div>
<div class="text-center">
  <input class="btn btn-success" type="button" onclick="history.back();" value="Назад"/>
</div>
@endsection
